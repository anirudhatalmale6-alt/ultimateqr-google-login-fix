<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Google One Tap.
 *
 * The prompt in the corner of the screen hands the browser a signed ID token.
 * This controller checks that token really came from Google and really was
 * issued to this site, and only then signs the person in.
 *
 * The whole security of One Tap rests on that check. A token is just a string
 * in a POST body - anyone can send one. What they cannot do is forge Google's
 * signature on it. So the signature is verified against Google's own published
 * public keys, and the token is rejected unless every one of these holds:
 *
 *   - the signature matches a current Google signing key
 *   - "iss" (who issued it) is Google
 *   - "aud" (who it was issued FOR) is this site's client ID, not someone
 *     else's - without this check a token minted for any other website would
 *     be accepted here
 *   - it has not expired
 *   - the email address on it is one Google has itself verified
 *
 * Deliberately NOT done here: nothing is trusted from the browser except the
 * token. The name, email and picture are read out of the signed token, never
 * out of the POST body.
 */
class GoogleOneTapController extends Controller
{
    /** Google's public signing keys, JWK format. */
    const CERTS_URL = 'https://www.googleapis.com/oauth2/v3/certs';

    /** Both spellings are valid and Google uses both. */
    const ISSUERS = ['accounts.google.com', 'https://accounts.google.com'];

    /** How long to keep Google's keys before fetching them again. */
    const CERTS_TTL_MINUTES = 360;

    public function store(Request $request)
    {
        // Same master switch as the buttons, plus one of its own so the popup
        // can be turned off on its own without losing the buttons.
        if (env('GOOGLE_ENABLE') != 'on' || env('GOOGLE_ONE_TAP') != 'on') {
            return response()->json(['ok' => false, 'error' => 'Google sign-in is turned off.'], 403);
        }

        // Already signed in - nothing to do. Can happen if the prompt was on
        // screen while the person signed in in another tab.
        if (auth()->check()) {
            return response()->json(['ok' => true, 'redirect' => $this->destination()]);
        }

        $credential = trim((string) $request->input('credential'));
        if ($credential === '') {
            return response()->json(['ok' => false, 'error' => 'No Google credential was sent.'], 400);
        }

        try {
            try {
                $payload = $this->verifyIdToken($credential, $this->googleKeys(), $this->clientId());
            } catch (\UnexpectedValueException $e) {
                // Google rotates its signing keys every few days. When that
                // happens the token is signed with a key we have not cached
                // yet, and it fails either on the signature or on the "kid"
                // lookup. Both mean "fetch the keys again and try once more".
                // Anything else - expired, malformed - is a real refusal and
                // is not retried.
                $rotated = $e instanceof SignatureInvalidException
                    || strpos($e->getMessage(), 'kid') !== false;

                if (!$rotated) {
                    throw $e;
                }

                Log::info('[GOOGLE-ONE-TAP] token did not match the cached Google keys, refetching them');
                $payload = $this->verifyIdToken($credential, $this->googleKeys(true), $this->clientId());
            }
        } catch (\Throwable $e) {
            // Logged with the same [GOOGLE-...] tag style as the sign-in button
            // so both show up together in storage/logs/laravel.log.
            Log::error('[GOOGLE-ONE-TAP] rejected token: ' . get_class($e) . ': ' . $e->getMessage());

            return response()->json([
                'ok'    => false,
                'error' => 'We could not verify that Google sign-in. Please use the Sign in with Google button.',
            ], 401);
        }

        $email = (string) $payload['email'];

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->status != 1) {
                Log::error('[GOOGLE-ONE-TAP] account exists for ' . $email
                    . ' but its status is ' . $existingUser->status . ' (1 = active)');

                return response()->json([
                    'ok'    => false,
                    'error' => 'That account is not active. Please contact support.',
                ], 403);
            }

