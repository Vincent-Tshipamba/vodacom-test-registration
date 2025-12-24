<x-app-layout>
    @push('head')
        <meta name="translations"
            content="{{ json_encode([
                'personalized_option_field_value' => __('registration.personalized_option_field_value'),
                'personalized_university_field_value' => __('registration.personalized_university_field_value'),
            ]) }}">
        <style>
            /* Fullscreen overlay for submitting state */
            .overlay-loading {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(2px);
            }

            .overlay-loading.show {
                display: flex;
            }

            /* From Uiverse.io by mobinkakei */
            #wifi-loader {
                --background: #62abff;
                --front-color: #4f29f0;
                --back-color: #c3c8de;
                --text-color: #414856;
                width: 64px;
                height: 64px;
                border-radius: 50px;
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #wifi-loader svg {
                position: absolute;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #wifi-loader svg circle {
                position: absolute;
                fill: none;
                stroke-width: 6px;
                stroke-linecap: round;
                stroke-linejoin: round;
                transform: rotate(-100deg);
                transform-origin: center;
            }

            #wifi-loader svg circle.back {
                stroke: var(--back-color);
            }

            #wifi-loader svg circle.front {
                stroke: var(--front-color);
            }

            #wifi-loader svg.circle-outer {
                height: 86px;
                width: 86px;
            }

            #wifi-loader svg.circle-outer circle {
                stroke-dasharray: 62.75 188.25;
            }

            #wifi-loader svg.circle-outer circle.back {
                animation: circle-outer135 1.8s ease infinite 0.3s;
            }

            #wifi-loader svg.circle-outer circle.front {
                animation: circle-outer135 1.8s ease infinite 0.15s;
            }

            #wifi-loader svg.circle-middle {
                height: 60px;
                width: 60px;
            }

            #wifi-loader svg.circle-middle circle {
                stroke-dasharray: 42.5 127.5;
            }

            #wifi-loader svg.circle-middle circle.back {
                animation: circle-middle6123 1.8s ease infinite 0.25s;
            }

            #wifi-loader svg.circle-middle circle.front {
                animation: circle-middle6123 1.8s ease infinite 0.1s;
            }

            #wifi-loader svg.circle-inner {
                height: 34px;
                width: 34px;
            }

            #wifi-loader svg.circle-inner circle {
                stroke-dasharray: 22 66;
            }

            #wifi-loader svg.circle-inner circle.back {
                animation: circle-inner162 1.8s ease infinite 0.2s;
            }

            #wifi-loader svg.circle-inner circle.front {
                animation: circle-inner162 1.8s ease infinite 0.05s;
            }

            #wifi-loader .text {
                position: absolute;
                bottom: -40px;
                display: flex;
                justify-content: center;
                align-items: center;
                text-transform: lowercase;
                font-weight: 500;
                font-size: 14px;
                letter-spacing: 0.2px;
            }

            #wifi-loader .text::before,
            #wifi-loader .text::after {
                content: attr(data-text);
            }

            #wifi-loader .text::before {
                color: var(--text-color);
            }

            #wifi-loader .text::after {
                color: var(--front-color);
                animation: text-animation76 3.6s ease infinite;
                position: absolute;
                left: 0;
            }

            @keyframes circle-outer135 {
                0% {
                    stroke-dashoffset: 25;
                }

                25% {
                    stroke-dashoffset: 0;
                }

                65% {
                    stroke-dashoffset: 301;
                }

                80% {
                    stroke-dashoffset: 276;
                }

                100% {
                    stroke-dashoffset: 276;
                }
            }

            @keyframes circle-middle6123 {
                0% {
                    stroke-dashoffset: 17;
                }

                25% {
                    stroke-dashoffset: 0;
                }

                65% {
                    stroke-dashoffset: 204;
                }

                80% {
                    stroke-dashoffset: 187;
                }

                100% {
                    stroke-dashoffset: 187;
                }
            }

            @keyframes circle-inner162 {
                0% {
                    stroke-dashoffset: 9;
                }

                25% {
                    stroke-dashoffset: 0;
                }

                65% {
                    stroke-dashoffset: 106;
                }

                80% {
                    stroke-dashoffset: 97;
                }

                100% {
                    stroke-dashoffset: 97;
                }
            }

            @keyframes text-animation76 {
                0% {
                    clip-path: inset(0 100% 0 0);
                }

                50% {
                    clip-path: inset(0);
                }

                100% {
                    clip-path: inset(0 0 0 100%);
                }
            }
        </style>
    @endpush
    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-300 pb-24">
        <form id="registrationForm" action="{{ route('scholarship.register.submit', app()->getLocale()) }}" method="POST"
            enctype="multipart/form-data" x-data="app()" @submit.prevent="submitForm" x-cloak>
            @csrf
            <div class="max-w-4xl mx-auto px-4 py-10">
                <div id="form-global-error" x-show="errors.general" x-text="errors.general"
                    class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700" style="display: none;">
                </div>
                <!-- Confirmation Message -->
                <div x-show.transition="step === 'complete'" id="confirmation">
                    <div class="bg-white dark:bg-slate-800 rounded-lg p-10 shadow-lg text-center">
                        <div
                            class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-green-500 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">{{ __('registration.confirmation_title') }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            {{ session('confirmation_message') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                            @if (session('confirmation_name'))
                                {{ __('registration.confirmation_details', ['firstname' => session('confirmation_name')]) }}
                            @else
                                {{ __('registration.confirmation_details') }}
                            @endif
                        </p>
                        @if (session('confirmation_coupon'))
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-6">
                                <p class="text-sm text-gray-500 dark:text-gray-300 mb-1">
                                    {{ __('Votre numéro de suivi') }}:</p>
                                <p class="text-xl font-mono font-bold text-gray-800 dark:text-white">
                                    {{ session('confirmation_coupon') }}
                                </p>
                            </div>
                        @endif
                        <a href="{{ url('/') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            {{ __('registration.return_home') }}
                        </a>
                    </div>
                </div>
                <!-- Form Steps -->
                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->
                    <div class="border-b-2 py-3">
                        <div>{{ __('registration.step') }} <span x-text="step"></span> {{ __('registration.of') }} 5
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div x-show="step === 1">
                                    <div class="text-lg font-bold leading-tight">
                                        {{ __('registration.step_1_title') }}</div>
                                </div>

                                <div x-show="step === 2">
                                    <div class="text-lg font-bold leading-tight">
                                        {{ __('registration.step_2_title') }}</div>
                                </div>

                                <div x-show="step === 3">
                                    <div class="text-lg font-bold leading-tight">
                                        {{ __('registration.step_3_title') }}</div>
                                </div>

                                <div x-show="step === 4">
                                    <div class="text-lg font-bold leading-tight">
                                        {{ __('registration.step_4_title') }}</div>
                                </div>

                                <div x-show="step === 5">
                                    <div class="text-lg font-bold leading-tight">
                                        {{ __('registration.step_5_title') }}</div>
                                </div>
                            </div>

                            {{-- Barre de progression --}}
                            <div class="flex items-center md:w-64">
                                <div class="w-full bg-white rounded-full mr-2">
                                    <div class="rounded-full bg-green-500 text-xs leading-none h-2 text-center"
                                        :style="'width: ' + parseInt(step / 5 * 100) + '%'"></div>
                                </div>
                                <div class="text-xs w-10" x-text="parseInt(step / 5 * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->
                    <!-- Step Content -->
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-8 mb-6">
                        <!-- Step 1: Personal Information -->
                        <div x-show.transition.in="step === 1">
                            {{-- <h3 class="text-xl font-bold mb-6">{{ __('registration.step_1_title') }}</h3> --}}

                            <!-- Photo Upload -->
                            <div class="mb-5 text-center">
                                <div
                                    class="mx-auto w-32 h-32 mb-2 border rounded-full relative bg-gray-100 mb-4 shadow-inset">
                                    <img id="image" class="object-cover w-full h-32 rounded-full"
                                        :src="image" />
                                </div>

                                <label for="fileInput" type="button"
                                    class="cursor-pointer inline-flex justify-between items-center focus:outline-none border py-2 px-4 rounded-lg shadow-sm text-left text-gray-600 bg-white dark:bg-slate-800 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                    {{ __('registration.browse_photo') }}
                                </label>

                                <div class="mx-auto w-48 text-gray-500 text-xs text-center mt-1">
                                    {{ __('registration.browse_photo_label') }}
                                </div>
                                <p x-show="errors.photo" class="mt-1 text-sm text-red-500" x-text="errors.photo"></p>

                                <input name="photo" id="fileInput" accept="image/*" class="hidden" type="file"
                                    data-error-size="{{ __('registration.validation.file_size', ['size' => 5]) }}"
                                    data-error-type="{{ __('registration.validation.file_type') }}"
                                    @change="let file = document.getElementById('fileInput').files[0];
                                    var reader = new FileReader();
                                    reader.onload = (e) => image = e.target.result;
                                    reader.readAsDataURL(file);formData.photo = $event.target.files[0]">
                            </div>
                            <!-- Personal Info Form -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div>
                                    <label for="first_name" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_firstname_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="first_name" name="first_name"
                                        x-model="formData.first_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.first_name }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.input_firstname_placeholder') }}">
                                    <p x-show="errors.first_name" class="mt-1 text-sm text-red-500"
                                        x-text="errors.first_name"></p>
                                </div>
                                <!-- Last Name -->
                                <div>
                                    <label for="last_name" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_lastname_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="last_name" name="last_name"
                                        x-model="formData.last_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.last_name }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.input_lastname_placeholder') }}">
                                    <p x-show="errors.last_name" class="mt-1 text-sm text-red-500"
                                        x-text="errors.last_name"></p>
                                </div>
                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_phone_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-gray-500">+243</span>
                                        </div>
                                        <input type="tel" id="phone_number" name="phone_number"
                                            x-model="formData.phone_number"
                                            class="w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                            :class="{ 'border-red-500': errors.phone_number }"
                                            data-error-phone="{{ __('registration.validation.phone') }}"
                                            data-error-required="{{ __('registration.validation.required') }}"
                                            placeholder="97 123 4567">
                                    </div>
                                    <p x-show="errors.phone_number" class="mt-1 text-sm text-red-500"
                                        x-text="errors.phone_number">
                                    </p>
                                </div>
                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        {{ __('registration.input_gender_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $genders = App\Helpers\FormOptionsHelper::getGenders();
                                    @endphp
                                    <div class="flex space-x-4">
                                        @foreach ($genders as $value => $label)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="gender" value="{{ $value }}"
                                                    x-model="formData.gender"
                                                    class="h-4 w-4 text-red-500 focus:ring-red-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                                <span class="ml-2">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <p x-show="errors.gender" class="mt-1 text-sm text-red-500"
                                        x-text="errors.gender"></p>
                                </div>
                                <!-- Birthdate -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_birthdate_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        x-model="formData.date_of_birth" @change="calculateAge"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.date_of_birth }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        data-error-age="{{ __('registration.validation.age_requirement') }}">
                                    <p x-show="errors.date_of_birth" class="mt-1 text-sm text-red-500"
                                        x-text="errors.date_of_birth"></p>
                                </div>
                                <!-- Age (auto-calculated) -->
                                <div x-show="formData.date_of_birth">
                                    <label class="block text-sm font-medium mb-1">
                                        {{ __('registration.age_label') }}
                                    </label>
                                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <span
                                            x-text="formData.age + ' ' + '{{ __('registration.years_old') }}'"></span>
                                    </div>
                                </div>

                                <!-- Type d'identification -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        {{ __('registration.identification_type_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $identificationTypes = App\Helpers\FormOptionsHelper::getIdentificationTypes();
                                    @endphp
                                    <div class="space-y-2">
                                        @foreach ($identificationTypes as $value => $label)
                                            <div class="flex items-center">
                                                <input type="radio" id="{{ $value }}"
                                                    name="vulnerability_type" value="{{ $value }}"
                                                    x-model="formData.vulnerability_type"
                                                    class="h-4 w-4 text-red-500 focus:ring-red-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                    @if ($value === 'none') checked @endif>
                                                <label for="{{ $value }}" class="ml-2 block text-sm">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p x-show="errors.vulnerability_type" class="mt-1 text-sm text-red-500"
                                        x-text="errors.vulnerability_type"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2: Address Information -->
                        <div x-show.transition.in="step === 2">
                            {{-- <h3 class="text-xl font-bold mb-6">{{ __('registration.step_2_title') }}</h3> --}}

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Current City -->
                                <div class="md:col-span-2">
                                    <label for="current_city" class="block text-sm font-medium mb-1">
                                        {{ __('registration.current_city_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="current_city" name="current_city"
                                        x-model="formData.current_city"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.current_city }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.current_city_placeholder') }}" required>
                                    <p x-show="errors.current_city" class="mt-1 text-sm text-red-500"
                                        x-text="errors.current_city"></p>
                                </div>
                                <!-- Diploma City -->
                                <div class="md:col-span-2">
                                    <label for="diploma_city" class="block text-sm font-medium mb-1">
                                        {{ __('registration.diploma_city_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="diploma_city" name="diploma_city"
                                        x-model="formData.diploma_city"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.diploma_city }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.diploma_city_placeholder') }}" required>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('registration.validation.diploma_city_help') }}
                                    </p>
                                    <p x-show="errors.diploma_city" class="mt-1 text-sm text-red-500"
                                        x-text="errors.diploma_city"></p>
                                </div>
                                <!-- Full Address -->
                                <div class="md:col-span-2">
                                    <label for="full_address" class="block text-sm font-medium mb-1">
                                        {{ __('registration.full_address_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <textarea id="full_address" name="full_address" rows="3" x-model="formData.full_address"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.full_address }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.full_address_placeholder') }}"></textarea>
                                    <p x-show="errors.full_address" class="mt-1 text-sm text-red-500"
                                        x-text="errors.full_address"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 3: Academic Information -->
                        <div x-show.transition.in="step === 3">
                            {{-- <h3 class="text-xl font-bold mb-6">{{ __('registration.step_3_title') }}</h3> --}}

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- School Name -->
                                <div class="md:col-span-2">
                                    <label for="school_name" class="block text-sm font-medium mb-1">
                                        {{ __('registration.school_name_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="school_name" name="school_name"
                                        x-model="formData.school_name"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.school_name }"
                                        placeholder="{{ __('registration.school_name_placeholder') }}">
                                    <p x-show="errors.school_name" class="mt-1 text-sm text-red-500"
                                        x-text="errors.school_name"></p>
                                </div>
                                <!-- Study Option -->
                                <div>
                                    <label for="option_studied" class="block text-sm font-medium mb-1">
                                        {{ __('registration.study_option_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $studyOptions = App\Helpers\FormOptionsHelper::getStudyOptions();
                                    @endphp
                                    <select id="option_studied" name="option_studied"
                                        x-model="formData.option_studied"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.option_studied }"
                                        data-error-required="{{ __('registration.validation.required') }}" required>
                                        <option value="">
                                            {{ __('registration.study_option_placeholder') }}
                                        </option>
                                        @foreach ($studyOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <p x-show="errors.option_studied" class="mt-1 text-sm text-red-500"
                                        x-text="errors.option_studied"></p>
                                </div>
                                <div x-show="formData.option_studied === 'other'" class="mt-2" x-transition>
                                    <label for="other_study_option" class="block text-sm font-medium mb-1">
                                        {{ __('registration.other_study_option_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="other_study_option" name="other_study_option"
                                        x-model="formData.other_study_option"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.other_study_option }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.other_study_option_placeholder') }}">
                                    <p x-show="errors.other_study_option" class="mt-1 text-sm text-red-500"
                                        x-text="errors.other_study_option"></p>
                                </div>
                                <!-- Diploma Score -->
                                <div>
                                    <label for="diploma_score" class="block text-sm font-medium mb-1">
                                        {{ __('registration.diploma_score_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="percentage" name="percentage"
                                            x-model="formData.percentage" min="50" max="100"
                                            pattern="\d{3}" step="1"
                                            data-error-required="{{ __('registration.validation.required') }}"
                                            data-error-percentage="{{ __('registration.validation.percentage') }}"
                                            class="w-full pl-12 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                            :class="{ 'border-red-500': errors.percentage }"
                                            placeholder="{{ __('registration.diploma_score_placeholder') }}" required>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">%</span>
                                        </div>
                                    </div>
                                    <p x-show="errors.percentage" class="mt-1 text-sm text-red-500"
                                        x-text="errors.percentage"></p>
                                </div>

                                <!-- Code élève -->
                                <div>
                                    <label for="national_exam_code" class="block text-sm font-medium mb-1">
                                        {{ __('registration.student_code_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="national_exam_code" name="national_exam_code"
                                        x-model="formData.national_exam_code"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.national_exam_code }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        data-error-pattern="{{ __('registration.validation.pattern') }}"
                                        placeholder="{{ __('registration.student_code_placeholder') }}"
                                        maxlength="14" pattern="\d{14}"
                                        title="{{ __('registration.validation.pattern') }}" required>
                                    <p x-show="errors.national_exam_code" class="mt-1 text-sm text-red-500"
                                        x-text="errors.national_exam_code"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 4: Documents -->
                        <div x-show.transition.in="step === 4">
                            {{-- <h3 class="text-xl font-bold mb-6">{{ __('registration.step_4_title') }}</h3> --}}

                            <div class="space-y-8">
                                <!-- ID Document -->
                                <div>
                                    <label for="id_document" class="block text-sm font-medium mb-2">
                                        {{ __('registration.id_document_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        <label for="id_document" class="cursor-pointer">
                                            <div
                                                class="px-4 py-6 w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center hover:border-red-400 transition-colors">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                    <span
                                                        class="font-medium text-red-500 hover:text-red-600">Télécharger
                                                        un fichier</span> ou glisser-déposer
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1"
                                                    x-text="formData.id_document ? formData.id_document.name : ''">
                                                </p>
                                            </div>
                                            <input id="id_document" name="id_document" type="file"
                                                accept=".pdf,image/*,.doc,.docx,.jpg,.jpeg,.png" class="sr-only"
                                                data-error-size="{{ __('registration.validation.file_size', ['size' => 5]) }}"
                                                data-error-type="{{ __('registration.validation.file_type') }}"
                                                data-error-required="{{ __('registration.validation.required') }}"
                                                @change="formData.id_document = $event.target.files[0]">
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('registration.id_document_hint') }}</p>
                                    <p x-show="errors.id_document" class="mt-1 text-sm text-red-500"
                                        x-text="errors.id_document"></p>
                                </div>
                                <!-- Diploma Document -->
                                <div>
                                    <label for="diploma" class="block text-sm font-medium mb-2">
                                        {{ __('registration.diploma_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        <label for="diploma" class="cursor-pointer">
                                            <div
                                                class="px-4 py-6 w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center hover:border-red-400 transition-colors">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                    <span
                                                        class="font-medium text-red-500 hover:text-red-600">Télécharger
                                                        un fichier</span> ou glisser-déposer
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1"
                                                    x-text="formData.diploma ? formData.diploma.name : ''"></p>
                                            </div>
                                            <input id="diploma" name="diploma" type="file" class="sr-only"
                                                accept=".pdf,image/*,.doc,.docx,.jpg,.jpeg,.png"
                                                data-error-size="{{ __('registration.validation.file_size', ['size' => 5]) }}"
                                                data-error-type="{{ __('registration.validation.file_type') }}"
                                                data-error-required="{{ __('registration.validation.required') }}"
                                                @change="formData.diploma = $event.target.files[0]" required>
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('registration.diploma_hint') }}</p>
                                    <p x-show="errors.diploma" class="mt-1 text-sm text-red-500"
                                        x-text="errors.diploma"></p>
                                </div>
                                <!-- Recommendation Letter -->
                                <div>
                                    <label for="recommendation" class="block text-sm font-medium mb-2">
                                        {{ __('registration.recommendation_label') }}
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        <label for="recommendation" class="cursor-pointer">
                                            <div
                                                class="px-4 py-6 w-full border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center hover:border-red-400 transition-colors">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                    <span
                                                        class="font-medium text-red-500 hover:text-red-600">Télécharger
                                                        un fichier</span> ou glisser-déposer
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1"
                                                    x-text="formData.recommendation ? formData.recommendation.name : ''">
                                                </p>
                                            </div>
                                            <input id="recommendation" name="recommendation" type="file"
                                                accept=".pdf,image/*,.doc,.docx,.jpg,.jpeg,.png" class="sr-only"
                                                data-error-size="{{ __('registration.validation.file_size', ['size' => 5]) }}"
                                                data-error-type="{{ __('registration.validation.file_type') }}"
                                                @change="formData.recommendation = $event.target.files[0]">
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('registration.recommendation_hint') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Personal Ambitions -->
                        <div x-show.transition.in="step === 5">
                            {{-- <h3 class="text-xl font-bold mb-6">{{ __('registration.step_5_title') }}</h3> --}}

                            <div class="space-y-6">
                                <!-- University Field -->
                                <div>
                                    <label for="intended_field" class="block text-sm font-medium mb-1">
                                        {{ __('registration.university_field_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $universityFields = App\Helpers\FormOptionsHelper::getUniversityFields();
                                    @endphp
                                    <select id="intended_field" name="intended_field"
                                        x-model="formData.intended_field" class="form-select"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.intended_field }"
                                        data-error-required="{{ __('registration.validation.required') }}" required
                                        style="width: 100%">
                                        <option value="">{{ __('registration.select_option') }}</option>
                                        @foreach ($universityFields as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <p x-show="errors.intended_field" class="mt-1 text-sm text-red-500"
                                        x-text="errors.intended_field"></p>

                                    <!-- Champ pour "Autre" -->
                                    <div x-show="formData.intended_field === 'other'" class="mt-2">
                                        <label for="other_university_field" class="block text-sm font-medium mb-1">
                                            {{ __('registration.other_university_field_label') }} <span
                                                class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="other_university_field"
                                            name="other_university_field" x-model="formData.other_university_field"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                            :class="{ 'border-red-500': errors.other_university_field }"
                                            data-error-required="{{ __('registration.validation.required') }}"
                                            placeholder="{{ __('registration.other_university_field_placeholder') }}">
                                        <p x-show="errors.other_university_field" class="mt-1 text-sm text-red-500"
                                            x-text="errors.other_university_field"></p>
                                    </div>
                                </div>
                                <!-- Passion -->
                                <div>
                                    <label for="intended_field_motivation" class="block text-sm font-medium mb-1">
                                        {{ __('registration.passion_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="intended_field_motivation" name="intended_field_motivation" rows="3"
                                        x-model="formData.intended_field_motivation"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        :class="{ 'border-red-500': errors.intended_field_motivation }"
                                        placeholder="{{ __('registration.passion_placeholder') }}"></textarea>
                                    <p x-show="errors.intended_field_motivation" class="mt-1 text-sm text-red-500"
                                        x-text="errors.intended_field_motivation"></p>
                                </div>
                                <!-- Career Goals -->
                                <div>
                                    <label for="career_goals" class="block text-sm font-medium mb-1">
                                        {{ __('registration.career_goals_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <textarea id="career_goals" name="career_goals" rows="3" x-model="formData.career_goals"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        :class="{ 'border-red-500': errors.career_goals }"
                                        placeholder="{{ __('registration.career_goals_placeholder') }}"></textarea>
                                    <p x-show="errors.career_goals" class="mt-1 text-sm text-red-500"
                                        x-text="errors.career_goals"></p>
                                </div>
                                <!-- Additional Information -->
                                <div>
                                    <label for="additional_infos" class="block text-sm font-medium mb-1">
                                        {{ __('registration.additional_info_label') }}
                                    </label>
                                    <textarea id="additional_infos" name="additional_infos" rows="3" x-model="formData.additional_infos"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        placeholder="{{ __('registration.additional_info_placeholder') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Navigation -->
                        <div class="fixed bottom-0 left-0 right-0 py-5 bg-white dark:bg-gray-900 shadow-md"
                            x-show="step != 'complete'">
                            <div class="max-w-3xl mx-auto px-4">
                                <div class="flex justify-between">
                                    <div class="w-1/2">
                                        <button type="button" x-show="step > 1" @click="prevStep()"
                                            class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">{{ __('registration.previous') }}</button>
                                    </div>

                                    <div class="w-1/2 text-right">
                                        <button type="button" x-show="step < 5" @click="nextStep()"
                                            class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-red-500 hover:bg-red-600 font-medium">{{ __('registration.next') }}</button>

                                        <button type="submit" x-show="step === 5" :disabled="isSubmitting"
                                            class="w-32 inline-flex items-center justify-center gap-2 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-red-500 hover:bg-red-600 font-medium disabled:opacity-60 disabled:cursor-not-allowed">
                                            <svg x-show="isSubmitting" class="animate-spin h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                            <span
                                                x-text="isSubmitting ? '{{ __('registration.submitting') }}' : '{{ __('registration.complete') }}'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Bottom Navigation https://placehold.co/300x300/e2e8f0/cccccc -->
                    </div>
                </div>
        </form>
    </div>
    @push('scripts')
        <script src="{{ asset('js/registration-form.js') }}"></script>
    @endpush
</x-app-layout>
