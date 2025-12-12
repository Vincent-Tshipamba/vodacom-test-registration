<section id="what-is-it" class="bg-slate-50 dark:bg-slate-900 py-16 sm:py-20">
    <div class="container mx-auto px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl md:text-center">
                <h2 class="font-display text-3xl tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    {{ __('what-is-it.title') }}
                </h2>
                <p class="mt-4 text-lg tracking-tight text-slate-700 dark:text-gray-300">
                    {{ __('what-is-it.description') }}
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach (__('what-is-it.cards') as $card)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-slate-900/10 dark:shadow-slate-500 p-6 text-center hover:scale-110 transition-all duration-300">
                        <div class="text-4xl mb-4">{{ $card['emoji'] }}</div>
                        <h3 class="font-semibold text-lg text-slate-900 dark:text-white mb-2">{{ $card['title'] }}</h3>
                        <p class="text-slate-700 dark:text-gray-300">{{ $card['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
