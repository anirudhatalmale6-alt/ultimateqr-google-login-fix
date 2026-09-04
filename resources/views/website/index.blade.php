@extends('layouts.guest')

{{-- Custom JS --}}
@section('custom-js')
<script src="{{ asset('js/smooth-scroll.js')}}"></script>
@endsection

@section('content')
{{-- Topbar --}}
@include('website.includes.topbar')

@php
// Settings
use App\Models\Setting;
use App\Models\Page;
$setting = Setting::where('status', 1)->first();
$page = Page::where('slug', 'home')->get();
@endphp

{{-- Features --}}
<section id="features">
    <div class="skew skew-top mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 10 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-top ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 10 10 0 10 10"></polygon>
        </svg>
    </div>
    <div class="py-20 bg-gray-50 radius-for-skewed">
        <div class="container mx-auto px-4">
            <div class="mb-16 max-w-md mx-auto text-center">
                <span class="text-{{ $config[11]->config_value }}-600 font-bold">{{ __($page[7]->body)
                    }}</span>
                <h2 class="text-4xl lg:text-5xl font-bold font-heading">{{ __($page[8]->body) }}</h2>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="mb-8 lg:mb-0 w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded-lg bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[9]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[10]->body) }}</p>
                    </div>
                </div>
                <div class="w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[11]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[12]->body) }}</p><br><br>
                    </div>
                </div>
                <div class="mb-8 lg:mb-0 w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded-lg bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[13]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[14]->body) }}</p><br>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap -mx-4 mt-4">
                <div class="mb-8 lg:mb-0 w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded-lg bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[15]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[16]->body) }}</p>
                    </div>
                </div>
                <div class="w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[17]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[18]->body) }}</p>
                    </div>
                </div>
                <div class="mb-8 lg:mb-0 w-full lg:w-1/3 px-4">
                    <div class="py-12 px-6 bg-white rounded shadow text-center">
                        <span class="mb-6 inline-block p-2 rounded-lg bg-{{ $config[11]->config_value }}-100">
                            <svg class="w-10 h-10 text-{{ $config[11]->config_value }}-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="px-8 mb-4 text-2xl font-bold font-heading">{{ __($page[19]->body) }}
                        </h3>
                        <p class="text-gray-500">{{ __($page[20]->body)
                            }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="skew skew-bottom mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-bottom ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 10 10"></polygon>
        </svg>
    </div>
</section>

<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center">
            <div class="w-auto bg-white mb-10 lg:mb-0 lg:mr-8 py-8 px-2 rounded">
                <img class="h-16" src="{{ asset($setting->site_logo) }}" alt="">
            </div>
            <div class="w-full lg:w-auto mb-10 lg:mb-0 text-center lg:text-left">
                <h2 class="max-w-xl mx-auto lg:mx-0 mb-2 text-4xl lg:text-5xl font-bold font-heading">{{ __($page[21]->body) }}</h2>
                <p class="max-w-xl mx-auto lg:mx-0 text-gray-500 leading-loose">{{ __($page[22]->body)
                    }}</p>
            </div>
            <div class="w-full lg:w-auto lg:ml-auto text-center"><a
                    class="inline-block py-2 px-6 mx-24 bg-{{ $config[11]->config_value }}-600 hover:bg-{{ $config[11]->config_value }}-700 text-white font-bold leading-loose rounded-l-xl rounded-t-xl transition duration-200"
                    href="{{ url($page[24]->body) }}">{{ __($page[23]->body) }}</a>

                {{-- Sign up with Google --}}
                @if (env('GOOGLE_ENABLE') == 'on')
                <div style="text-align:center">
                    <a href="{{ route('login.google') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:10px;
                               margin-top:12px;padding:8px 24px;background:#fff;
                               border:1px solid #dadce0;color:#3c4043;font-weight:700;font-size:15px;
                               line-height:1.75;border-radius:.75rem .75rem 0 .75rem;
                               text-decoration:none;">
                        <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" style="flex:none">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                        <span>{{ __('Sign up with Google') }}</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- QR Codes --}}
<section>
    <div class="skew skew-top mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 10 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-top ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 10 10 0 10 10"></polygon>
        </svg>
    </div>
    <div class="bg-gray-50 radius-for-skewed">
        <div class="container px-4 mx-auto">
            <div class="max-w-xl mx-auto mb-12 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold font-heading types-count">{{ __($page[25]->body) }}</h2>
                <h2 class="text-4xl lg:text-5xl font-bold font-heading">{{ __($page[26]->body) }}</h2>
            </div>
            <div class="flex flex-wrap">
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-alpha-96.png')}}"
                            alt="Text">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[27]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-bhim-96.png')}}"
                            alt="UPI">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[28]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-link-96.png')}}"
                            alt="UPI">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[29]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline"
                            src="{{ asset('images/web/qrcodes/icons8-iphone-96.png')}}" alt="Phone">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[30]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-sms-96.png')}}"
                            alt="SMS">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[31]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-mail-96.png')}}"
                            alt="Email">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[32]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline"
                            src="{{ asset('images/web/qrcodes/icons8-whatsapp-96.png')}}" alt="WhatsApp">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[33]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline"
                            src="{{ asset('images/web/qrcodes/icons8-video-call-96.png')}}" alt="Facetime">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[34]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline"
                            src="{{ asset('images/web/qrcodes/icons8-location-96.png')}}" alt="Location">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[35]->body) }}</h4>
                    </div>
                </div>
                <div class="mb-6 w-full md:w-1/2 lg:w-1/5 px-3">
                    <div class="pb-8 bg-white rounded shadow text-center overflow-hidden rounded-lg hover:shadow-2xl transition-all">
                        <img class="my-8 object-cover inline" src="{{ asset('images/web/qrcodes/icons8-more-96.png')}}"
                            alt="More">
                        <h4 class="mb-2 text-2xl font-bold font-heading">{{ __($page[36]->body) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="skew skew-bottom mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-bottom ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 10 10"></polygon>
        </svg>
    </div>
</section>

{{--Barcodes --}}
<section>
    <div class="pb-10 bg-gray-50 radius-for-skewed">
        <div class="container px-4 mx-auto">
            <div class="max-w-xl mx-auto mb-12 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold font-heading types-count">{{ __($page[37]->body) }}</h2>
                <h2 class="text-4xl lg:text-5xl font-bold font-heading">{{ __($page[38]->body) }}</h2>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center">
            <div class="w-auto bg-white mb-10 lg:mb-0 lg:mr-8 py-8 px-2 rounded">
                <img class="h-16" src="{{ asset($setting->site_logo) }}" alt="">
            </div>
            <div class="w-full lg:w-auto mb-10 lg:mb-0 text-center lg:text-left">
                <h2 class="max-w-xl mx-auto lg:mx-0 mb-2 text-4xl lg:text-5xl font-bold font-heading">{{ __($page[39]->body) }}</h2>
                <p class="max-w-xl mx-auto lg:mx-0 text-gray-500 leading-loose">{{ __($page[40]->body)
                    }}</p>
            </div>
            <div class="w-full lg:w-auto lg:ml-auto text-center"><a
                    class="inline-block py-2 px-6 mx-24 bg-{{ $config[11]->config_value }}-600 hover:bg-{{ $config[11]->config_value }}-700 text-white font-bold leading-loose rounded-l-xl rounded-t-xl transition duration-200"
                    href="{{ url($page[42]->body) }}">{{ __($page[41]->body) }}</a></div>
        </div>
    </div>
</section>

{{-- Pricing --}}
<section>
    <div class="skew skew-top mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 10 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-top ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 10 10 0 10 10"></polygon>
        </svg>
    </div>
    <div class="py-10 bg-gray-50 radius-for-skewed">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-{{ $config[11]->config_value }}-600 font-bold">{{ __($page[43]->body)
                    }}</span>
                <h2 class="mb-2 text-4xl lg:text-5xl font-bold font-heading">{{ __($page[44]->body) }}</h2>
                <p class="mb-6 text-gray-500">{{ __($page[45]->body) }}</p>
            </div>
            <div class="flex flex-wrap justify-center items-center -mx-4">
                {{-- all plans --}}
                @foreach ($plans as $plan)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 lg:mb-0 mt-3">
                    <div
                        class="p-8 {{ $plan->recommended == '1' ? 'bg-'.$config[11]->config_value.'-600' : 'bg-white' }} shadow rounded">
                        {{-- Plan name --}}
                        <h4
                            class="mb-2 text-2xl font-bold font-heading {{ $plan->recommended == '1' ? 'text-white' : '' }}">
                            {{ __($plan->plan_name) }}</h4>
                        @if ($plan->plan_price == 0)

                        {{-- Check free --}}
                        <span class="text-5xl font-bold {{ $plan->recommended == '1' ? 'text-white' : '' }}">{{ __('Free') }}</span>
                        @endif

                        {{-- Plan price --}}
                        <span class="text-5xl font-bold {{ $plan->recommended == '1' ? 'text-white' : '' }}">{{
                            $plan->plan_price == '0' ? '' : $currency->symbol }}{{ $plan->plan_price == '0' ? '' :
                            formatCurrency($plan->plan_price) }}</span>

                        {{-- Plan vlidity --}}
                        <span class="text-xs {{ $plan->recommended == '1' ? 'text-gray-50' : 'text-gray-400 ' }}">
                            @if ($plan->plan_price != '0' && $plan->validity == '9999')
                            {{ __('Forever') }}</span>
                        @endif
                        @if ($plan->validity == '31')
                        {{ __('Per') }} {{ __('Month') }}</span>
                        @endif
                        @if ($plan->validity == '366')
                        {{ __('Per') }} {{ __('Year') }}</span>
                        @endif
                        @if ($plan->validity > '1' && $plan->validity != '31' && $plan->validity != '366' &&
                        $plan->validity != '9999')
                        {{ __('Per').' '.$plan->validity.' '.__('Days') }}</span>
                        @endif</span>

                        {{-- Plan description --}}
                        <p
                            class="mt-3 mb-6 {{ $plan->recommended == '1' ? 'text-gray-50' : 'text-gray-500' }} leading-loose">
                            {{ __($plan->plan_description) }}</p>

                        <ul class="mb-6 {{ $plan->recommended == '1' ? 'text-gray-50' : 'text-gray-500' }}">
                            {{-- QR Code Types --}}
                            <li class="mb-2 flex">
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $plan->no_access_qr == '999' ? __('Unlimited') : $plan->no_access_qr }} {{
                                    __('QRCode Types') }}</span>
                            </li>

                            {{-- QRCodes --}}
                            <li class="mb-2 flex">
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $plan->no_qrcodes == '999' ? __('Unlimited') : $plan->no_qrcodes }} {{
                                    __('QRCodes')
                                    }}</span>
                            </li>

                            {{-- BarCodes --}}
                            <li class="mb-2 flex">
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $plan->no_barcodes == '999' ? __('Unlimited') : $plan->no_barcodes }} {{
                                    __('Barcodes')
                                    }}</span>
                            </li>

                            {{-- Additional Tools --}}
                            <li class="mb-2 flex">
                                @if ($plan->additional_tools == 1)
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-circle-x mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                </svg>
                                @endif
                                <span>{{ __('Additional Tools') }}</span>
                            </li>

                            {{-- Enable Analytics --}}
                            <li class="mb-2 flex">
                                @if ($plan->enable_analaytics == 1)
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-circle-x mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                </svg>
                                @endif
                                <span>{{ __('Enable Analytics') }}</span>
                            </li>

                            {{-- Hide Branding --}}
                            <li class="mb-2 flex">
                                @if ($plan->hide_branding == 1)
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-circle-x mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                </svg>
                                @endif
                                <span>{{ __('Hide Branding') }}</span>
                            </li>

                            {{-- Support --}}
                            <li class="mb-2 flex">
                                @if ($plan->support == 1)
                                <svg class="mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-circle-x mr-2 w-5 h-5 {{ $plan->recommended == '1' ? 'text-'.$config[11]->config_value.'-500' : 'text-'.$config[11]->config_value.'-600' }}"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M10 10l4 4m0 -4l-4 4"></path>
                                </svg>
                                @endif
                                <span>{{ __('Support') }}</span>
                            </li>
                        </ul>
                        
                        @if(Route::has('register'))
                        <a class="inline-block text-center py-2 px-4 w-full rounded-l-xl rounded-t-xl {{ $plan->recommended == '1' ? 'bg-gray-50 hover:bg-gray-50' : 'bg-'.$config[11]->config_value.'-600 hover:bg-'.$config[11]->config_value.'-700 text-white' }} font-bold leading-loose transition duration-200"
                            href="{{ route('register') }}">{{ __('Get Started') }}</a>
                        @else
                        <a class="inline-block text-center py-2 px-4 w-full rounded-l-xl rounded-t-xl {{ $plan->recommended == '1' ? 'bg-gray-50 hover:bg-gray-50' : 'bg-'.$config[11]->config_value.'-600 hover:bg-'.$config[11]->config_value.'-700 text-white' }} font-bold leading-loose transition duration-200"
                            href="{{ route('login') }}">{{ __('Get Started') }}</a>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <div class="skew skew-bottom mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-bottom ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 10 10"></polygon>
        </svg>
    </div>
</section>

{{-- Cookie --}}
{{-- @include('website.includes.cookie') --}}

{{-- Footer --}}
@include('website.includes.footer')
@endsection