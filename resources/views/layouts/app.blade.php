<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @include('layouts.navigation')
    <div class="min-h-screen bg-gray-200 dark:bg-gray-700 mt-20 p-6">
        <!-- Page Content -->
        {{ $slot }}
    </div>

    <footer class="bg-white dark:bg-gray-900">
        <div class="text-center items-center p-4">
            <a href="#" class="flex items-center justify-center mb-2 text-2xl font-semibold text-gray-900">
                <img src="{{ asset('img/vodacom-seeklogo.png') }}" Loading="lazy" class="h-8" alt="Logo Vodacom">
            </a>

            <span class="block text-sm text-center text-gray-500">
                © {{ date('Y') }} Vincent. Tous les droits sont réservés.
            </span>
        </div>
    </footer>

    <script src="{{ Vite::asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/flowbite/dist/flowbite.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/jquery-validation/dist/jquery.validate.js') }}"></script>
    @yield('script')
</body>

</html>