            auth()->login($existingUser, true);
            Log::info('[GOOGLE-ONE-TAP] signed in existing account ' . $email);
        } else {
            $newUser = new User;
            $newUser->name = $this->displayName($payload);
            $newUser->email = $email;
            $newUser->profile_image = $payload['picture'] ?? null;
            // These accounts sign in through Google and never use this
            // password, but the column is NOT NULL so it needs a value. A long
            // random one means it can never be guessed either.
            $newUser->password = bcrypt(Str::random(40));
            $newUser->auth_type = "Google";
            $newUser->role_id = 2;
            // Google has already confirmed the address - the token would have
            // been rejected above if it had not - so there is no reason to make
            // the person verify it a second time.
            $newUser->email_verified_at = now();
            $newUser->save();

            auth()->login($newUser, true);
            Log::info('[GOOGLE-ONE-TAP] created new account for ' . $email);
        }

        return response()->json(['ok' => true, 'redirect' => $this->destination()]);
    }

    /**
     * Checks the token and returns its contents. Throws on anything at all
     * suspicious - the caller treats any exception as "refuse this sign-in".
     *
     * Kept free of facades and of $this state on purpose, so it can be run
     * against known-good and known-bad tokens outside the application.
     */
    public function verifyIdToken(string $jwt, array $jwks, string $clientId): array
    {
        if ($clientId === '') {
            throw new \RuntimeException('GOOGLE_CLIENT_ID is not set, so there is nothing to check the token against');
        }

        // Shared hosting clocks drift. A minute of tolerance stops a valid
        // token being called expired because the server is 20 seconds fast.
        JWT::$leeway = 60;

        $keys = JWK::parseKeySet($jwks);

        // JWT::decode does the signature, exp and nbf checks and throws if any
        // of them fail. It picks the key by the "kid" in the token header.
        $decoded = JWT::decode($jwt, $keys);

        $payload = (array) $decoded;

        $iss = (string) ($payload['iss'] ?? '');
        if (!in_array($iss, self::ISSUERS, true)) {
            throw new \RuntimeException('token was not issued by Google (iss=' . $iss . ')');
        }

        // The one that matters most. Without it, a token Google issued to some
        // completely different website would be accepted as a login here.
        $aud = (string) ($payload['aud'] ?? '');
        if (!hash_equals($clientId, $aud)) {
            throw new \RuntimeException('token was issued for a different client id');
        }

        if (empty($payload['sub'])) {
            throw new \RuntimeException('token has no subject');
        }

        $email = (string) ($payload['email'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('token carries no usable email address');
        }

        // Google sends this as a real boolean, but accept the string form too
        // rather than let a "true" that arrived as text fail the check.
        $verified = $payload['email_verified'] ?? false;
        if ($verified !== true && $verified !== 'true' && $verified !== 1 && $verified !== '1') {
            throw new \RuntimeException('Google has not verified ' . $email);
        }

        return $payload;
    }

    /**
     * Google's public keys, cached. They rotate every few days, so this is
     * refetched periodically - and immediately if a signature fails to match,
     * which is what a rotation looks like from here.
     */
    private function googleKeys(bool $forceFresh = false): array
    {
        $cacheKey = 'google_one_tap_jwks';

        if ($forceFresh) {
            try {
                Cache::forget($cacheKey);
            } catch (\Throwable $e) {
                // cache unavailable - fetchKeys below still works
            }
        }

        try {
            return Cache::remember($cacheKey, now()->addMinutes(self::CERTS_TTL_MINUTES), function () {
                return $this->fetchKeys();
            });
        } catch (\Throwable $e) {
            // If the cache itself is broken, say so in the log rather than
            // failing the sign-in, and carry on without it. Silence here would
            // mean fetching Google's keys on every single page sign-in with
            // nothing to show why.
            Log::warning('[GOOGLE-ONE-TAP] key cache unavailable, fetching directly: ' . $e->getMessage());

            return $this->fetchKeys();
        }
    }

    private function fetchKeys(): array
    {
        $response = Http::timeout(10)->get(self::CERTS_URL);

        if (!$response->successful()) {
            throw new \RuntimeException('could not fetch Google public keys, HTTP ' . $response->status());
        }

        $body = $response->json();

        if (!is_array($body) || empty($body['keys']) || !is_array($body['keys'])) {
            throw new \RuntimeException('Google public keys came back in an unexpected shape');
        }

        return $body;
    }

    private function clientId(): string
    {
        // Socialite reads config('services.google'), so read the same thing
        // here. If the two ever disagree, the buttons and the popup would be
        // using different credentials, which would be very hard to spot.
        return (string) (config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID', ''));
    }

    private function displayName(array $payload): string
    {
        foreach (['name', 'given_name'] as $key) {
            if (!empty($payload[$key])) {
                return Str::limit((string) $payload[$key], 250, '');
            }
        }

        return Str::before((string) $payload['email'], '@');
    }

    /**
     * /user/dashboard only admits role_id 2, so sending an administrator there
     * bounces them straight back out to the login page.
     */
    private function destination(): string
    {
        return (auth()->check() && auth()->user()->role_id == 1)
            ? url('/admin/dashboard')
            : url('/user/dashboard');
    }
}
