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

    <style>
        html {
            scroll-behavior: smooth;
        }

        .wave-divider {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 60px;
        }

        @media (min-width: 768px) {
            .wave-divider svg {
                height: 150px;
            }
        }
    </style>

    <style>
        @keyframes marqueeScroll {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .marquee-inner {
            animation: marqueeScroll 25s linear infinite;
        }

        .marquee-reverse {
            animation-direction: reverse;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @include('layouts.navigation')

    <div class="bg-gray-200 dark:bg-gray-700 mt-20 max-w-full min-h-screen">
        <!-- Page Content -->
        {{ $slot }}
    </div>

    <footer class="bg-white dark:bg-gray-900">
        <div class="items-center p-4 text-center">
            <a href="#" class="flex justify-center items-center mb-2 font-semibold text-gray-900 text-2xl">
                <img src="{{ asset('img/vodacom-seeklogo.png') }}" Loading="lazy" class="h-8" alt="Logo Vodacom">
            </a>

            <span class="block text-gray-500 text-sm text-center">
                © {{ date('Y') }} Vincent. Tous les droits sont réservés.
            </span>
        </div>
    </footer>


    <script>
        function smoothScrollTo(targetId, duration = 1200) {
            const target = document.querySelector(targetId);
            if (!target) return;

            const start = window.scrollY;
            const end = target.getBoundingClientRect().top + window.scrollY;
            const distance = end - start;
            let startTime = null;

            function animation(currentTime) {
                if (!startTime) startTime = currentTime;
                const timeElapsed = currentTime - startTime;

                // easing (doux + plus lent en fin de course)
                const ease = easeInOutQuad(timeElapsed, start, distance, duration);

                window.scrollTo(0, ease);

                if (timeElapsed < duration) {
                    requestAnimationFrame(animation);
                }
            }

            function easeInOutQuad(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t + b;
                t--;
                return -c / 2 * (t * (t - 2) - 1) + b;
            }

            requestAnimationFrame(animation);
        }

        document.querySelector('a[href="#what-is-it-section"]').addEventListener('click', function (e) {
            e.preventDefault();
            smoothScrollTo('#what-is-it-section', 500);
        });
    </script>


    @yield('script')
</body>

</html>