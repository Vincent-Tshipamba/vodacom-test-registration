@php
$questions = __('faq.questions');
@endphp
<div
    class="relative w-full bg-slate-50 dark:bg-slate-900 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:rounded-lg sm:px-10">
    <div class="mx-auto px-5">
        <div class="flex flex-col items-center">
            <h2 class="mt-5 text-center text-3xl font-bold tracking-tight sm:text-4xl">{{ __('faq.title') }}</h2>
            <p class="mt-3 text-lg text-neutral-500 dark:text-gray-300 md:text-xl">
                {{ __('faq.description') }}
            </p>
        </div>
        <div class="mx-auto mt-8 grid w-full md:max-w-3xl divide-y divide-neutral-200 dark:divide-neutral-800">
            @foreach ($questions as $question)
                <div class="py-5">
                    <details class="group">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                            <span class="text-neutral-600 dark:text-neutral-300">{{ $question['question'] }}</span>
                            <span class="transition group-open:rotate-180 ">
                                <svg class="text-neutral-600 dark:text-neutral-300" fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <p class="text-[15px] group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">
                            {{ $question['answer'] }}
                        </p>
                    </details>
                </div>
            @endforeach
        </div>
    </div>
</div>