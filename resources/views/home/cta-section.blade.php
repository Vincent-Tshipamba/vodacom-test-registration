<section class="bg-gray-50 dark:bg-slate-900 mx-auto px-6 py-20 sm:py-20">
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
                        class="w-full py-3 px-6 text-center rounded-xl transition bg-slate-800 dark:bg-slate-600 shadow-xl hover:bg-gray-600 hover:dark:bg-slate-400 active:bg-gray-700 focus:bg-gray-600 sm:w-max  hover:scale-110 duration-300">
                        <span class="block text-white font-semibold">
                            {{ __('cta.button') }}
                        </span>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-5 grid-rows-4 gap-4 md:w-5/12 lg:w-6/12">
                <div class="col-span-2 row-span-4">
                    <img src="https://www.rdcetudes.com/static/486a863e03feeaad32165bf5dbccc44c/136cc/md-duran-628456-unsplash.jpg"
                        class="rounded-full" width="640" height="960" alt="shoes" loading="lazy">
                </div>
                <div class="col-span-2 row-span-2">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSS83h5QlnZtCAfhNRgLVJhVA9om9yVkpCZnw&s"
                        class="w-full h-full object-cover object-top rounded-xl" width="640" height="640"
                        alt="shoe" loading="lazy">
                </div>
                <div class="col-span-3 row-span-3">
                    <img src="https://minesursi.gouv.cd/images/bourse-etudes.jpg"
                        class="w-full h-full object-cover object-top rounded-xl" width="640" height="427"
                        alt="shoes" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
