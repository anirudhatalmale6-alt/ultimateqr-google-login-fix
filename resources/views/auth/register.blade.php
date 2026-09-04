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

                    {{-- Create account with Google --}}
                    @if (env('GOOGLE_ENABLE') == 'on')
                    <a class="inline-block mt-3 py-3 px-7 mb-3 lg:mr-3 w-full lg:full py-2 px-6 leading-loose bg-gray-900 hover:bg-gray-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center"
                        href="{{ route('login.google') }}">
                        <span>{{ __('Create account with Google') }}</span>
                    </a>
                    @endif

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