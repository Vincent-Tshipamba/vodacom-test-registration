<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="group scroll-smooth light" data-layout="vertical"
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
    @stack('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/scss/tailwind.scss') }}"> --}}
    <!-- Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-body-bg dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700 font-public text-body dark:text-zink-100 text-base">
    <div class="group-data-[sidebar-size=sm]:relative group-data-[sidebar-size=sm]:min-h-sm">

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
                class="group-data-[layout=horizontal]:mx-auto group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto px-4 group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:px-3 pt-[calc(theme('spacing.header')_*_1)] group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)] group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 pb-[calc(theme('spacing.header')_*_0.8)] group-data-[layout=horizontal]:max-w-screen-2xl">
                <!-- Page Content -->
                @yield('content')
            </div>
            @include('admin.partials.footer')
        </div>
    </div>

    @include('admin.partials.customizer')


    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <!--apexchart js-->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/libs/vanilla-calendar-pro/build/vanilla-calendar.min.js') }}"></script>

    @if (request()->routeIs('admin.dashboard'))
        <script src="{{ asset('assets/js/pages/dashboards-hr.init.js') }}"></script>
    @endif

    <!-- Dans la section head -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js" defer></script>
    <script src="{{ asset('js/applyTheme.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        function insertMathToken(token, questionUuid) {
            const card = document.querySelector(`[data-question-uuid="${questionUuid}"]`);
            if (!card) return;

            let field = document.activeElement;
            const isInsideCard = field && card.contains(field);
            const isTextField = isInsideCard && (field.tagName === 'TEXTAREA' || (field.tagName === 'INPUT' && field.type === 'text'));

            if (!isTextField) {
                field = card.querySelector('textarea, input[type="text"]');
            }
            if (!field) return;

            const start = field.selectionStart ?? field.value.length;
            const end = field.selectionEnd ?? start;
            const before = field.value.slice(0, start);
            const after = field.value.slice(end);
            field.value = before + token + after;

            const caret = start + token.length;
            field.focus();
            field.setSelectionRange(caret, caret);
            field.dispatchEvent(new Event('input', { bubbles: true }));
        }
    </script>

    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/select/3.1.3/js/dataTables.select.js" defer></script>
    <script src="https://cdn.datatables.net/select/3.1.3/js/select.dataTables.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js" defer></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.tailwindcss.js" defer></script>
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>

    <script src="{{ asset('js/script-applicants.js') }}" defer></script>
    @yield('script')
    @stack('scripts')
    @yield('modal')
    @livewireScripts
</body>

</html>
