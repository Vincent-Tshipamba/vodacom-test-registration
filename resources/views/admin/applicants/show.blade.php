@extends('admin.layouts.app')
@section('content')
    <nav class="flex my-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard', app()->getLocale()) }}"
                    class="inline-flex items-center font-medium text-gray-900 hover:text-indigo-800 text-base"> Dashboard
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
                        class="ml-1 md:ml-2 font-medium text-gray-900 hover:text-indigo-800 text-base">
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
        <img src="{{ asset('img/OR68WQ0.jpg') }}" alt="cover-image"
            class="top-0 left-0 z-0 absolute w-full h-36 object-cover">
        <div class="top-[-72px] z-10 relative flex justify-center items-center">
            <img src="{{ $applicant->documents->photo['url'] }}" alt="{{ $applicant->full_name . ' avatar' }}"
                class="bg-[#0a0022] border-4 border-white border-solid rounded-full w-36 h-36 object-cover">
        </div>
        <div class="mx-auto -mt-12 px-6 md:px-8 w-full max-w-7xl">
            <h3 class="mb-3 font-manrope font-bold text-gray-900 text-3xl text-center leading-10">
                {{ $applicant->full_name }}</h3>
            <div class="mx-auto text-center">
                @if ($applicant->application_status == 'PENDING')
                    <span
                        class="inline-flex justify-center items-center bg-orange-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-red-500 text-xs text-center status">
                        <i data-lucide="loader" class="mr-1.5 size-3"></i>En attente</span>
                @elseif ($applicant->application_status == 'ADMITTED')
                    <span
                        class="inline-flex justify-center items-center bg-green-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-green-500 text-xs text-center status"><i
                            data-lucide="check-circle" class="mr-1.5 size-3"></i>Admis</span>
                @elseif ($applicant->application_status == 'REJECTED')
                    <span
                        class="inline-flex justify-center items-center bg-red-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-red-500 text-xs text-center status">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-800" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        Refusé</span>
                @elseif ($applicant->application_status == 'SHORTLISTED')
                    <span
                        class="inline-flex justify-center items-center bg-yellow-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-red-500 text-xs text-center status">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-800" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        Préselectionné</span>
                @elseif ($applicant->application_status == 'INTERVIEW_PASSED')
                    <span
                        class="inline-flex justify-center items-center bg-green-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-green-500 text-xs text-center status">
                        <svg height="14" width="14" version="1.1" id="_x32_"
                            class="me-2 text-green-300 dark:text-green-500" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                            <g>
                                <path class="st0" d="M478.267,471.142h0.078l-25.5-136.956v-0.078c-3.685-17.27-18.871-29.661-36.54-29.661H95.695
              c-17.668,0-32.854,12.391-36.454,29.661v0.078L33.733,471.064v0.078c-0.476,2.241-0.718,4.474-0.718,6.793
              c0,7.761,2.639,15.35,7.676,21.51C47.17,507.363,56.844,512,67.079,512h94.256h189.252h94.341c10.228,0,19.988-4.637,26.382-12.555
              c5.036-6.16,7.675-13.749,7.675-21.51C478.985,475.702,478.743,473.384,478.267,471.142z M458.919,489.374
              c-3.443,4.154-8.557,6.636-13.991,6.636H331.317c-10.08-6.082-20.628-10.235-27.264-12.718c-8.878-3.272-21.83-13.031-21.83-19.028
              v-15.826c5.122-5.677,9.034-17.271,11.352-30.381c5.442-1.92,8.48-5.043,12.399-18.551c4.076-14.39-6.238-13.913-6.238-13.913
              c8.316-27.5-2.638-53.405-20.948-51.485c-12.633-22.15-55.006,5.036-68.278,3.194c0,7.597,3.201,13.273,3.201,13.273
              c-4.638,8.714-2.803,26.226-1.523,35.018c-0.796,0-10.071,0.078-6.152,13.913c3.912,13.508,6.956,16.631,12.391,18.551
              c2.319,13.11,6.238,24.704,11.352,30.381v15.826c0,5.996-13.75,16.232-21.83,19.028c-6.715,2.405-17.427,6.558-27.577,12.718
              H67.079c-5.441,0-10.556-2.482-13.991-6.636c-2.638-3.28-4.083-7.355-4.083-11.438c0-1.194,0.164-2.475,0.398-3.678v-0.077
              l25.508-136.8v-0.156c2.077-9.838,10.79-16.786,20.784-16.786h320.609c9.994,0,18.708,6.948,20.784,16.786l25.508,136.956v0.077
              c0.241,1.203,0.398,2.484,0.398,3.678C462.995,482.018,461.558,486.094,458.919,489.374z" />
                                <path class="st0" d="M301.359,154.679c0,4.903,2.045,8.572,2.045,8.572c-2.998,5.669-1.827,16.943-0.999,22.65
              c-0.476-0.007-6.488,0.055-3.927,8.987c2.483,8.729,4.466,10.728,7.972,11.969c1.491,8.488,4.006,15.959,7.324,19.652
              c0,4.42,0,7.652,0,10.228l-0.125,0.82l11.282,5.426v8.713h11.61v-8.721l11.266-5.418l-0.125-0.82c0-2.576,0-5.808,0-10.228
              c3.319-3.693,5.848-11.164,7.324-19.652c3.491-1.241,5.504-3.24,7.988-11.969c2.654-9.307-3.99-8.987-3.99-8.987
              c5.38-17.778-1.702-34.486-13.538-33.261C337.306,138.353,309.939,155.897,301.359,154.679z" />
                                <path class="st0" d="M338.016,276.652l-1.475-18.762h-11.61l-1.483,18.762l-18.903-29.091c-8.58,0-32.418,21.158-33.808,46.729
              h120.005c-1.398-25.571-25.227-46.729-33.815-46.729L338.016,276.652z" />
                                <path class="st0" d="M157.001,206.858c1.491,8.488,4.021,15.959,7.324,19.652c0,4.42,0,7.652,0,10.228l-0.125,0.82l11.282,5.418
              v8.721h11.611v-8.721l11.258-5.418l-0.117-0.82c0-2.576,0-5.808,0-10.228c3.326-3.693,5.832-11.164,7.332-19.652
              c3.49-1.241,5.496-3.24,7.98-11.969c2.67-9.307-3.974-8.987-3.974-8.987c5.364-17.778-1.718-34.486-13.562-33.261
              c-8.151-14.288-35.518,3.256-44.083,2.038c0,4.903,2.038,8.572,2.038,8.572c-2.99,5.669-1.835,16.943-0.991,22.65
              c-0.492-0.007-6.504,0.055-3.943,8.987C151.513,203.618,153.512,205.617,157.001,206.858z" />
                                <path class="st0" d="M207.479,247.56l-18.903,29.091l-1.483-18.762h-11.611l-1.475,18.762l-18.911-29.091
              c-8.58,0-32.418,21.158-33.807,46.729h119.997C239.881,268.719,216.075,247.56,207.479,247.56z" />
                                <path class="st0" d="M212.991,117.436l-12.148,30.349l8.768-1.086c30.302-3.787,59.315-15.132,73.096-21.089
              c13.094-4.669,24.384-12.664,32.526-23.032c8.183-10.447,13.156-23.432,13.149-37.462c0.007-9.182-2.116-17.95-5.888-25.812
              c-5.66-11.813-14.96-21.612-26.46-28.482C284.525,3.966,270.776,0.015,256.004,0c-19.652,0.015-37.555,7.027-50.719,18.637
              c-6.582,5.809-11.986,12.789-15.741,20.667c-3.771,7.862-5.895,16.631-5.895,25.812c0,11.696,3.459,22.705,9.37,32.082
              C198.078,105.217,204.918,112.072,212.991,117.436z M198.445,44.621c4.56-9.54,12.328-17.888,22.306-23.837
              c9.987-5.957,22.136-9.494,35.252-9.494c17.52,0,33.276,6.293,44.481,16.193c5.598,4.95,10.064,10.774,13.094,17.138
              c3.044,6.371,4.7,13.25,4.7,20.496c0,11.032-3.834,21.3-10.658,30.029c-6.809,8.705-16.631,15.74-28.264,19.831l-0.156,0.047
              l-0.156,0.07c-11.923,5.177-36.041,14.576-61.674,19.036l8.69-21.675l-4.271-2.444c-8.604-4.919-15.654-11.618-20.503-19.309
              c-4.857-7.706-7.527-16.365-7.535-25.586C193.753,57.871,195.4,50.992,198.445,44.621z" />
                                <path class="st0" d="M227.475,75.477c4.333,0,7.862-3.927,7.862-8.776c0-4.833-3.529-8.768-7.862-8.768
              c-4.341,0-7.855,3.935-7.855,8.768C219.619,71.55,223.133,75.477,227.475,75.477z" />
                                <path class="st0" d="M257.784,75.477c4.34,0,7.862-3.927,7.862-8.776c0-4.833-3.522-8.768-7.862-8.768
              c-4.342,0-7.862,3.935-7.862,8.768C249.922,71.55,253.443,75.477,257.784,75.477z" />
                                <path class="st0" d="M288.094,75.477c4.341,0,7.862-3.927,7.862-8.776c0-4.833-3.521-8.768-7.862-8.768
              c-4.342,0-7.862,3.935-7.862,8.768C280.231,71.55,283.752,75.477,288.094,75.477z" />
                            </g>
                        </svg>
                        Entretien passé</span>
                @elseif ($applicant->application_status == 'TEST_PASSED')
                    <span
                        class="inline-flex justify-center items-center bg-green-100 dark:bg-green-500/20 mx-auto px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-green-500 text-xs text-center status">
                        <svg width="14" height="14" viewBox="0 0 48 48" fill="none"
                            class="me-2 text-green-300 dark:text-green-500" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8 42H32C33.1046 42 34 41.1046 34 40V8C34 6.89543 33.1046 6 32 6H8C6.89543 6 6 6.89543 6 8V40C6 41.1046 6.89543 42 8 42ZM32 44H8C5.79086 44 4 42.2091 4 40V8C4 5.79086 5.79086 4 8 4H32C34.2091 4 36 5.79086 36 8V40C36 42.2091 34.2091 44 32 44Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18 13C18 12.4477 18.4477 12 19 12H31C31.5523 12 32 12.4477 32 13C32 13.5523 31.5523 14 31 14H19C18.4477 14 18 13.5523 18 13Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18 17C18 16.4477 18.4477 16 19 16H31C31.5523 16 32 16.4477 32 17C32 17.5523 31.5523 18 31 18H19C18.4477 18 18 17.5523 18 17Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18 25C18 24.4477 18.4477 24 19 24H31C31.5523 24 32 24.4477 32 25C32 25.5523 31.5523 26 31 26H19C18.4477 26 18 25.5523 18 25Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18 29C18 28.4477 18.4477 28 19 28H31C31.5523 28 32 28.4477 32 29C32 29.5523 31.5523 30 31 30H19C18.4477 30 18 29.5523 18 29Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 26V29H13V26H10ZM9 24H14C14.5523 24 15 24.4477 15 25V30C15 30.5523 14.5523 31 14 31H9C8.44772 31 8 30.5523 8 30V25C8 24.4477 8.44772 24 9 24Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.7071 12.2929C16.0976 12.6834 16.0976 13.3166 15.7071 13.7071L11 18.4142L8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929C8.68342 13.9024 9.31658 13.9024 9.70711 14.2929L11 15.5858L14.2929 12.2929C14.6834 11.9024 15.3166 11.9024 15.7071 12.2929Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M42 24H40V39.3333L41 40.6667L42 39.3333V24ZM44 40L41 44L38 40V22H44V40Z"
                                fill="#333333" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M42 17H40V19H42V17ZM40 15H42C43.1046 15 44 15.8954 44 17V21H38V17C38 15.8954 38.8954 15 40 15Z"
                                fill="#333333" />
                        </svg>
                        Test passé
                    </span>
                @endif
            </div>
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
                                    ({{ $applicant->getAge() }} {{ __('admin.years_old') }})</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">{{ __('admin.gender') }}</dt>
                                <dd class="font-semibold text-lg">{{ __("admin.genders.$applicant->gender") }}</dd>
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
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">Email</dt>
                                <dd class="font-semibold text-lg">{{ $applicant->user->email }}</dd>
                            </div>

                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                    {{ __('admin.specific_condition') }}</dt>
                                <dd class="font-semibold hover:text-blue-500 text-lg">{{ $applicant->vulnerability_type }}
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
                                        {{ __('admin.diploma_city') }}</dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->diploma_city }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.current_city') }}
                                    </dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->current_city }}</dd>
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
                                        {{ __('admin.school_name') }}</dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->school_name }}</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.option_studied') }}</dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->option_studied }}</dd>
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
                                            <img src="{{ $doc['url'] }}"
                                                alt="{{ __('admin.' . strtolower($doc['type'])) }}"
                                                class="w-full h-full object-cover">
                                        @elseif($doc['is_pdf'])
                                            <iframe src="{{ $doc['url'] }}"
                                                class="w-full h-full pointer-events-none"></iframe>
                                        @else
                                            <!-- DOC / DOCX -->
                                            <div class="flex flex-col items-center text-gray-600 dark:text-gray-300">
                                                <svg class="mb-2 w-12 h-12" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" viewBox="0 0 24 24">
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
                                        {{ __('admin.intended_field') }}</dt>
                                    <dd class="font-semibold text-lg">{{ $applicant->intended_field }}</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 dark:text-gray-400 md:text-lg">
                                        {{ __('admin.intended_field_motivation') }}</dt>
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
                                        {{ __('admin.additional_infos') }} %
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
                <div
                    class="flex flex-wrap items-center gap-y-4 pb-4 md:pb-5 border-gray-200 dark:border-gray-700 border-b">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Order ID:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">
                            <a href="#" class="hover:underline">#FWB12546798</a>
                        </dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Modifier:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">Vini</dd>
                    </dl>
                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Date:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">11.12.2023</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/5 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Price:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">$499</dd>
                    </dl>

                    <dl class="sm:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Status:</dt>
                        <dd
                            class="inline-flex justify-center items-center bg-yellow-100 dark:bg-yellow-900 mx-auto me-2 mt-1.5 px-2.5 py-0.5 rounded font-medium text-yellow-800 dark:text-yellow-300 text-xs text-center shrink-0">
                            <svg class="me-1 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z">
                                </path>
                            </svg>
                            In transit
                        </dd>
                    </dl>

                    <div class="sm:flex sm:justify-end sm:items-center sm:gap-4 w-full sm:w-32">
                        <button id="actionsMenuDropdownModal10" data-dropdown-toggle="dropdownOrderModal10"
                            type="button"
                            class="focus:z-10 flex justify-center items-center bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full md:w-auto font-medium text-gray-900 hover:text-primary-700 dark:hover:text-white dark:text-gray-400 text-sm">
                            Actions
                            <svg class="ms-1.5 -me-0.5 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal10"
                            class="hidden z-10 bg-white dark:bg-gray-700 shadow rounded-lg divide-y divide-gray-100 w-40"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 font-medium text-gray-500 dark:text-gray-400 text-sm text-left"
                                aria-labelledby="actionsMenuDropdown10">
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Order again</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Order details
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-modal-target="deleteOrderModal"
                                        data-modal-toggle="deleteOrderModal"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-red-600 dark:hover:text-white text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z">
                                            </path>
                                        </svg>
                                        Cancel order
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-wrap items-center gap-y-4 py-4 md:py-5 pb-4 border-gray-200 dark:border-gray-700 border-b">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">ID:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">
                            <a href="#" class="hover:underline">#FWB12546777</a>
                        </dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Modifier:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">Vini</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Date:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">10.11.2024</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/5 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Price:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">$3,287</dd>
                    </dl>

                    <dl class="sm:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Status:</dt>
                        <dd
                            class="inline-flex justify-center items-center bg-red-100 dark:bg-red-900 mx-auto mt-1.5 px-2.5 py-0.5 rounded font-medium text-red-800 dark:text-red-300 text-xs text-center">
                            <svg class="me-1 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"></path>
                            </svg>
                            Cancelled
                        </dd>
                    </dl>

                    <div class="sm:flex sm:justify-end sm:items-center sm:gap-4 w-full sm:w-32">
                        <button id="actionsMenuDropdownModal11" data-dropdown-toggle="dropdownOrderModal11"
                            type="button"
                            class="focus:z-10 flex justify-center items-center bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full md:w-auto font-medium text-gray-900 hover:text-primary-700 dark:hover:text-white dark:text-gray-400 text-sm">
                            Actions
                            <svg class="ms-1.5 -me-0.5 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal11"
                            class="hidden z-10 bg-white dark:bg-gray-700 shadow rounded-lg divide-y divide-gray-100 w-40"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 font-medium text-gray-500 dark:text-gray-400 text-sm text-left"
                                aria-labelledby="actionsMenuDropdown11">
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Order again</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Order details
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-wrap items-center gap-y-4 py-4 md:py-5 pb-4 border-gray-200 dark:border-gray-700 border-b">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">ID:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">
                            <a href="#" class="hover:underline">#FWB12546846</a>
                        </dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Modifier:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">Vini</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Date:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">07.11.2024</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/5 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Price:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">$111</dd>
                    </dl>

                    <dl class="sm:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Status:</dt>
                        <dd
                            class="inline-flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mt-1.5 px-2.5 py-0.5 rounded font-medium text-green-800 dark:text-green-300 text-xs text-center">
                            <svg class="me-1 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"></path>
                            </svg>
                            Completed
                        </dd>
                    </dl>

                    <div class="sm:flex sm:justify-end sm:items-center sm:gap-4 w-full sm:w-32">
                        <button id="actionsMenuDropdownModal12" data-dropdown-toggle="dropdownOrderModal12"
                            type="button"
                            class="focus:z-10 flex justify-center items-center bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full md:w-auto font-medium text-gray-900 hover:text-primary-700 dark:hover:text-white dark:text-gray-400 text-sm">
                            Actions
                            <svg class="ms-1.5 -me-0.5 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal12"
                            class="hidden z-10 bg-white dark:bg-gray-700 shadow rounded-lg divide-y divide-gray-100 w-40"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 font-medium text-gray-500 dark:text-gray-400 text-sm text-left"
                                aria-labelledby="actionsMenuDropdown12">
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Order again</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Order details
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-y-4 pt-4 md:pt-5">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">ID:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">
                            <a href="#" class="hover:underline">#FWB12546212</a>
                        </dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Modifier:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">Vini</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Date:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">18.10.2024</dd>
                    </dl>

                    <dl class="md:flex-1 w-1/2 sm:w-1/5 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Price:</dt>
                        <dd class="mt-1.5 font-semibold text-gray-900 dark:text-white text-base">$756</dd>
                    </dl>

                    <dl class="sm:flex-1 w-1/2 sm:w-1/4 lg:w-auto">
                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-base">Status:</dt>
                        <dd
                            class="inline-flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mt-1.5 px-2.5 py-0.5 rounded font-medium text-green-800 dark:text-green-300 text-xs text-center">
                            <svg class="me-1 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"></path>
                            </svg>
                            Completed
                        </dd>
                    </dl>

                    <div class="sm:flex sm:justify-end sm:items-center sm:gap-4 w-full sm:w-32">
                        <button id="actionsMenuDropdownModal13" data-dropdown-toggle="dropdownOrderModal13"
                            type="button"
                            class="focus:z-10 flex justify-center items-center bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 w-full md:w-auto font-medium text-gray-900 hover:text-primary-700 dark:hover:text-white dark:text-gray-400 text-sm">
                            Actions
                            <svg class="ms-1.5 -me-0.5 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal13"
                            class="hidden z-10 bg-white dark:bg-gray-700 shadow rounded-lg divide-y divide-gray-100 w-40"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 font-medium text-gray-500 dark:text-gray-400 text-sm text-left"
                                aria-labelledby="actionsMenuDropdown13">
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Order again</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-600 mx-auto px-3 py-2 rounded-md w-full text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                                        <svg class="me-1.5 w-4 h-4 text-gray-400 dark:group-hover:text-white dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Order details
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Modal -->
    @include('admin.applicants.partials.search-modal')
@endsection
@section('script')
    <script>
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
                        success: function(response) {
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
                        error: function(xhr, status, error) {
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
                        success: function(response) {
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
                        error: function(xhr, status, error) {
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
