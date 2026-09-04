@extends('layouts.guest')

{{-- Custom CSS --}}
@section('custom-css')
<title>{{ __('Register') }}</title>
@endsection

@section('content')

@php
// Settings
use App\Models\Setting;
$setting = Setting::where('status', 1)->first();
@endphp

{{-- Register --}}
<section class="relative pt-16 pb-0 md:py-22 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto mb-16">
        <div class="w-full md:w-3/5 lg:w-full">
            <div class="max-w-sm mx-auto">
                <div class="mb-6 text-center">
                    <a class="inline-block mb-6" href="{{ route('web.index') }}">
                        <img class="h-16" src="{{ asset($setting->site_logo) }}" alt="{{ config('app.name') }}">
                    </a>
                    <h3 class="mb-4 text-2xl md:text-3xl font-bold">{{ __('Join the PetaQR community') }}</h3>
                    <p class="text-lg text-gray-500 font-medium">{{ __('Start your journey with us') }}</p>
                </div>
                {{-- Sign up with Google --}}
                @if (env('GOOGLE_ENABLE') == 'on')
                <a href="{{ route('login.google') }}"
                    style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;
                           background:#131314;border:1px solid #8e918f;color:#e3e3e3;font-weight:600;
                           font-size:15px;line-height:1.5;padding:12px 16px;
                           border-radius:.75rem .75rem 0 .75rem;text-decoration:none;">
                    <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" style="flex:none">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    <span>{{ __('Sign up with Google') }}</span>
                </a>

                <div style="display:flex;align-items:center;gap:12px;margin:18px 0 4px;">
                    <span style="flex:1;height:1px;background:#e5e7eb"></span>
                    <span style="font-size:12px;color:#9aa0a6;font-weight:500">{{ __('or') }}</span>
                    <span style="flex:1;height:1px;background:#e5e7eb"></span>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-6">
                        <label class="block mb-2 text-gray-800 font-medium" for="name">{{ __('Name') }}*</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-gray-900 border border-gray-200 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-{{ $config[11]->config_value }}-500 focus:ring-opacity-50 @error('name') is-invalid @enderror"
                            type="name" id="name" placeholder="{{ __('Your name') }}" name="name" value="{{ old('name') }}"
                            required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="block mb-2 text-gray-800 font-medium" for="email">{{ __('Email') }}*</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-gray-900 border border-gray-200 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-{{ $config[11]->config_value }}-500 focus:ring-opacity-50 @error('email') is-invalid @enderror"
                            type="email" id="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email" placeholder="{{ __('your@email.com') }}">

                        @error('email')
                        <span class="invalid-feedback mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-1">
                        <label class="block mb-2 text-gray-800 font-medium" for="password">{{ __('Password') }}*</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-gray-900 border border-gray-200 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-{{ $config[11]->config_value }}-500 focus:ring-opacity-50 @error('password') is-invalid @enderror"
                            type="password" name="password" id="password" required autocomplete="new-password"
                            placeholder="{{ __('************') }}">

                        @error('password')
                        <span class="invalid-feedback mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <a class="ml-7 text-xs text-gray-800 font-medium float-right cursor-pointer" title="Show password"
                            data-bs-toggle="tooltip" onclick="showPassword()">{{ __('Show / Hide Password')}}</a>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-1">
                        <label class="block mb-2 text-gray-800 font-medium" for="password-confirm">{{ __('Confirm Password') }}*</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-gray-900 border border-gray-200 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-{{ $config[11]->config_value }}-500 focus:ring-opacity-50 @error('password') is-invalid @enderror"
                            type="password" name="password_confirmation" id="password-confirm" required
                            autocomplete="new-password" placeholder="{{ __('************') }}">
                    </div>
                    <div class="mb-12">
                        <a class="ml-7 text-xs text-gray-800 font-medium float-right cursor-pointer" title="Show password"
                            data-bs-toggle="tooltip" onclick="showConfirmPassword()">{{ __('Show / Hide Password')}}</a>
                    </div>

                    {{-- Google Recaptcha : v2 Checkbox --}}
                    @if ($settings['recaptcha_configuration']['RECAPTCHA_ENABLE'] == 'on')
                    <div
                        class="mb-8 {{(App::isLocale('ar') || App::isLocale('ur') || App::isLocale('he') ? 'recaptcha' : '')}}">
                        {!! htmlFormSnippet() !!}
                    </div>
                    @endif

                    <button type="submit"
                        class="inline-block py-3 px-7 mb-6 lg:mb-0 lg:mr-3 w-full lg:full py-2 px-6 leading-loose bg-{{ $config[11]->config_value }}-500 hover:bg-{{ $config[11]->config_value }}-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center">{{
                        __('Sign Up') }}</button>

                    <p class="text-center">
                        <span class="text-xs font-medium">{{ __('Already have an account?') }}</span>
                        <a class="inline-block text-xs font-medium text-{{ $config[11]->config_value }}-500 hover:text-{{ $config[11]->config_value }}-600 hover:underline"
                            href="{{ route('login') }}">{{ __('Please sign in here') }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Show / Hide Password --}}
@section('custom-js')
<script>
    function showPassword() {
        "use strict";
        var temp = document.getElementById("password");
        if (temp.type === "password") {
            temp.type = "text";
        } else {
            temp.type = "password";
        }
    }

    function showConfirmPassword() {
        "use strict";
        var temp = document.getElementById("password-confirm");
        if (temp.type === "password") {
            temp.type = "text";
        } else {
            temp.type = "password";
        }
    }
</script>
@endsection
@endsection