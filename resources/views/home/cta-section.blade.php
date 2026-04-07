<section class="site-section-surface mx-auto px-6 py-20 sm:py-20">
    <div class="container m-auto px-6 space-y-8 text-gray-500 dark:text-gray-300 md:px-12 lg:px-20">
        <div class="justify-center text-center gap-6 md:text-left md:flex lg:items-center  lg:gap-16">
            <div class="order-last mb-6 space-y-6 md:mb-0 md:w-6/12 lg:w-6/12">
                <h1 class="text-3xl text-gray-900 dark:text-gray-200 font-bold md:text-5xl">
                    {{ __('cta.title') }}<span class="text-red-600 dark:text-red-400"> {{ __('cta.highlight') }}</span>
                </h1>
                <p class="text-lg">
                    {{ __('cta.description') }}
                </p>
                <div class="flex flex-row-reverse flex-wrap justify-center gap-4 md:gap-6 md:justify-end">
                    <a href="{{ route('scholarship.register', app()->getLocale()) }}" title="{{ __('cta.button_aria') }}"
                        class="animate-bounce w-full py-3 px-6 text-center rounded-xl transition bg-red-800 dark:bg-red-600 shadow-xl hover:bg-red-600 hover:dark:bg-red-800 active:bg-red-700 focus:bg-red-600 sm:w-max hover:scale-110 duration-300">
                        <span class="block text-white font-semibold">
                            {{ __('cta.button') }}
                        </span>
                    </a>
                </div>
            </div>
            <div class="md:grid grid-cols-5 grid-rows-4 gap-4 md:w-5/12 lg:w-6/12 hidden">
                <div class="col-span-2 row-span-4">
                    <img src="{{ asset('img/positive-college-student-has-dark-skin-carries-folders-book-points-with-cheerful-expression-aside-has-toothy-smile.jpg') }}"
                        class="rounded-xl" width="640" height="1120" alt="shoes" loading="lazy">
                </div>
                <div class="col-span-2 row-span-2">
                    <img src="{{ asset('img/young-female-african-american-student-with-diploma-poses-outdoorsxa.jpg') }}"
                        class="w-full h-full object-cover object-top rounded-xl" width="940" height="600"
                        alt="Boursiers" loading="lazy">
                </div>
                <div class="col-span-3 row-span-3">
                    <img src="{{ asset('img/happy-student-with-graduation-hat-diploma-grey.jpg') }}"
                        class="w-full h-full object-cover object-top rounded-xl" width="640" height="427"
                        alt="shoes" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
