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
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('index', app()->getLocale()) }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/vodacom-seeklogo.png') }}" Loading="lazy" class="h-6 sm:h-8" alt="Logo Vodacom">
            <img src="{{ asset('img/instant-school-logo.png') }}" Loading="lazy" class="h-6 sm:h-8" alt="Logo Vodacom">
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"></span>
        </a>

        <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
            <button type="button" data-dropdown-toggle="language-dropdown-menu"
                class="flex items-center text-heading dark:text-slate-300 bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                <img src="{{ $current['flag'] }}" alt="flag" class="w-6 h-6 xs:me-2">
                <span class="hidden xs:block">{{ $current['label'] }}</span>
            </button>
            <!-- Dropdown -->
            <div class="z-50 hidden bg-neutral-primary-medium bg-slate-200 dark:bg-slate-900 border border-default-medium rounded-base shadow-lg w-44"
                id="language-dropdown-menu">
                <ul class="p-2 text-sm text-body dark:text-slate-200 font-medium" role="none">
                    @foreach ($languages as $code => $language)
                        <li>
                            <a href="{{ url()->current() === url('/') ? '/' . $code : str_replace('/' . $locale, '/' . $code, url()->full()) }}"
                                class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded {{ $code === $locale ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                        class="w-6 h-6 me-2">
                                    <span class="text-sm">{{ $language['label'] }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button data-collapse-toggle="navbar-language" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                aria-controls="navbar-language" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
            <button onclick="(() => document.body.classList.toggle('dark'))()"
                class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="fill-violet-700 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="fill-yellow-500 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-language">
            <ul
                class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary dark:text-slate-300">
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#hero"
                        class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent {{ request()->routeIs('index') ? 'text-blue-600 font-medium' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#what-is-it"
                        class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">
                        {{ __('messages.about') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index', app()->getLocale()) }}#contact"
                        class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">
                        {{ __('messages.contact') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('scholarship.register', app()->getLocale()) }}"
                        class="block py-2 px-3 text-red-600 font-medium rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 md:dark:hover:bg-transparent {{ request()->routeIs('scholarship.register') ? 'underline' : '' }}">
                        {{ __('messages.apply_now') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
