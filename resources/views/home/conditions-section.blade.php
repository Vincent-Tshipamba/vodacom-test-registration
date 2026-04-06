@php
$criteria = array_values(__('conditions.criteria'));
@endphp

<section class="bg-slate-50 py-16 dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div
            class="relative overflow-hidden rounded-[2rem] border dark:border-slate-900 border-slate-50 px-6 py-8 shadow-[0_30px_30px_rgba(225,239,253,0.35)] sm:px-8 sm:py-10 lg:px-10">
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.18),_transparent_38%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.12),_transparent_32%)]">
            </div>

            <div class="relative w-full">
                <div
                    class="rounded-[1.75rem] border border-white/5 p-6 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] sm:p-8">
                    <div class="mb-8 flex items-start gap-4">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-900/12 text-sky-400 ring-1 ring-inset ring-sky-400/20">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] dark:text-sky-400/90 text-sky-400/90">
                                {{ __('conditions.subtitle') }}
                            </p>
                            <h2 class="mt-3 text-3xl font-bold tracking-tight dark:text-white text-gray-800 sm:text-4xl">
                                {{ __('conditions.title') }}
                            </h2>
                            <p class="mt-4 max-w-2xl text-sm leading-7 dark:text-slate-300 text-slate-800 sm:text-base">
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
                                        class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-500/10 text-sky-400 ring-1 ring-inset ring-sky-400/15 transition duration-300 group-hover:bg-sky-500/15">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-base font-normal dark:text-gray-200 text-gray-700">
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
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-500/12 text-sky-300 ring-1 ring-inset ring-sky-400/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-300/90">
                        {{ __('conditions.note_title') }}
                    </p>
                    <p class="mt-2 text-sm leading-7 dark:text-slate-200 text-slate-800">
                        {{ __('conditions.note_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>