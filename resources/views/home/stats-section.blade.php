<section class="bg-slate-50 dark:bg-slate-900 py-16 sm:py-20">
    <div class="container mx-auto px-4 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl md:text-center">
                <h2 class="font-display text-3xl tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    {{ __('stats.title') }}
                </h2>
                <p class="mt-4 text-lg tracking-tight text-slate-700 dark:text-gray-300">
                    {{ __('stats.description') }}
                </p>
            </div>

            <ul role="list"
                class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-6 sm:gap-8 lg:mt-20 lg:max-w-none lg:grid-cols-3">
                @foreach (__('stats.stats') as $stat)
                    <li>
                        <figure
                            class="relative rounded-2xl bg-white dark:bg-gray-900 p-6 text-center shadow-xl shadow-slate-900/10 dark:shadow-slate-600 hover:scale-110 transition-all duration-300">
                            <blockquote class="relative p-3">
                                <p class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                                    {{ $stat['count'] }}
                                </p>
                            </blockquote>
                            <figcaption class="text-center">
                                <div class="font-display text-slate-900 dark:text-white">
                                    {{ $stat['description'] }}
                                </div>
                            </figcaption>
                        </figure>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
