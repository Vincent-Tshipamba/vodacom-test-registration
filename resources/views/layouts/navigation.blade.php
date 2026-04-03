@php
    $locale = app()->getLocale();

    $languages = [
        'fr' => [
            'label' => __('messages.language_fr'),
            'flag' => asset('img/flag-for-france-svgrepo-com.svg'),
            'code' => 'fr',
        ],
        'en' => [
            'label' => __('messages.language_en'),
            'flag' => asset('img/flag-for-flag-usa.svg'),
            'code' => 'en',
        ],
        'ln' => [
            'label' => __('messages.language_ln'),
            'flag' => asset('img/flag-for-flag-congo-kinshasa-svgrepo-com.svg'),
            'code' => 'ln',
        ],
        'sw' => [
            'label' => __('messages.language_sw'),
            'flag' => asset('img/flag-for-flag-congo-kinshasa-svgrepo-com.svg'),
            'code' => 'sw',
        ],
    ];

    // Si jamais une langue n'est pas connue, fallback FR
$current = $languages[$locale] ?? $languages['fr'];
@endphp
<nav class="top-0 z-20 fixed bg-white dark:bg-gray-900/50 backdrop-blur-lg border-gray-200 dark:border-gray-600/30 border-b w-full start-0">
    <div class="flex flex-wrap justify-between items-center mx-auto p-4 max-w-screen-xl">
        <a href="{{ route('index', app()->getLocale()) }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/vodacom-seeklogo.png') }}" Loading="lazy" class="h-6 sm:h-8" alt="Logo Vodacom">
            <img src="{{ asset('img/instant-school-logo.png') }}" Loading="lazy" class="h-6 sm:h-8" alt="Logo Vodacom">
            <span class="self-center font-semibold dark:text-white text-2xl whitespace-nowrap"></span>
        </a>

        <div class="flex items-center space-x-1 rtl:space-x-reverse md:space-x-0 md:order-2">
            <button type="button" data-dropdown-toggle="language-dropdown-menu"
                class="box-border flex items-center bg-transparent hover:bg-neutral-secondary-medium px-3 py-2 border border-transparent rounded-base focus:outline-none focus:ring-4 focus:ring-neutral-tertiary font-medium text-heading dark:text-slate-300 text-sm leading-5">
                <img src="{{ $current['flag'] }}" alt="flag" class="xs:me-2 w-6 h-6">
                <span class="hidden xs:block">{{ $current['label'] }}</span>
            </button>
            <!-- Dropdown -->
            <div class="hidden z-50 bg-neutral-primary-medium bg-slate-200 dark:bg-slate-900 shadow-lg border border-default-medium rounded-base w-44"
                id="language-dropdown-menu">
                <ul class="p-2 font-medium text-body dark:text-slate-200 text-sm" role="none">
                    @foreach ($languages as $code => $language)
                        <li>
                            <a href="{{ url()->current() === url('/') ? '/' . $code : str_replace('/' . $locale, '/' . $code, url()->full()) }}"
                                class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded {{ $code === $locale ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                        class="me-2 w-6 h-6">
                                    <span class="text-sm">{{ $language['label'] }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button data-collapse-toggle="navbar-language" type="button"
                class="md:hidden inline-flex justify-center items-center hover:bg-neutral-secondary-soft p-2 rounded-base focus:outline-none focus:ring-2 focus:ring-neutral-tertiary w-10 h-10 text-body hover:text-heading text-sm"
                aria-controls="navbar-language" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
            <button type="button" class="justify-end bg-transparent p-0 w-4 transition-all duration-200 ease-linear"
                id="light-dark-mode">
                <svg class="dark:hidden block fill-[#1c004c] w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="hidden dark:block fill-yellow-500 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="hidden md:flex justify-between items-center md:order-1 w-full md:w-auto" id="navbar-language">
            <ul
                class="flex md:flex-row flex-col rtl:space-x-reverse md:space-x-8 bg-neutral-secondary-soft md:bg-neutral-primary mt-4 md:mt-0 p-4 md:p-0 border border-default md:border-0 rounded-base font-medium dark:text-slate-300">
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#hero"
                        class="block font-normal py-2 px-3 text-heading rounded md:border-0 md:hover:font-semibold md:p-0 {{ request()->routeIs('index') ? 'text-blue-600 font-medium' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#what-is-it"
                        class="block font-normal md:hover:bg-transparent md:dark:hover:bg-transparent md:p-0 px-3 py-2 md:border-0 rounded text-heading md:hover:font-bold">
                        {{ __('messages.about') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#contact"
                        class="block font-normal md:hover:bg-transparent md:dark:hover:bg-transparent md:p-0 px-3 py-2 md:border-0 rounded text-heading md:hover:font-bold">
                        {{ __('messages.contact') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('scholarship.register', app()->getLocale()) }}"
                        class="block py-2 px-3 text-red-600 font-normal rounded md:hover:bg-transparent md:border-0 md:hover:text-red-500 hover:font-bold md:p-0 md:dark:hover:bg-transparent {{ request()->routeIs('scholarship.register') ? 'font-bold' : '' }}">
                        {{ __('messages.apply_now') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
