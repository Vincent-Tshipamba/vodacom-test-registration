<section class="bg-gray-50 dark:bg-slate-900 px-6 py-20 sm:py-20">
    <div class="container px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-gray-200 sm:text-4xl">
                {{ __('process.title') }}
            </h2>
            <p class="mt-4 text-lg text-slate-700 dark:text-gray-300">
                {{ __('process.description') }}
            </p>
        </div>

        <!-- Timeline vertical -->
        <div class="w-full flex justify-center">
            <div class="relative border-l-2 border-red-500 dark:border-red-400">
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
                                'M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z',
                            'viewBox' => '0 0 24 24',
                            'fill' => 'currentColor',
                        ],
                        'final_selection' => [
                            'icon' =>
                                'M4 4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-5.5a1 1 0 0 1-.8-.4L9.5 4.4a1 1 0 0 0-.8-.4H4Z',
                            'viewBox' => '0 0 24 24',
                            'fill' => 'currentColor',
                        ],
                    ];
                @endphp

                @foreach (__('process.steps') as $key => $step)
                    <div class="mb-10 ml-6">
                        <span
                            class="flex absolute -left-4 justify-center items-center w-8 h-8 bg-red-500 dark:bg-red-400 rounded-full ring-4 ring-white dark:ring-gray-900">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="{{ $steps[$key]['viewBox'] ?? '0 0 24 24' }}"
                                fill="{{ $steps[$key]['fill'] ?? 'currentColor' }}"
                                @if (isset($steps[$key]['stroke'])) stroke="{{ $steps[$key]['stroke'] }}"
                                 stroke-width="{{ $steps[$key]['stroke-width'] }}"
                                 stroke-linecap="{{ $steps[$key]['stroke-linecap'] }}"
                                 stroke-linejoin="{{ $steps[$key]['stroke-linejoin'] }}" @endif>
                                <path d="{{ $steps[$key]['icon'] }}" />
                            </svg>
                        </span>
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-gray-200 mb-2">
                            {{ $step['title'] }}
                        </h3>
                        <p class="text-slate-700 dark:text-gray-300">
                            {{ $step['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
