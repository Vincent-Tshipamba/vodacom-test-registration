@extends('tests.layout')

@section('content')
    <section id="loginUser" class="bg-white dark:bg-gray-900 bg-cover bg-center">
        <div class="flex flex-col justify-center items-center mx-auto px-6 py-8 lg:py-0 min-h-screen">
            <h2 class="flex items-center mb-6">
                <a href="index.html"
                    class="flex items-center space-x-2">
                    <span class="group-data-[sidebar-size=sm]:hidden">
                        <img src="{{ asset('img/vodacom-seeklogo.png') }}" class="w-20 md:w-48" alt="Logo Vodacom">
                    </span>
                    <span class="group-data-[sidebar-size=sm]:block">
                        <img src="{{ asset('img/instant-school-logo.png') }}" alt="Logo Vodacom" class="w-8 md:w-14 h-8 md:h-14">
                    </span>
                </a>
            </h2>
            <div class="bg-white dark:bg-[#1c004c] opacity-95 shadow-md sm:rounded-lg overflow-hidden container">
                <div class="forms-container">
                    <div class="signin-signup">
                        <form class="sign-in-form" action="{{ route('scholarship.authenticate', app()->getLocale()) }}"
                            autocomplete="off" method="post">
                            @csrf
                            <div class="space-y-4 md:space-y-6 p-6 sm:p-8">
                                <h2 class="font-bold dark:text-white text-2xl leading-tight tracking-tight">
                                    Connexion
                                </h2>
                                @if (session('error'))
                                    <div id="alert-2" class="flex items-center rounded-lg text-[#ff0000]" role="alert">
                                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div class="ms-3 font-medium text-sm">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-5">
                                    <label for="national_exam_code"
                                        class="block mb-2 font-medium dark:text-white text-sm">{{ __('registration.student_code_label') }}</label>
                                    <input type="text" autocomplete="off" id="national_exam_code"
                                        name="national_exam_code" inputmode="numeric"
                                        class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-white-500 rounded-lg focus:ring-white-500 w-full text-gray-900 text-sm"
                                        placeholder="{{ __('registration.student_code_placeholder') }}" maxlength="14"
                                        pattern="\d{14}" title="{{ __('registration.validation.pattern') }}" required/>
                                </div>
                                <div class="mb-5">
                                    <label for="coupon"
                                        class="block mb-2 font-medium dark:text-white text-sm">Coupon</label>
                                    <input type="coupon" autocomplete="off" id="coupon" name="coupon"
                                        class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-gray-500 rounded-lg focus:ring-gray-500 w-full text-gray-900 text-sm"
                                        required />
                                </div>
                                <button type="submit"
                                    class="bg-gray-900 hover:bg-gray-800 dark:bg-white dark:hover:bg-gray-200 border dark:border border-gray-700 hover:border-gray-600 dark:border-gray-300 dark:border-red dark:hover:border-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-500 w-full sm:w-40 h-10 font-bold text-white dark:text-black text-sm text-center">
                                    Connexion
                                </button>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="panels-container">
                    <div class="left-panel panel">
                        <div class="content">
                            <p class="font-semibold text-sm sm:text-lg md:text-xl">
                                Cette section concerne l'authentification des candidats avant leur évaluation.<br>
                                Nous voulons juste vérifier votre identité pour s'assurer que vous êtes éligible à
                                participer au processus
                                d'évaluation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sign_in_btn = document.querySelector("#sign-in-btn");
            const container = document.querySelector(".container");

            const hasUnsuccessJury = @json(session('unsuccessJury'));

            if (hasUnsuccessJury) {
                container.classList.add("sign-up-mode");
            }
        });
    </script>
@endsection
