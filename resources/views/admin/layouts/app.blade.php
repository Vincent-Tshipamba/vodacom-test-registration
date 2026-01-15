<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth group" data-layout="vertical"
    data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky"
    data-content="fluid" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="shortcut icon" href="{{ asset('img/instant-school-logo.png') }}" type="image/x-icon">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/scss/icons.scss') }}">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('assets/scss/tailwind.scss') }}"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
    <div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

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
        @include('admin.partials.sidebar')
        @include('admin.partials.topbar')

        <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
            <div
                class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
                <!-- Page Content -->
                @yield('content')
            </div>
            @include('admin.partials.footer')
        </div>
    </div>

    @include('admin.partials.customizer')


    <script src="{{ Vite::asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/flowbite/dist/flowbite.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/libs/lucide/umd/lucide.js') }}"></script>
    <script src="{{ asset('assets/js/tailwick.bundle.js') }}"></script>
    <!--apexchart js-->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/libs/vanilla-calendar-pro/build/vanilla-calendar.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/dashboards-hr.init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <!-- Dans la section head -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('script')
    @yield('modal')
</body>

</html>
