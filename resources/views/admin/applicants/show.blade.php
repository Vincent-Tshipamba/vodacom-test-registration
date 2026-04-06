@extends('admin.layouts.app')
@section('content')
    @php
        $canModerateApplicant = auth()->user()?->agent || auth()->user()?->scholar;
        $statusLabels = [
            'PENDING' => 'En attente',
            'REJECTED' => 'Je ne le retiens pas',
            'SHORTLISTED' => 'Présélectionné pour le test',
            'TEST_PASSED' => 'A réussi le test de sélection',
            'INTERVIEW_PASSED' => 'A réussi l\'entretien',
            'ADMITTED' => 'Retenu comme boursier',
        ];
        $historyStatusClasses = [
            'PENDING' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-300',
            'REJECTED' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300',
            'SHORTLISTED' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300',
            'TEST_PASSED' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
            'INTERVIEW_PASSED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
            'ADMITTED' => 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300',
        ];
    @endphp

    @if (session('success'))
        <div
            class="flex items-center gap-3 bg-green-50 dark:bg-green-500/10 mb-4 p-4 border border-green-200 dark:border-green-500/20 rounded-lg text-green-800 dark:text-green-200">
            <i data-lucide="badge-check" class="size-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div
            class="flex items-center gap-3 bg-red-50 dark:bg-red-500/10 mb-4 p-4 border border-red-200 dark:border-red-500/20 rounded-lg text-red-800 dark:text-red-200">
            <i data-lucide="octagon-x" class="size-5"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <nav class="flex my-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard', app()->getLocale()) }}"
                    class="inline-flex items-center font-medium text-gray-700 hover:text-indigo-800 dark:text-gray-300 text-base">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                            stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <a href="{{ route('admin.applicants.index', app()->getLocale()) }}"
                        class="ml-1 md:ml-2 font-medium text-gray-700 hover:text-indigo-800 hover:font-bold dark:hover:font-bold dark:hover:text-gray-200 dark:text-gray-300 text-base">
                        Applicants</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                            stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base">{{ $applicant->full_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <section class="relative pt-36 pb-24">
        <img src="{{ asset('img/OR68WQ0.jpg') }}" alt="cover-image" loading="lazy"
            class="top-0 left-0 z-0 absolute w-full h-36 object-cover">
        <div class="top-[-72px] z-10 relative flex justify-center items-center">
            <button type="button"
                onclick="showProfilePhoto('{{ $applicant->documents->photo['url'] }}', '{{ addslashes($applicant->full_name) }}')"
                class="group relative rounded-full focus:outline-none focus:ring-4 focus:ring-blue-400/30">
                <img src="{{ $applicant->documents->photo['url'] }}" alt="{{ $applicant->full_name . ' avatar' }}"
                    loading="lazy"
                    class="bg-[#0a0022] border-4 border-white border-solid rounded-full w-36 h-36 object-cover transition duration-200 group-hover:scale-[1.02]">
                <span
                    class="right-1 bottom-1 absolute inline-flex items-center gap-1 bg-slate-900/80 group-hover:bg-slate-900 px-2.5 py-1 rounded-full text-white text-[11px] transition">
                    <i data-lucide="zoom-in" class="size-3"></i>
                    Voir
                </span>
            </button>
        </div>
        <div class="mx-auto -mt-12 px-6 md:px-8 w-full max-w-7xl">
            <h3 class="mb-3 font-manrope font-bold text-gray-900 text-3xl text-center leading-10">
                {{ $applicant->full_name }}
            </h3>
            <div class="mx-auto text-center">
                @if ($applicant->application_status == 'PENDING')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-orange-100 dark:bg-orange-500/20 mx-auto px-3 py-1 border border-orange-200 dark:border-orange-500/20 rounded-full font-medium text-orange-700 dark:text-orange-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.5a.75.75 0 0 0-1.5 0v3.69c0 .2.08.39.22.53l2.25 2.25a.75.75 0 1 0 1.06-1.06l-2.03-2.03V6.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('status.PENDING') }}
                    </span>
                @elseif ($applicant->application_status == 'ADMITTED')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-green-100 dark:bg-green-500/20 mx-auto px-3 py-1 border border-green-200 dark:border-green-500/20 rounded-full font-medium text-green-700 dark:text-green-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.53-9.22a.75.75 0 1 0-1.06-1.06L9 11.19 7.53 9.72a.75.75 0 0 0-1.06 1.06l2 2a.75.75 0 0 0 1.06 0l4-4Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('status.ADMITTED') }}
                    </span>
                @elseif ($applicant->application_status == 'REJECTED')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-red-100 dark:bg-red-500/20 mx-auto px-3 py-1 border border-red-200 dark:border-red-500/20 rounded-full font-medium text-red-700 dark:text-red-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-2.72-9.78a.75.75 0 0 1 1.06-1.06L10 8.94l1.66-1.72a.75.75 0 0 1 1.08 1.04L11.04 10l1.7 1.74a.75.75 0 0 1-1.08 1.04L10 11.06l-1.66 1.72a.75.75 0 1 1-1.08-1.04L8.96 10 7.28 8.22Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('status.REJECTED') }}
                    </span>
                @elseif ($applicant->application_status == 'SHORTLISTED')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-yellow-100 dark:bg-yellow-500/20 mx-auto px-3 py-1 border border-yellow-200 dark:border-yellow-500/20 rounded-full font-medium text-yellow-700 dark:text-yellow-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M10 2a.75.75 0 0 1 .75.75V4h3.5A1.75 1.75 0 0 1 16 5.75v8.5A1.75 1.75 0 0 1 14.25 16h-8.5A1.75 1.75 0 0 1 4 14.25v-8.5C4 4.78 4.78 4 5.75 4h3.5V2.75A.75.75 0 0 1 10 2Z" />
                            <path
                                d="M7.75 8.5a.75.75 0 0 0 0 1.5h4.19l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H7.75Z" />
                        </svg>
                        {{ __('status.SHORTLISTED') }}
                    </span>
                @elseif ($applicant->application_status == 'INTERVIEW_PASSED')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-emerald-100 dark:bg-emerald-500/20 mx-auto px-3 py-1 border border-emerald-200 dark:border-emerald-500/20 rounded-full font-medium text-emerald-700 dark:text-emerald-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M10 2a5 5 0 0 0-5 5v2.382l-.447.894A1 1 0 0 0 5.447 11h.303a4.25 4.25 0 0 0 8.5 0h.303a1 1 0 0 0 .894-1.447L15 9.382V7a5 5 0 0 0-5-5Z" />
                            <path d="M7.75 14.5a2.25 2.25 0 0 0 4.5 0h-4.5Z" />
                        </svg>
                        {{ __('status.INTERVIEW_PASSED') }}
                    </span>
                @elseif ($applicant->application_status == 'TEST_PASSED')
                    <span
                        class="inline-flex justify-center items-center gap-1.5 bg-blue-100 dark:bg-blue-500/20 mx-auto px-3 py-1 border border-blue-200 dark:border-blue-500/20 rounded-full font-medium text-blue-700 dark:text-blue-300 text-xs text-center status">
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M5.75 2A1.75 1.75 0 0 0 4 3.75v12.5C4 17.216 4.784 18 5.75 18h8.5A1.75 1.75 0 0 0 16 16.25V3.75A1.75 1.75 0 0 0 14.25 2h-8.5Z" />
                            <path
                                d="M7.25 6.5a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Zm0 3a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Zm.97 3.28a.75.75 0 1 0-1.06-1.06l-.94.94a.75.75 0 0 0 0 1.06l1.44 1.44a.75.75 0 1 0 1.06-1.06l-.91-.91.41-.41Zm5.56-1.06a.75.75 0 0 0-1.06 0l-1.47 1.47-.41-.41a.75.75 0 1 0-1.06 1.06l.94.94a.75.75 0 0 0 1.06 0l2-2a.75.75 0 0 0 0-1.06Z" />
                        </svg>
                        {{ __('status.TEST_PASSED') }}
                    </span>
                @endif
            </div>
            @if ($applicant->application_status === 'PENDING' && $canModerateApplicant)
                <div class="flex sm:flex-row flex-col justify-center gap-3 mt-5">
                    <form method="POST"
                        action="{{ route('admin.applicants.update-status', ['locale' => app()->getLocale(), 'applicant' => $applicant->id]) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="application_status" value="SHORTLISTED">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 dark:hover:bg-green-500 shadow-sm px-5 py-2.5 rounded-lg font-medium text-white transition">
                            <i data-lucide="badge-check" class="size-4"></i>
                            Je le valide
                        </button>
                    </form>
                    <form method="POST"
                        action="{{ route('admin.applicants.update-status', ['locale' => app()->getLocale(), 'applicant' => $applicant->id]) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="application_status" value="REJECTED">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 bg-red-600 hover:bg-red-700 dark:hover:bg-red-500 shadow-sm px-5 py-2.5 rounded-lg font-medium text-white transition">
                            <i data-lucide="user-x" class="size-4"></i>
                            Je ne le retiens pas
                        </button>
                    </form>
                </div>
            @endif
            <div class="flex flex-col justify-center gap-2 my-auto py-6 w-full">
                <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">{{ __('admin.first_name') }}
                                </dt>
                                <dd class="font-semibold text-lg">{{ $applicant->first_name }}</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">{{ __('admin.last_name') }}
                                </dt>
                                <dd class="font-semibold text-lg">{{ $applicant->last_name }}</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                    {{ __('admin.date_of_birth') }}
                                </dt>
                                <dd class="font-semibold text-lg">
                                    {{ app()->getLocale() === 'fr' ? $applicant->date_of_birth->format('d/m/Y') : $applicant->date_of_birth->format('Y-m-d') }}
                                    ({{ $applicant->getAge() }} {{ __('admin.years_old') }})
                                </dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">{{ __('admin.gender') }}</dt>
                                <dd class="font-semibold text-lg">{{ __("db_values.gender.$applicant->gender") }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">{{ __('admin.location') }}
                                </dt>
                                <dd class="font-semibold text-lg">{{ $applicant->full_address }}</dd>
                            </div>

                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                    {{ __('admin.phone_number') }}
                                </dt>
                                <dd class="font-semibold text-lg">{{ $applicant->phone_number }}</dd>
                            </div>

                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                    {{ __('admin.specific_condition') }}
                                </dt>
                                <dd class="font-semibold hover:text-blue-500 text-lg">
                                    {{ __("db_values.identification_type.$applicant->vulnerability_type") }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="my-3 w-full">
                    <!--  -->
                    <h1
                        class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md dark:text-white md:text-lg lg:text-xl">
                        {{ __('admin.cities_info') }}
                    </h1>
                    <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.diploma_city') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->educational_city?->name }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.current_city') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->current_city->name }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="my-3 w-full">
                    <!--  -->
                    <h1
                        class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md dark:text-white md:text-lg lg:text-xl">
                        {{ __('admin.school_infos') }}
                    </h1>
                    <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.school_name') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->school_name }}</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.option_studied') }}
                                    </dt>
                                    @php
                                        $optionKey = 'db_values.study_option.' . $applicant->option_studied;
                                    @endphp
                                    <dd class="font-semibold text-lg">
                                        {{ Lang::has($optionKey) ? __($optionKey) : $applicant->option_studied }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.national_exam_code') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->national_exam_code }}</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.percentage') }} %
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ intval($applicant->percentage) }} %</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="my-3 w-full">
                    <!--  -->
                    <h1
                        class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md dark:text-white md:text-lg lg:text-xl">
                        {{ __('admin.documents_infos') }}
                    </h1>
                    <div class="gap-4 grid grid-cols-1 sm:grid-cols-3 w-full">
                        @foreach ($applicant->documents as $doc)
                            @if ($doc['url'] && $doc['type'] != 'PHOTO')
                                <a href="{{ $doc['url'] }}"
                                    onclick="showDocument(event, '{{ $doc['url'] }}', {{ $doc['id'] }}, '{{ $doc['type'] }}', {{ $applicant->id }}, '{{ $applicant->full_name }}', '{{ $doc['is_pdf'] }}')"
                                    class="bg-white dark:bg-gray-800 shadow-sm hover:shadow-md border rounded-lg overflow-hidden transition">

                                    <!-- Preview -->
                                    <div class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 h-40">
                                        @if (in_array($doc['ext'], ['jpg', 'jpeg', 'png', 'webp']))
                                            <img src="{{ $doc['url'] }}" alt="{{ __('admin.' . strtolower($doc['type'])) }}"
                                                class="w-full h-full object-cover">
                                        @elseif($doc['is_pdf'])
                                            <iframe src="{{ $doc['url'] }}" class="w-full h-full pointer-events-none"></iframe>
                                        @else
                                            <!-- DOC / DOCX -->
                                            <div class="flex flex-col items-center text-gray-600 dark:text-gray-300">
                                                <svg class="mb-2 w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25V6.75A2.25 2.25 0 0017.25 4.5h-6.379a2.25 2.25 0 00-1.591.659l-3.621 3.621a2.25 2.25 0 00-.659 1.591v7.879a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25z" />
                                                </svg>
                                                <span class="text-sm uppercase">{{ $doc['ext'] }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="p-3 font-medium text-gray-800 dark:text-white text-sm text-center">
                                        {{ __('admin.' . strtolower($doc['type'])) }}
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="my-3 w-full">
                    <!--  -->
                    <h1
                        class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md dark:text-white md:text-lg lg:text-xl">
                        {{ __('admin.personal_ambitions') }}
                    </h1>
                    <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.intended_field') }}
                                    </dt>
                                    @php
                                        $optionValue = 'db_values.university_field.' . $applicant->intended_field;
                                    @endphp
                                    <dd class="font-semibold text-lg">
                                        {{ Lang::has($optionValue) ? __($optionValue) : $applicant->intended_field }}
                                    </dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.intended_field_motivation') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->intended_field_motivation }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.career_goals') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->career_goals }}</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.additional_infos') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->additional_infos }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 md:p-8 border border-gray-200 dark:border-gray-700 rounded-lg">
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-xl">Historique de changement de statuts
                </h3>
                @forelse ($applicant->historique_status_changes as $history)
                    @php
                        $changedByAgent = $history->changed_by_agent;
                        $changedByScholar = $history->changed_by_scholar;
                        $modifierLabel = $changedByAgent?->user?->full_name
                            ? $changedByAgent->user->full_name . ' (Agent)'
                            : ($changedByScholar?->user?->full_name
                                ? $changedByScholar->user->full_name . ' (Boursier)'
                                : 'Inconnu');
                    @endphp
                    <div
                        class="gap-4 grid grid-cols-1 md:grid-cols-4 bg-white dark:bg-gray-900 mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-xl">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Modifie par</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $modifierLabel }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Date</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $history->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Ancien statut</p>
                            <span
                                class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full text-xs font-medium {{ $historyStatusClasses[$history->old_status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-300' }}">{{ $statusLabels[$history->old_status] ?? $history->old_status }}</span>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Nouveau statut</p>
                            <span
                                class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full text-xs font-medium {{ $historyStatusClasses[$history->new_status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-300' }}">{{ $statusLabels[$history->new_status] ?? $history->new_status }}</span>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white dark:bg-gray-900 p-5 border border-dashed border-gray-300 dark:border-gray-600 rounded-xl text-gray-500 dark:text-gray-400">
                        Aucun changement de statut n'a encore été enregistré pour ce candidat.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Search Modal -->
    @include('admin.applicants.partials.search-modal')
@endsection
@section('script')
    <script>
        function showProfilePhoto(photoUrl, fullName) {
            Swal.fire({
                title: `Photo de ${fullName}`,
                html: `
                    <div class="flex justify-center">
                        <img src="${photoUrl}" alt="Photo de ${fullName}" class="max-h-[70vh] w-auto max-w-full rounded-2xl object-contain shadow-lg">
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'custom-swal'
                }
            });
        }

        function showDocument(event, fileUrl, fileId, fileType, candidateId, name, isPdf) {
            event.preventDefault();

            let contentHtml;
            let title;
            if (fileType === 'DIPLOMA') {
                title = `Attestation de réussite de ${name}`;
            } else if (fileType === 'PHOTO') {
                title = `Image de ${name}`;
            } else if (fileType === 'ID') {
                title = `Pièce d'identité de ${name}`;
            }

            if (isPdf) {
                contentHtml = `
                    <div>
                        <iframe id="certificateIframe${candidateId}" src="${fileUrl}"
                                style="width: 100%; height: 65vh;" frameborder="0"></iframe>
                    </div>
                `;
            } else {
                contentHtml = `
                    <div>
                        <img id="certificateImage${candidateId}" src="${fileUrl}" alt="${fileType}" class="w-full h-48 object-cover">
                    </div>
                `;
            }
            Swal.fire({
                title: title,
                html: `${contentHtml}`,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: "Je valide le document",
                denyButtonText: "Je ne valide pas le document",
                cancelButtonText: "Fermer",
                focusConfirm: false,
                customClass: {
                    popup: 'custom-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // TODO: Handle confirmation
                    console.log('Document validated');
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('application-documents.change-status', app()->getLocale()) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: fileId,
                            is_valid: true
                        },
                        dataType: "json",
                        success: function (response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: response.message,
                            });
                        },
                        error: function (xhr, status, error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: "Une erreur est survenue lors de la validation.",
                            });
                        }
                    });
                } else if (result.isDenied) {
                    // TODO: Handle denial
                    console.log('Document not validated');
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('application-documents.change-status', app()->getLocale()) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            is_valid: false,
                            id: fileId,
                        },
                        dataType: "json",
                        success: function (response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: response.message,
                            });
                        },
                        error: function (xhr, status, error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: "Une erreur est survenue lors de l'invalidation.",
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection
