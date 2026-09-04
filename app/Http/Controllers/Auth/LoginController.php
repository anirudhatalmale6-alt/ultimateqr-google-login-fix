<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Config;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // User authentication
    public function authenticated()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    // Show login form
    public function showLoginForm()
    {
        $config = Config::get();
        $settings = Setting::first();

        // Recaptcha Configuration
        $recaptcha_configuration = [
            'RECAPTCHA_ENABLE' => env('RECAPTCHA_ENABLE', ''),
            'RECAPTCHA_SITE_KEY' => env('RECAPTCHA_SITE_KEY', ''),
            'RECAPTCHA_SECRET_KEY' => env('RECAPTCHA_SECRET_KEY', ''),
            'RECAPTCHA_SKIP_IP' => env('RECAPTCHA_SKIP_IP', '[]'),
        ];

        $settings['recaptcha_configuration'] = $recaptcha_configuration;

        return view('auth.login', compact('config', 'settings'));
    }

    // Login redirect
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google login callback
    public function handleProviderCallback()
    {
        // Diagnostic switch. Put GOOGLE_DEBUG=on in .env to see the real reason
        // on screen. With it absent or off the behaviour is exactly as before.
        $debug = env('GOOGLE_DEBUG') == 'on';

        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            // The original code threw this away, which is why a failed Google
            // sign-in looked like nothing had happened at all.
            Log::error('[GOOGLE-LOGIN] ' . get_class($e) . ': ' . $e->getMessage());

            if ($debug) {
                return response("Google sign-in failed while talking back to Google.\n\n"
                    . "Type:    " . get_class($e) . "\n"
                    . "Message: " . $e->getMessage() . "\n\n"
                    . $this->googleCredentialReport(), 500)
                    ->header('Content-Type', 'text/plain; charset=utf-8');
            }

            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            if ($existingUser->status == 1) {
                // log them in
                auth()->login($existingUser, true);
            } else {
                Log::error('[GOOGLE-LOGIN] account exists for ' . $user->email
                    . ' but its status is ' . $existingUser->status . ' (1 = active)');

                if ($debug) {
                    return response("Google sign-in was accepted, but the site refused it.\n\n"
                        . "An account already exists for " . $user->email . "\n"
                        . "and its status is " . $existingUser->status . " (it must be 1 to sign in).\n", 500)
                        ->header('Content-Type', 'text/plain; charset=utf-8');
                }

                return redirect('/login');
            }

        } else {
        // create a new user
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->profile_image = $user->avatar;
            // Was bcrypt($newUser->user_id). That property does not exist on a
            // new model, so every Google account was saved with the hash of an
            // empty string. A long random value is correct here - these accounts
            // sign in through Google, not with a password.
            $newUser->password = bcrypt(Str::random(40));
            $newUser->auth_type = "Google";
            $newUser->role_id = 2;
            // Google has already confirmed this address, so do not make the
            // person go through email verification a second time.
            $newUser->email_verified_at = now();
            $newUser->save();
            auth()->login($newUser, true);
            Log::info('[GOOGLE-LOGIN] created new account for ' . $user->email);
        }

        // /user/dashboard only admits role_id 2, so an administrator who signed
        // in with Google was thrown straight back out to the login page.
        if (auth()->check() && auth()->user()->role_id == 1) {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/user/dashboard');
    }

    /**
     * Reports what the application ACTUALLY resolved for the Google
     * credentials - which is not always what you think you saved. Socialite
     * reads config('services.google'), so that is what is read back here.
     *
     * The secret itself is never printed. Only its length and the same last
     * four characters that the Google console shows you.
     *
     * Only ever reachable with GOOGLE_DEBUG=on in .env.
     */
    private function googleCredentialReport()
    {
        $id       = (string) config('services.google.client_id');
        $secret   = (string) config('services.google.client_secret');
        $redirect = (string) config('services.google.redirect');

        $out  = "----- WHAT THE SITE ACTUALLY SENT TO GOOGLE -----\n\n";
        $out .= "Client ID: " . ($id === '' ? '(EMPTY)' : $id) . "\n";
        $out .= "Redirect:  " . ($redirect === '' ? '(EMPTY)' : $redirect) . "\n\n";

        if ($secret === '') {
            $out .= "Client secret: (EMPTY - the site sent no secret at all)\n";
        } else {
            $out .= "Client secret length: " . strlen($secret) . " characters\n";
            $out .= "Client secret starts: " . substr($secret, 0, 7) . "\n";
            $out .= "Client secret ends:   [" . substr($secret, -4) . "]"
                 .  "   <-- compare THIS with the console\n";

            if ($secret !== trim($secret)) {
                $out .= "WARNING: there is a space or a line break wrapped around the secret.\n";
            }
            if (strpos($secret, '"') !== false || strpos($secret, "'") !== false) {
                $out .= "WARNING: the secret still has a quote character inside it.\n";
            }
        }

        // The usual reason for "I changed it and nothing happened": the key is
        // in .env more than once. Laravel keeps the FIRST one it reads and
        // ignores every later one, so a new value pasted at the bottom of the
        // file is thrown away without a word.
        $envPath = base_path('.env');

        if (is_readable($envPath)) {
            $counts = [
                'GOOGLE_CLIENT_ID'     => 0,
                'GOOGLE_CLIENT_SECRET' => 0,
                'GOOGLE_REDIRECT'      => 0,
                'GOOGLE_ENABLE'        => 0,
            ];

            foreach (file($envPath) as $line) {
                foreach (array_keys($counts) as $key) {
                    if (preg_match('/^\s*(?:export\s+)?' . $key . '\s*=/', $line)) {
                        $counts[$key]++;
                    }
                }
            }

            $out .= "\nLines found in .env:\n";
            foreach ($counts as $key => $n) {
                $out .= "  " . str_pad($key, 22) . $n;
                if ($n === 0) {
                    $out .= "   <-- MISSING";
                } elseif ($n > 1) {
                    $out .= "   <-- DUPLICATE. Only the FIRST is used, the others are ignored.";
                }
                $out .= "\n";
            }
        } else {
            $out .= "\n(.env could not be read from here)\n";
        }

        if (file_exists(base_path('bootstrap/cache/config.php'))) {
            $out .= "\nNOTE: a cached config file exists at bootstrap/cache/config.php.\n"
                 .  "While that file is there, edits to .env may be ignored. Delete it.\n";
        }

        $out .= "\nNothing above reveals the secret. The last 4 characters are what the\n"
             .  "Google console shows you as well, which is why they are here.\n";

        return $out;
    }
}
