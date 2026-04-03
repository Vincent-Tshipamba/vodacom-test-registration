@php
    $heroTitle = __('hero.title');
    $heroTitleWords = preg_split('/\s+/u', trim($heroTitle)) ?: [];
@endphp

@push('styles')
    <style>
        @keyframes hero-word-reveal {
            from {
                opacity: 0;
                transform: translateY(0.35rem);
                filter: blur(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        .hero-word {
            opacity: 0;
            animation: hero-word-reveal 0.45s ease-out forwards;
            animation-delay: var(--word-delay, 0s);
        }
    </style>
@endpush

<div id="hero" class="min-h-screen max-w-full font-sans">
    <div class="relative min-h-screen shadow-2xl p-4 max-w-full overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvARcp_7T2jbszuz8AFGf7k9cQMY4atBoEKg&s');">
        </div>
        <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>

        <!-- Content -->
        <div
            class="z-10 relative flex flex-col justify-center items-center bg-gradient-to-b from-transparent via-black/50 to-black/80 px-6 py-60 sm:py-60 md:py-60 text-center">
            <h1
                class="hidden md:block animate-typing overflow-hidden whitespace-nowrap border-r-4 border-r-white drop-shadow-lg mb-4 font-extrabold text-white text-3xl md:text-4xl leading-tight tracking-wide">
                {{ $heroTitle }}
            </h1>

            <h1 class="md:hidden drop-shadow-lg mb-4 font-extrabold text-white text-3xl leading-tight tracking-wide">
                <span class="inline-flex flex-wrap justify-center gap-x-2 gap-y-1">
                    @foreach ($heroTitleWords as $word)
                        <span class="hero-word" style="--word-delay: {{ $loop->index * 0.22 }}s;">
                            {{ $word }}
                        </span>
                    @endforeach
                </span>
            </h1>

            <p class="mx-auto mb-8 max-w-2xl text-gray-200 text-lg md:text-xl">
                {{ __('hero.description') }}
            </p>
            <div class="flex md:flex-row flex-col gap-4">
                <a href="{{ route('scholarship.register', app()->getLocale()) }}"
                    class="animate-bounce bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 shadow-lg px-8 py-4 rounded-full font-semibold text-white text-lg hover:scale-105 transition duration-300 ease-in-out transform">
                    {{ __('hero.cta') }}
                </a>
                <a href="#what-is-it"
                    class="hover:bg-white px-8 py-4 border-2 border-white rounded-full font-semibold text-white hover:text-gray-900 text-lg transition duration-300 ease-in-out">
                    {{ __('hero.learn_more') }}
                </a>
            </div>
        </div>
    </div>
</div>
