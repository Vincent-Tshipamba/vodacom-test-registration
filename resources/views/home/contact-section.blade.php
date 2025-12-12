<section id="contact" class="bg-white dark:bg-gray-900 py-16 sm:py-20">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('contact.title') }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {{ __('contact.subtitle') }}
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-6 text-center">
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('contact.info.email') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('contact.form.email') }}</p>
                </div>
                <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-6 text-center">
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('contact.info.phone') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('contact.form.phone') }}</p>
                </div>
                <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-6 text-center">
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('contact.info.address') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('contact.form.address') }},
                        {{ __('contact.info.city') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
