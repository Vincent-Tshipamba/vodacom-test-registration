@php
$criteria = array_values(__('conditions.criteria'));
@endphp

<section class="py-16">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div
            class="site-section-surface relative overflow-hidden rounded-[2rem] border dark:border-slate-900 border-slate-50 px-6 py-8 shadow-[0_30px_30px_rgba(225,239,253,0.35)] sm:px-8 sm:py-10 lg:px-10">

            <div class="relative w-full">
                <div class="">
                    <div class="mb-8 flex items-start gap-4">
                        <div>
                            <p
                                class="text-sm font-bold uppercase tracking-[0.28em] dark:text-red-400/90 text-red-400/90">
                                {{ __('conditions.subtitle') }}
                            </p>
                            <h2
                                class="mt-3 text-3xl font-bold tracking-tight dark:text-white text-gray-800 sm:text-4xl">
                                {{ __('conditions.title') }}
                            </h2>
                            <p
                                class="mt-4 max-w-2xl text-base leading-7 dark:text-slate-300 text-slate-800 sm:text-base">
                                {{ __('conditions.description') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($criteria as $criterion)
                            <article
                                class="group rounded-[1.35rem] border dark:border-white/5 border-white/[0.5] bg-white/[0.025] px-5 py-4 transition duration-300 hover:scale-105 hover:border-sky-400/20 dark:hover:bg-white/[0.05] hover:bg-white/[0.5]">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="mt-0.5 flex md:h-8 md:w-8 w-6 h-6 shrink-0 items-center justify-center rounded-xl bg-red-500/10 text-red-400 ring-1 ring-inset ring-red-400/15 transition duration-300 group-hover:bg-red-500/15">
                                        <svg class="sm:h-5 sm:w-5 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-base font-thin dark:text-gray-200 text-gray-700">
                                            {{ $criterion }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex items-start gap-4 mt-3">
                <div>
                    <p class="text-lg font-semibold uppercase tracking-[0.15em] text-red-300/90">
                        {{ __('conditions.note_title') }}
                    </p>
                    <p class="mt-2 text-base leading-7 dark:text-slate-200 text-slate-800">
                        {{ __('conditions.note_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
