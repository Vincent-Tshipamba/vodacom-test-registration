<x-app-layout>
    @push('head')
        <meta name="translations"
            content="{{ json_encode([
                'personalized_option_field_value' => __('registration.personalized_option_field_value'),
                'personalized_university_field_value' => __('registration.personalized_university_field_value'),
            ]) }}">
    @endpush
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-center text-sm text-red-800 rounded-lg bg-white border-2 border-gray-400 shadow dark:bg-gray-800 dark:text-red-400"
                role="alert">

                <span class="font-medium">{{ $error }}</span>

            </div>
        @endforeach
    @endif

    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-300 pb-24">
        <form id="registrationForm" action="{{ route('scholarship.register.submit', app()->getLocale()) }}" method="POST"
            enctype="multipart/form-data" x-data="app()" @submit.prevent="submitForm" x-cloak>
            @csrf
            <div class="max-w-4xl mx-auto px-4 py-10">
                <!-- Confirmation Message -->
                <div x-show.transition="step === 'complete'">
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
                        <p class="text-gray-600 dark:text-gray-300 mb-6">{{ __('registration.confirmation_message') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                            {{ __('registration.confirmation_details') }}</p>
                        <a href="#"
                            class="inline-block px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
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
                                    <label for="firstname" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_firstname_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="firstname" name="firstname" x-model="formData.firstname"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.firstname }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.input_firstname_placeholder') }}">
                                    <p x-show="errors.firstname" class="mt-1 text-sm text-red-500"
                                        x-text="errors.firstname"></p>
                                </div>
                                <!-- Last Name -->
                                <div>
                                    <label for="lastname" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_lastname_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="lastname" name="lastname" x-model="formData.lastname"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.lastname }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        placeholder="{{ __('registration.input_lastname_placeholder') }}">
                                    <p x-show="errors.lastname" class="mt-1 text-sm text-red-500"
                                        x-text="errors.lastname"></p>
                                </div>
                                <!-- Phone Number -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_phone_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-gray-500">+243</span>
                                        </div>
                                        <input type="tel" id="phone" name="phone" x-model="formData.phone"
                                            class="w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                            :class="{ 'border-red-500': errors.phone }"
                                            data-error-phone="{{ __('registration.validation.phone') }}"
                                            data-error-required="{{ __('registration.validation.required') }}"
                                            placeholder="97 123 4567">
                                    </div>
                                    <p x-show="errors.phone" class="mt-1 text-sm text-red-500" x-text="errors.phone">
                                    </p>
                                </div>
                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        {{ __('registration.input_gender_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="gender" value="male"
                                                x-model="formData.gender"
                                                class="h-4 w-4 text-red-500 focus:ring-red-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                            <span class="ml-2">{{ __('registration.gender_male') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="gender" value="female"
                                                x-model="formData.gender"
                                                class="h-4 w-4 text-red-500 focus:ring-red-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                            <span class="ml-2">{{ __('registration.gender_female') }}</span>
                                        </label>
                                    </div>
                                    <p x-show="errors.gender" class="mt-1 text-sm text-red-500"
                                        x-text="errors.gender"></p>
                                </div>
                                <!-- Birthdate -->
                                <div>
                                    <label for="birthdate" class="block text-sm font-medium mb-1">
                                        {{ __('registration.input_birthdate_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="birthdate" name="birthdate"
                                        x-model="formData.birthdate" @change="calculateAge"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.birthdate }"
                                        data-error-required="{{ __('registration.validation.required') }}"
                                        data-error-age="{{ __('registration.validation.age_requirement') }}">
                                    <p x-show="errors.birthdate" class="mt-1 text-sm text-red-500"
                                        x-text="errors.birthdate"></p>
                                </div>
                                <!-- Age (auto-calculated) -->
                                <div x-show="formData.birthdate">
                                    <label class="block text-sm font-medium mb-1">
                                        {{ __('registration.age_label') }}
                                    </label>
                                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <span
                                            x-text="formData.age + ' ' + '{{ __('registration.years_old') }}'"></span>
                                    </div>
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
                                    <label for="study_option" class="block text-sm font-medium mb-1">
                                        {{ __('registration.study_option_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="study_option" name="study_option" x-model="formData.study_option"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.study_option }"
                                        data-error-required="{{ __('registration.validation.required') }}" required>
                                        <option value="">
                                            {{ __('registration.study_option_placeholder') }}
                                        </option>
                                        @foreach (__('registration.study_options') as $option)
                                            <option value="{{ $option }}">
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p x-show="errors.study_option" class="mt-1 text-sm text-red-500"
                                        x-text="errors.study_option"></p>
                                </div>
                                <div x-show="formData.study_option === '{{ __('registration.personalized_option_field_value') }}'"
                                    class="mt-2" x-transition>
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
                                        <input type="number" id="diploma_score" name="diploma_score"
                                            x-model="formData.diploma_score" min="50" max="100"
                                            step="1"
                                            data-error-required="{{ __('registration.validation.required') }}"
                                            data-error-percentage="{{ __('registration.validation.percentage') }}"
                                            class="w-full pl-12 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                            :class="{ 'border-red-500': errors.diploma_score }"
                                            placeholder="{{ __('registration.diploma_score_placeholder') }}" required>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">%</span>
                                        </div>
                                    </div>
                                    <p x-show="errors.diploma_score" class="mt-1 text-sm text-red-500"
                                        x-text="errors.diploma_score"></p>
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
                                    <label for="university_field" class="block text-sm font-medium mb-1">
                                        {{ __('registration.university_field_label') }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="university_field" name="university_field"
                                        x-model="formData.university_field" class="form-select"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        :class="{ 'border-red-500': errors.university_field }"
                                        data-error-required="{{ __('registration.validation.required') }}" required
                                        style="width: 100%">
                                        <option value="">{{ __('registration.select_option') }}</option>
                                        @foreach (__('registration.university_fields') as $category => $fields)
                                            @if (is_array($fields))
                                                <optgroup label="{{ $category }}">
                                                    @foreach ($fields as $field)
                                                        <option value="{{ $field }}">{{ $field }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $fields }}">{{ $fields }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <p x-show="errors.university_field" class="mt-1 text-sm text-red-500"
                                        x-text="errors.university_field"></p>

                                    <!-- Champ pour "Autre" -->
                                    <div x-show="formData.university_field === '{{ __('registration.personalized_university_field_value') }}'"
                                        class="mt-2">
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
                                    <label for="passion" class="block text-sm font-medium mb-1">
                                        {{ __('registration.passion_label') }} <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="passion" name="passion" rows="3" x-model="formData.passion"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700"
                                        data-error-required="{{ __('registration.validation.required') }}" :class="{ 'border-red-500': errors.passion }"
                                        placeholder="{{ __('registration.passion_placeholder') }}"></textarea>
                                    <p x-show="errors.passion" class="mt-1 text-sm text-red-500"
                                        x-text="errors.passion"></p>
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
                                    <label for="additional_info" class="block text-sm font-medium mb-1">
                                        {{ __('registration.additional_info_label') }}
                                    </label>
                                    <textarea id="additional_info" name="additional_info" rows="3" x-model="formData.additional_info"
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

                                        <button type="submit" x-show="step === 5"
                                            class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-red-500 hover:bg-red-600 font-medium">{{ __('registration.complete') }}</button>
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
