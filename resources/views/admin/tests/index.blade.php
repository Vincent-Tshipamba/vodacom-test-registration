@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/3.1.3/css/select.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css">
@endpush

@section('content')
    <nav class="flex justify-between items-center my-3" aria-label="Breadcrumb">
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
                    <span class="ml-1 md:ml-2 font-medium text-gray-700 text-base">{{ __('test.evaluation') }}</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                            stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                        style="margin-right: 0.5rem;">
                        <path fill-rule="evenodd"
                            d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M2 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm6.585 1.08a.75.75 0 0 1 .336 1.005l-1.75 3.5a.75.75 0 0 1-1.16.234l-1.75-1.5a.75.75 0 0 1 .977-1.139l1.02.875 1.321-2.64a.75.75 0 0 1 1.006-.336Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base">{{ $currentEdition->name }}</span>
                </div>
            </li>
        </ol>

        <div class="float-right flex items-center space-x-2">
            <a id="closeVote" href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
                class="inline-flex items-center bg-[#fe042c] hover:bg-[#fe042c]/80 dark:hover:bg-[#fe042c]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#fe042c]/50 focus:ring-4 dark:focus:ring-[#fe042c]/40 font-medium text-white text-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                    style="margin-right: 0.5rem; display:none">
                    <path fill-rule="evenodd"
                        d="M6.455 1.45A.5.5 0 0 1 6.952 1h2.096a.5.5 0 0 1 .497.45l.186 1.858a4.996 4.996 0 0 1 1.466.848l1.703-.769a.5.5 0 0 1 .639.206l1.047 1.814a.5.5 0 0 1-.14.656l-1.517 1.09a5.026 5.026 0 0 1 0 1.694l1.516 1.09a.5.5 0 0 1 .141.656l-1.047 1.814a.5.5 0 0 1-.639.206l-1.703-.768c-.433.36-.928.649-1.466.847l-.186 1.858a.5.5 0 0 1-.497.45H6.952a.5.5 0 0 1-.497-.45l-.186-1.858a4.993 4.993 0 0 1-1.466-.848l-1.703.769a.5.5 0 0 1-.639-.206l-1.047-1.814a.5.5 0 0 1 .14-.656l1.517-1.09a5.033 5.033 0 0 1 0-1.694l-1.516-1.09a.5.5 0 0 1-.141-.656L2.46 3.593a.5.5 0 0 1 .639-.206l1.703.769c.433-.36.928-.65 1.466-.848l.186-1.858Zm-.177 7.567-.022-.037a2 2 0 0 1 3.466-1.997l.022.037a2 2 0 0 1-3.466 1.997Z"
                        clip-rule="evenodd" />
                </svg>
                <p class="flex justify-inline items-center">Clôturer la phase</p>
            </a>

            <button type="button" id="dropdownLeftButtonStatus" data-dropdown-toggle="dropdownLeftStatus"
                data-dropdown-placement="left"
                class="inline-flex items-center bg-[#fe042c] hover:bg-[#fe042c]/80 dark:hover:bg-[#fe042c]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#fe042c]/50 focus:ring-4 dark:focus:ring-[#fe042c]/40 font-medium text-white text-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                    style="margin-right: 0.5rem;">
                    <path fill-rule="evenodd"
                        d="M6.455 1.45A.5.5 0 0 1 6.952 1h2.096a.5.5 0 0 1 .497.45l.186 1.858a4.996 4.996 0 0 1 1.466.848l1.703-.769a.5.5 0 0 1 .639.206l1.047 1.814a.5.5 0 0 1-.14.656l-1.517 1.09a5.026 5.026 0 0 1 0 1.694l1.516 1.09a.5.5 0 0 1 .141.656l-1.047 1.814a.5.5 0 0 1-.639.206l-1.703-.768c-.433.36-.928.649-1.466.847l-.186 1.858a.5.5 0 0 1-.497.45H6.952a.5.5 0 0 1-.497-.45l-.186-1.858a4.993 4.993 0 0 1-1.466-.848l-1.703.769a.5.5 0 0 1-.639-.206l-1.047-1.814a.5.5 0 0 1 .14-.656l1.517-1.09a5.033 5.033 0 0 1 0-1.694l-1.516-1.09a.5.5 0 0 1-.141-.656L2.46 3.593a.5.5 0 0 1 .639-.206l1.703.769c.433-.36.928-.65 1.466-.848l.186-1.858Zm-.177 7.567-.022-.037a2 2 0 0 1 3.466-1.997l.022.037a2 2 0 0 1-3.466 1.997Z"
                        clip-rule="evenodd" />
                </svg>
                <p class="flex justify-inline items-center">Changer statut</p>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownLeftStatus"
                class="hidden z-10 bg-white dark:bg-gray-700 shadow rounded-lg divide-y divide-gray-100 dark:divide-gray-600 w-15">

                <ul class="py-1 text-gray-700 dark:text-gray-200 text-xs" aria-labelledby="dropdownLeftButtonStatus">
                    <li id="enCours" style="margin-right: 0.2rem; margin-left: 0.2rem;">
                        <?php $message = 'Voulez-vous lancer cette phase?'; ?>
                        <a href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
                            class="inline-flex items-center hover:bg-blue-100 dark:hover:bg-blue-600 px-3 py-1 rounded-md dark:hover:text-white text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd"
                                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="flex justify-inline items-center" style="margin-left: 0.2rem;">Lancer la
                                phase </p>
                        </a>
                    </li>

                    <li id="fermer" style="margin-right: 0.2rem; margin-left: 0.2rem;">
                        <?php $message = 'Voulez-vous fermer cette phase?'; ?>
                        <a href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
                            class="inline-flex items-center hover:bg-red-100 dark:hover:bg-red-600 px-3 py-1 rounded-md dark:hover:text-white text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                                <path
                                    d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                            </svg>
                            <p class="flex justify-inline items-center" style="margin-left: 0.2rem;">Fermer la
                                phase </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <livewire:admin.phase-test :currentEdition="$currentEdition" />

    <div class="mb-4 border-gray-500 border-b">
        <ul class="flex flex-wrap -mb-px font-medium text-sm text-center" id="default-styled-tab"
            data-tabs-toggle="#default-styled-tab-content"
            data-tabs-active-classes="text-[#fe042c] hover:text-[#fe042c] border-[#fe042c]"
            data-tabs-inactive-classes="dark:border-transparent text-gray-700 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 border-default hover:border-gray-700"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="flex space-x-1 p-4 border-b-2 rounded-t-base" id="dashboard-styled-tab"
                    data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard"
                    aria-selected="false">
                    <x-icon name="dashboard-icon" class="w-5 h-5" />
                    <span>Dashboard</span>
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="flex space-x-1 p-4 hover:border-brand border-b-2 rounded-medium hover:text-fg-brand"
                    id="candidats-styled-tab" data-tabs-target="#styled-candidats" type="button" role="tab"
                    aria-controls="candidats" aria-selected="false">
                    <x-icon name="grid-icon" class="w-5 h-5" />
                    <span>Candidats</span>
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="flex space-x-1 p-4 hover:border-brand border-b-2 rounded-t-base hover:text-fg-brand"
                    id="questions-styled-tab" data-tabs-target="#styled-questions" type="button" role="tab"
                    aria-controls="questions" aria-selected="false">
                    <x-icon name="questions-icon" />
                    <span>Questions</span>
                </button>
            </li>
        </ul>
    </div>
    <div id="default-styled-tab-content">
        <div class="hidden bg-gray-300 dark:bg-neutral-800 p-4 rounded-base" id="styled-dashboard" role="tabpanel"
            aria-labelledby="list-tab">
            <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4">
                <div class="bg-white dark:bg-gray-800 shadow mr-2 p-4 md:p-6 rounded-lg w-full max-w-sm">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <div class="flex justify-center items-center mb-3">
                                <h5 class="pe-1 font-bold text-gray-900 dark:text-white text-xl leading-none">
                                    {{ __('test.stats_candidats') }}
                                </h5>
                                <svg data-popover-target="chart-info" data-popover-placement="right"
                                    class="ms-1 w-3.5 h-3.5 text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 cursor-pointer"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
                                </svg>
                                <div data-popover id="chart-info" role="tooltip"
                                    class="invisible inline-block z-10 absolute bg-white dark:bg-gray-800 opacity-0 shadow-sm border border-gray-200 dark:border-gray-600 rounded-lg w-72 text-gray-500 dark:text-gray-400 text-sm transition-opacity duration-300">
                                    <div class="space-y-2 p-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Total</h3>
                                        <p>
                                            {{ __('test.total_explaination') }}
                                        </p>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('test.female') }}
                                        </h3>
                                        <p>
                                            {{ __('test.female_explaination') }}
                                        </p>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('test.male') }}</h3>
                                        <p>
                                            {{ __('test.male_explaination') }}
                                        </p>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Start</h3>
                                        <p>
                                            {{ __('test.start_explaination') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="gap-4 grid grid-cols-4 mb-2">
                            <dl
                                class="flex flex-col justify-center items-center bg-orange-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-orange-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-[#ff1453] dark:text-[#ff1453] text-sm">
                                    {{ $candidatsTotal }}
                                </dt>
                                <dd class="font-medium text-[#ff1453] dark:text-[#ff1453] text-sm">
                                    Total
                                </dd>
                            </dl>
                            <dl
                                class="flex flex-col justify-center items-center bg-teal-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-teal-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-teal-600 dark:text-teal-300 text-sm">
                                    {{ $candidatsFemale ?? 0 }}
                                </dt>
                                <dd class="font-medium text-teal-600 dark:text-teal-300 text-sm">
                                    {{ __('test.female') }}
                                </dd>
                            </dl>
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $candidatsMale ?? 0 }}
                                </dt>
                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ __('test.male') }}
                                </dd>
                            </dl>
                            {{-- TODO: afficher le nombre de candidats ayant deja started the test --}}
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $candidatsTotal }}
                                </dt>
                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">Start</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow mr-2 p-4 md:p-6 rounded-lg w-full max-w-sm">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <div class="flex justify-center items-center mb-3">
                                <h5 class="pe-1 font-bold text-gray-900 dark:text-white text-xl leading-none">
                                    {{ __('test.stats_test') }}
                                </h5>
                                <svg data-popover-target="chart-info-pass" data-popover-placement="right"
                                    class="ms-1 w-3.5 h-3.5 text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 cursor-pointer"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
                                </svg>
                                <div data-popover id="chart-info-pass" role="tooltip"
                                    class="invisible inline-block z-10 absolute bg-white dark:bg-gray-800 opacity-0 shadow-sm border border-gray-200 dark:border-gray-600 rounded-lg w-72 text-gray-500 dark:text-gray-400 text-sm transition-opacity duration-300">
                                    <div class="space-y-2 p-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ __('test.success') }}
                                        </h3>
                                        <p>{{ __('test.success_explaination') }}</p>
                                    </div>
                                    <div class="space-y-2 p-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('test.male') }}</h3>
                                        <p>{{ __('test.success_female_explaination') }}</p>
                                    </div>
                                    <div class="space-y-2 p-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('test.female') }}
                                        </h3>
                                        <p>{{ __('test.success_female_explaination') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="gap-4 grid grid-cols-3 mb-2">
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                {{-- TODO: Afficher le total des reussites --}}
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $candidatsTotal ?? 'ND' }}
                                </dt>

                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">{{ __('test.success') }}
                                </dd>
                            </dl>
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                {{-- TODO: Afficher le total des garcons ayant reussi --}}
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $candidatsMale ?? 0 }}
                                </dt>

                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">{{ __('test.male') }}
                                </dd>
                            </dl>
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                {{-- TODO: Afficher le total des filles ayant reussi --}}
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $candidatsFemale ?? 0 }}
                                </dt>

                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">{{ __('test.female') }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow p-4 md:p-6 rounded-lg w-full max-w-sm">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <div class="flex justify-center items-center mb-3">
                                <h5 class="pe-1 font-bold text-gray-900 dark:text-white text-xl leading-none">
                                    {{ __('test.stats_questions') }}
                                </h5>
                                <svg data-popover-target="chart-info-quest" data-popover-placement="top"
                                    class="ms-1 w-3.5 h-3.5 text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 cursor-pointer"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
                                </svg>
                                <div data-popover id="chart-info-quest" role="tooltip"
                                    class="invisible inline-block z-10 absolute bg-white dark:bg-gray-800 opacity-0 shadow-sm border border-gray-200 dark:border-gray-600 rounded-lg w-72 text-gray-500 dark:text-gray-400 text-sm transition-opacity duration-300">
                                    <div class="space-y-2 p-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ __('test.stats_questions') }}
                                        </h3>
                                        <p>{{ __('test.stats_questions_explaination') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <div class="mb-2">
                            <dl
                                class="flex flex-col justify-center items-center bg-blue-50 dark:bg-gray-600 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-blue-100 dark:bg-gray-500 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 dark:text-blue-300 text-sm">
                                    {{ $phaseQuestionsCount }}
                                </dt>
                                <dd class="font-medium text-blue-600 dark:text-blue-300 text-sm">Total</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden bg-gray-300 dark:bg-gray-800 p-4 rounded-sm" id="styled-candidats" role="tabpanel"
            aria-labelledby="candidats-tab">
            <div class="relative shadow-md sm:rounded-lg overflow-x-auto" style="padding-top: 10px;">
                @if (session('successCand'))
                    <div id="alert-3-cand"
                        class="flex items-center bg-green-50 dark:bg-gray-800 mb-4 p-4 rounded-lg text-green-800 dark:text-green-400"
                        role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 font-medium text-sm">
                            {{ session('successCand') }}
                        </div>
                        <button type="button"
                            class="inline-flex justify-center items-center bg-green-50 hover:bg-green-200 dark:bg-gray-800 dark:hover:bg-gray-700 -mx-1.5 -my-1.5 ms-auto p-1.5 rounded-lg focus:ring-2 focus:ring-green-400 w-8 h-8 text-green-500 dark:text-green-400"
                            data-dismiss-target="#alert-3-cand" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif
                <div
                    class="flex sm:flex-row flex-col sm:justify-end sm:items-center sm:space-x-2 space-y-2 sm:space-y-0 py-2">
                    <a href="#" data-modal-target="pass-modal" data-modal-toggle="pass-modal"
                        class="inline-flex items-center bg-[#ff1453] hover:bg-[#ff1453]/80 dark:hover:bg-[#ff1453]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#ff1453]/50 focus:ring-4 dark:focus:ring-[#ff1453]/40 font-medium text-white text-sm text-center">
                        Règles de passation
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="pl-2 w-8 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </a>

                    <a href="#" {{-- data-modal-target="mail-modal-candidat" data-modal-toggle="mail-modal-candidat" --}}
                        class="inline-flex items-center bg-[#ff1453] hover:bg-[#ff1453]/80 dark:hover:bg-[#ff1453]/80 px-4 py-2 rounded-lg focus:outline-none focus:ring-[#ff1453]/50 focus:ring-4 dark:focus:ring-[#ff1453]/40 font-medium text-white text-sm">
                        Envoyer les sms
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="pl-2 w-8 h-5">
                            <path
                                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
                            <path
                                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
                        </svg>
                    </a>

                    <a href="#"
                        class="inline-flex items-center bg-[#ff1453] hover:bg-[#ff1453]/80 dark:hover:bg-[#ff1453]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#ff1453]/50 focus:ring-4 dark:focus:ring-[#ff1453]/40 font-medium text-white text-sm text-center">
                        Résultats
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="pl-2 w-8 h-5">
                            <path
                                d="M2.995 1a.625.625 0 1 0 0 1.25h.38v2.125a.625.625 0 1 0 1.25 0v-2.75A.625.625 0 0 0 4 1H2.995ZM3.208 7.385a2.37 2.37 0 0 1 1.027-.124L2.573 8.923a.625.625 0 0 0 .439 1.067l1.987.011a.625.625 0 0 0 .006-1.25l-.49-.003.777-.776c.215-.215.335-.506.335-.809 0-.465-.297-.957-.842-1.078a3.636 3.636 0 0 0-1.993.121.625.625 0 1 0 .416 1.179ZM2.625 11a.625.625 0 1 0 0 1.25H4.25a.125.125 0 0 1 0 .25H3.5a.625.625 0 1 0 0 1.25h.75a.125.125 0 0 1 0 .25H2.625a.625.625 0 1 0 0 1.25H4.25a1.375 1.375 0 0 0 1.153-2.125A1.375 1.375 0 0 0 4.25 11H2.625ZM7.25 2a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5h-6ZM7.25 7.25a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5h-6ZM6.5 13.25a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Z" />
                        </svg>
                    </a>
                </div>

                <div class="mb-4 border-default border-b">
                    <ul class="flex flex-wrap -mb-px font-medium text-sm text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="flex items-center space-x-2 p-4 hover:border-brand border-b-2 rounded-full hover:text-fg-brand"
                                id="list-candidats-tab" data-tabs-target="#listCandidats" type="button" role="tab" aria-controls="listCandidats"
                                aria-selected="true">
                                <svg class="w-6 h-6 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M3 11h18M3 15h18m-9-4v8m-8 0h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                </svg>
                                Liste
                            </button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="flex items-center space-x-2 p-4 border-b-2 rounded-full text-gray-900 dark:text-gray-300" id="grid-tab"
                                data-tabs-target="#grid" type="button" role="tab" aria-controls="grid"
                                aria-selected="false">
                                <svg class="w-6 h-6 text-gray-900 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                                </svg>
                                Grid
                            </button>
                        </li>

                    </ul>
                </div>
                <div id="default-tab-content">
                    <div class="hidden bg-gray-300 dark:bg-gray-800 p-4 rounded-base text-gray-900 dark:text-gray-300" id="grid" role="tabpanel"
                        aria-labelledby="grid-tab">
                        <div id="intervenants-list" class="gap-3 grid grid-cols-1 xl:grid-cols-2">
                            @forelse ($candidats as $item)
                                <div class="w-full intervenant-item">
                                    <div
                                        class="flex items-center bg-white dark:bg-gray-800 mb-3 py-3 border border-gray-200 dark:border-gray-700 rounded-md">
                                        <div class="pr-5 pl-2">
                                            <img class="border-2 border-gray-200 dark:border-gray-700 rounded-md w-16 h-16 object-cover"
                                                src="{{ $item->documents->photo['url'] && file_exists(public_path($item->documents->photo['url'])) ? asset($item->documents->photo['url']) : asset('img/profil.jpg') }}"
                                                alt="Image de {{ $item->full_name }}">
                                        </div>
                                        <div class="flex flex-1 justify-between items-center pr-3">
                                            <div>
                                                <div class="flex items-center">
                                                    <h3
                                                        class="text-gray-900 dark:text-white text-xl capitalize whitespace-nowrap">
                                                        {{ $item->full_name }}
                                                    </h3>
                                                    @if ((int) $item->mail_send === 0)
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                            fill="currentColor" class="pl-2 size-7 text-red-500">
                                                            <path
                                                                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
                                                            <path
                                                                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                            fill="currentColor" class="pl-2 size-7 text-green-500">
                                                            <path
                                                                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
                                                            <path
                                                                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-4">
                                                    <h3
                                                        class="text-gray-900 dark:text-white text-sm capitalize whitespace-nowrap">
                                                        {{ $item->gender ?? '-' }}
                                                    </h3>
                                                    <h3 class="text-gray-900 dark:text-white text-sm">
                                                        {{ $item->phone_number ? '+243' . substr($item->phone_number, -9) : '-' }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-8 text-gray-500 dark:text-gray-400 text-center">
                                    {{ __('Aucun candidat trouve.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="hidden bg-neutral-secondary-soft p-4 rounded-base" id="listCandidats" role="tabpanel"
                        aria-labelledby="list-candidats-tab">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-x-auto">
                            <table class="w-full text-sm text-left display" id="candidats-table">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">{{ __('Candidat') }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">{{ __('Genre') }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">{{ __('Telephone') }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">{{ __('SMS') }}</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">
                                    @forelse ($candidats as $i => $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/60">
                                            <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">{{ $i + 1 }}</td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <img class="border border-gray-200 dark:border-gray-700 rounded-md w-10 h-10 object-cover"
                                                        src="{{ $item->documents->photo['url'] && file_exists(public_path($item->documents->photo['url'])) ? asset($item->documents->photo['url']) : asset('img/profil.jpg') }}"
                                                        alt="Image de {{ $item->full_name }}">
                                                    <span class="font-medium">{{ $item->full_name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-white text-sm capitalize whitespace-nowrap">{{ $item->gender ?? '-' }}</td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                                                {{ $item->phone_number ? '+243' . substr($item->phone_number, -9) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs {{ (int) $item->mail_send === 1 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                                    {{ (int) $item->mail_send === 1 ? __('Envoye') : __('Non envoye') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-gray-900 dark:text-white text-sm whitespace-nowrap">
                                                {{ __('Aucun candidat trouve.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden bg-gray-300 dark:bg-neutral-900 p-4 rounded-base" id="styled-questions" role="tabpanel"
            aria-labelledby="questions-tab">
            @if (session('success'))
                <div id="alert-3"
                    class="flex items-center bg-green-50 dark:bg-gray-800 mb-4 p-4 rounded-lg text-green-800 dark:text-green-400"
                    role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 font-medium text-sm">
                        {{ session('success') }}
                    </div>
                    <button type="button"
                        class="inline-flex justify-center items-center bg-green-50 hover:bg-green-200 dark:bg-gray-800 dark:hover:bg-gray-700 -mx-1.5 -my-1.5 ms-auto p-1.5 rounded-lg focus:ring-2 focus:ring-green-400 w-8 h-8 text-green-500 dark:text-green-400"
                        data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            @if (session('echec'))
                <div id="alert-2"
                    class="flex items-center bg-red-50 dark:bg-gray-800 mb-4 p-4 rounded-lg text-red-800 dark:text-red-400"
                    role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 font-medium text-sm">
                        {{ session('echec') }}
                    </div>
                    <button type="button"
                        class="inline-flex justify-center items-center bg-red-50 hover:bg-red-200 dark:bg-gray-800 dark:hover:bg-gray-700 -mx-1.5 -my-1.5 ms-auto p-1.5 rounded-lg focus:ring-2 focus:ring-red-400 w-8 h-8 text-red-500 dark:text-red-400"
                        data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            <livewire:admin::questions.create />
        </div>
    </div>
    <x-delete :message="__('Voulez-vous vraiment supprimer?')" />
    <x-passation-rules-modal />
    <x-change-phase-status />
@endsection

@section('script')
    <script src="https://cdn.datatables.net/select/3.1.3/js/dataTables.select.js" defer></script>
    <script src="https://cdn.datatables.net/select/3.1.3/js/select.dataTables.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js" defer></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.tailwindcss.js" defer></script>
    <script src="https://unpkg.com/jszip/dist/jszip.min.js" defer></script>

    <script src="{{ asset('js/script-applicants.js') }}" defer></script>

@endsection