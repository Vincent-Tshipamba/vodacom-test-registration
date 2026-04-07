@php
$steps = [
    'registration' => [
        'icon' =>
            'M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z',
        'viewBox' => '0 0 24 24',
        'fill' => 'currentColor',
    ],
    'verification' => [
        'icon' =>
            'M9.5 11.5 11 13l4-3.5M12 20a16.405 16.405 0 0 1-5.092-5.804A16.694 16.694 0 0 1 5 6.666L12 4l7 2.667a16.695 16.695 0 0 1-1.908 7.529A16.406 16.406 0 0 1 12 20Z',
        'viewBox' => '0 0 24 24',
        'fill' => 'none',
        'stroke' => 'currentColor',
        'stroke-width' => '1.3',
        'stroke-linecap' => 'round',
        'stroke-linejoin' => 'round',
    ],
    'test' => [
        'icon' =>
            'M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z',
        'viewBox' => '0 0 24 24',
        'fill' => 'currentColor',
    ],
    'interview' => [
        'icon' =>
            'M10 8h4m-7 4h10m-6 4h2M7 3h10a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 0 1 2-2h2',
        'viewBox' => '0 0 24 24',
        'fill' => 'none',
        'stroke' => 'currentColor',
        'stroke-width' => '1.8',
        'stroke-linecap' => 'round',
        'stroke-linejoin' => 'round',
    ],
    'final_selection' => [
        'icon' =>
            'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        'viewBox' => '0 0 24 24',
        'fill' => 'none',
        'stroke' => 'currentColor',
        'stroke-width' => '1.8',
        'stroke-linecap' => 'round',
        'stroke-linejoin' => 'round',
    ],
];
@endphp

<section class="px-6 py-20">
    <div class="mx-auto max-w-7xl">
        <div class="site-section-surface relative overflow-hidden h-full px-6 py-10 sm:px-8 lg:px-10">

            <div class="relative text-center">
                <h2 class="text-3xl font-bold tracking-tight dark:text-white text-gray-800 sm:text-4xl">
                    {{ __('process.title') }}
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-base leading-8 dark:text-slate-300 text-slate-900 sm:text-lg">
                    {{ __('process.description') }}
                </p>
            </div>

            <div class="relative mt-14">
                <div class="absolute left-12 right-12 top-10 hidden h-px bg-gradient-to-r from-red-500/10 via-red-400/30 to-red-500/10 xl:block"></div>

                <div class="grid gap-6 xl:grid-cols-5">
                    @foreach (__('process.steps') as $key => $step)
                        <article class="group relative">
                            <div class="flex h-full flex-col items-center text-center">
                                <div class="relative z-10 flex md:h-16 md:w-16 h-8 w-12 items-center justify-center rounded-full border border-red-500/35 dark:bg-[#08111d] bg-white dark:text-red-400 text-red-400 transition duration-300 dark:group-hover:border-red-300/55 group-hover:border-red-800/55 dark:group-hover:text-red-300 group-hover:text-red-700">
                                    <span class="md:text-2xl text-lg font-bold tracking-[0.18em]">
                                        {{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                <div class="mt-6 flex h-full w-full flex-col rounded-[1.4rem] border dark:border-white/5 border-red-500/[0.15] dark:bg-white/[0.025] bg-white/[0.4] px-5 py-6 transition duration-300 dark:group-hover:border-red-400/20 group-hover:border-red-500/20 dark:group-hover:bg-white/[0.04] group-hover:bg-white group-hover:scale-105">
                                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl dark:bg-red-500/10 bg-red-100 text-red-600 dark:text-red-400 ring-1 ring-inset ring-red-400/15">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="{{ $steps[$key]['viewBox'] ?? '0 0 24 24' }}"
                                            fill="{{ $steps[$key]['fill'] ?? 'currentColor' }}"
                                            @if (isset($steps[$key]['stroke'])) stroke="{{ $steps[$key]['stroke'] }}"
                                                stroke-width="{{ $steps[$key]['stroke-width'] }}"
                                                stroke-linecap="{{ $steps[$key]['stroke-linecap'] }}"
                                                stroke-linejoin="{{ $steps[$key]['stroke-linejoin'] }}" @endif
                                            aria-hidden="true">
                                            <path d="{{ $steps[$key]['icon'] }}" />
                                        </svg>
                                    </div>

                                    <h3 class="text-xl font-semibold dark:text-white text-slate-900">
                                        {{ $step['title'] }}
                                    </h3>
                                    <p class="mt-3 text-base font-normal leading-7 dark:text-slate-300 text-slate-900">
                                        {{ $step['description'] }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
