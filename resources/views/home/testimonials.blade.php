<section id="testimonials-section" class="bg-gray-50 dark:bg-slate-900 mx-auto px-6 py-20 sm:py-20">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-gray-200 sm:text-4xl">
            {{ __('testimonials.title') }}
        </h2>
        <p class="mt-4 text-lg text-slate-700 dark:text-gray-300">
            {{ __('testimonials.subtitle') }}
        </p>
    </div>

    <div class="marquee-row w-full mx-auto overflow-hidden relative">
        <div
            class="absolute left-0 top-0 h-full w-20 z-10 pointer-events-none bg-gradient-to-r from-white dark:from-slate-800 to-transparent">
        </div>
        <div class="marquee-inner flex transform-gpu min-w-[200%] pt-10 pb-5" id="row1"></div>
        <div
            class="absolute right-0 top-0 h-full w-20 md:w-40 z-10 pointer-events-none bg-gradient-to-l from-white dark:from-slate-900 to-transparent">
        </div>
    </div>

    <div class="marquee-row w-full mx-auto overflow-hidden relative">
        <div
            class="absolute left-0 top-0 h-full w-20 z-10 pointer-events-none bg-gradient-to-r from-white dark:from-slate-800 to-transparent">
        </div>
        <div class="marquee-inner marquee-reverse flex transform-gpu min-w-[200%] pt-5 pb-10" id="row2"></div>
        <div
            class="absolute right-0 top-0 h-full w-20 md:w-40 z-10 pointer-events-none bg-gradient-to-l from-white dark:from-slate-800 to-transparent">
        </div>
    </div>

</section>
