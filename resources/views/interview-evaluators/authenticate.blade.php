@extends('interview-evaluators.layout')

@section('content')
    <section id="loginUser" class="bg-white dark:bg-gray-900 bg-cover bg-center">
        <div class="flex flex-col justify-center items-center mx-auto px-6 py-8 lg:py-0 min-h-screen">
            <h2 class="flex items-center mb-6">
                <a href="#" class="flex items-center space-x-2">
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
                        <form class="sign-in-form" action="{{ route('evaluator.postAuthenticate', app()->getLocale()) }}" autocomplete="off" method="post">
                            @csrf
                            <div class="space-y-4 md:space-y-6 p-6 sm:p-8">
                                <h2 class="font-bold dark:text-white text-2xl leading-tight tracking-tight">
                                    Connexion évaluateur
                                </h2>

                                @if (session('error'))
                                    <div class="flex items-center rounded-lg text-[#ff0000]" role="alert">
                                        <div class="ms-3 font-medium text-sm">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="flex items-center rounded-lg text-[#0f9d58]" role="alert">
                                        <div class="ms-3 font-medium text-sm">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-5">
                                    <label for="email" class="block mb-2 font-medium dark:text-white text-sm">Adresse mail</label>
                                    <input type="email" inputmode="email" autocomplete="off" id="email" name="email" value="{{ old('email') }}"
                                        class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-white-500 rounded-lg focus:ring-white-500 w-full text-gray-900 text-sm"
                                        placeholder="nom@vodacom.cd" required />
                                    @error('email')
                                        <p class="mt-1 text-[#ff0000] text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="coupon" class="block mb-2 font-medium dark:text-white text-sm">Coupon</label>
                                    <input type="text" autocomplete="off" id="coupon" name="coupon" value="{{ old('coupon') }}" placeholder="Votre coupon unique"
                                        class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-gray-500 rounded-lg focus:ring-gray-500 w-full text-gray-900 text-sm"
                                        required />
                                    @error('coupon')
                                        <p class="mt-1 text-[#ff0000] text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="bg-gray-900 hover:bg-gray-800 dark:bg-white dark:hover:bg-gray-200 border border-gray-700 hover:border-gray-600 dark:border-gray-300 dark:hover:border-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-500 w-full sm:w-48 h-10 font-bold text-white dark:text-black text-sm text-center">
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
                                Cette section est destinée uniquement à l'authentification des évaluateurs.<br>
                                Une fois connecté, vous n'aurez accès qu'à votre panel d'évaluation et à aucune autre section de l'administration du site.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
