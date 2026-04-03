@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/3.1.3/css/select.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css">
    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.5/css/searchPanes.dataTables.css"> --}}
@endpush
@section('content')
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
            <div class="col-span-12 md:order-1 xl:col-span-8 2xl:col-span-6 mt-3">
                <h5 class="mb-2">{{ __('messages.welcome', ['username' => Auth::user()->name]) }} 🎉</h5>
            </div>
            <div class="col-span-12 md:order-3 lg:col-span-6 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="grid grid-cols-12">
                        <div class="col-span-8 md:col-span-9">
                            <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.total_boursiers') }}</p>
                            <h5 class="mt-3 mb-4"><span class="counter-value"
                                    data-target="{{ $count_boursiers }}">{{ $count_boursiers }}</span></h5>
                        </div>
                        <div class="col-span-4 md:col-span-3">
                            <div id="totalBoursiersChart" data-chart-colors='["bg-custom-500"]'
                                data-total="{{ $count_boursiers }}" dir="ltr" class="grow apex-charts"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <p class="text-slate-500 dark:text-slate-200 grow"><span
                                class="font-medium text-green-500">15%</span> Increase</p>
                        <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.this_year') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-4 lg:col-span-6 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="grid grid-cols-12">
                        <div class="col-span-8 md:col-span-9">
                            <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.total_applicants_this_year') }}
                            </p>
                            <h5 class="mt-3 mb-4"><span class="counter-value"
                                    data-target="{{ $count_applicants_this_year }}">{{ $count_applicants_this_year }}</span>
                            </h5>
                        </div>
                        <div class="col-span-4 md:col-span-3">
                            <div id="totalApplicationChart" data-chart-colors='["bg-purple-500"]' dir="ltr"
                                data-total="{{ $count_applicants_this_year }}" class="grow apex-charts"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <p class="text-slate-500 dark:text-slate-200 grow"><span
                                class="font-medium text-green-500">26%</span> Increase</p>
                        <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.this_year') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-7 2xl:order-5 lg:col-span-12 2xl:col-span-6 2xl:row-span-2 card">
                <div class="card-body">
                    <div class="flex items-center gap-2 MB-3">
                        <h6 class="mb-0 text-15 grow">Évolution des candidatures par année universitaire</h6>

                    </div>
                    <div id="applicantsByYearChart" class="apex-charts"
                        data-chart-colors='["bg-custom-500", "bg-green-500"]' data-years='@json($years)'
                        data-counts='@json(array_values($applicantsByYear))' dir="ltr"></div>
                </div>
            </div>
            <div class="col-span-12 md:order-5 2xl:order-6 lg:col-span-6 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="grid grid-cols-12">
                        <div class="col-span-8 md:col-span-9">
                            <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.total_accepted_applicants') }}
                            </p>
                            <h5 class="mt-3 mb-4"><span class="counter-value"
                                    data-target="{{ $count_accepted_applicants }}">{{ $count_accepted_applicants }}</span>
                            </h5>
                        </div>
                        <div class="col-span-4 md:col-span-3">
                            <div id="acceptedCandidatesChart" data-chart-colors='["bg-green-500"]' dir="ltr"
                                data-total="{{ $count_accepted_applicants }}" class="grow apex-charts"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <p class="text-slate-500 dark:text-slate-200 grow"><span class="font-medium text-red-500">05%</span>
                            Increase</p>
                        <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.this_year') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-6 2xl:order-7 lg:col-span-6 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="grid grid-cols-12">
                        <div class="col-span-8 md:col-span-9">
                            <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.total_rejected_applicants') }}
                            </p>
                            <h5 class="mt-3 mb-4"><span class="counter-value"
                                    data-target="{{ $count_rejected_applicants }}">{{ $count_rejected_applicants }}</span>
                            </h5>
                        </div>
                        <div class="col-span-4 md:col-span-3">
                            <div id="rejectedCandidatesChart" data-chart-colors='["bg-red-500"]' dir="ltr"
                                data-total="{{ $count_rejected_applicants }}" class="grow apex-charts"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <p class="text-slate-500 dark:text-slate-200 grow"><span class="font-medium text-red-500">16%</span>
                            Increase</p>
                        <p class="text-slate-500 dark:text-slate-200">{{ __('dashboard.this_year') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-8 2xl:col-span-9 card">
                <div class="card-body">
                    <div class="grid items-center grid-cols-1 gap-3 mb-5 xl:grid-cols-12">
                        <div class="xl:col-span-3">
                            <h6 class="text-15">
                                @if ($current_edition)
                                    {{ __('dashboard.list_recent_applicants') }}
                                @else
                                    {{ __('dashboard.list_performance_boursiers') }}
                                @endif
                            </h6>
                        </div><!--end col-->
                        <div class="xl:col-span-4 xl:col-start-10">
                            <div class="flex gap-3">
                                <div class="relative grow">
                                    <input type="text"
                                        class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                        placeholder="Search for ..." autocomplete="off">
                                    <i data-lucide="search"
                                        class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>
                                </div>
                                <button type="button"
                                    class="bg-white border-dashed shrink-0 text-custom-500 btn border-custom-500 hover:text-custom-500 hover:bg-custom-50 hover:border-custom-600 focus:text-custom-600 focus:bg-custom-50 focus:border-custom-600 active:text-custom-600 active:bg-custom-50 active:border-custom-600 dark:bg-zink-700 dark:ring-custom-400/20 dark:hover:bg-custom-800/20 dark:focus:bg-custom-800/20 dark:active:bg-custom-800/20"><i
                                        class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Export</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end grid-->
                    <div class="-mx-5 overflow-x-auto">
                        @if ($current_edition->status == 'SELECTION_PHASE')
                            <table class="w-full whitespace-nowrap" id="recentApplicantTable">
                                <thead
                                    class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                    <tr>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            #</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            Noms</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            Téléphone</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            Pourcentage</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            Ville</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                            Statut actuel </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicants as $key => $applicant)
                                        <tr>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                <a href="#!">{{ $key + 1 }}</a>
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                <div class="flex gap-2">
                                                    <div class="bg-green-100 rounded-full size-10 dark:bg-green-500/20 shrink-0">
                                                        <img src="./assets/images/avatar-10.png" alt="" class="h-10 rounded-full">
                                                    </div>
                                                    <div class="grow">
                                                        <h6>{{ $applicant->first_name . ' ' . $applicant->last_name }}</h6>
                                                        <p class="text-slate-500 dark:text-zink-200">
                                                            {{ $applicant->user->email ?? 'No email provided' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                {{ $applicant->phone_number }}
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                {{ $applicant->percentage }}
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 text-green-500">
                                                {{ $applicant->current_city->name }}
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                <span
                                                    class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-green-200 text-green-500 dark:bg-green-500/20 dark:border-green-500/20">Active</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div
                class="col-span-12 md:order-9 lg:col-span-6 lg:row-span-2 xl:col-span-4 xl:row-span-2 2xl:row-span-2 2xl:col-span-3 card">
                <div class="card-body">
                    <h6 class="mb-3 text-15 grow">Upcoming Scheduled</h6>
                    <div id="calendar" class="w-auto p-1"></div>
                    <div class="flex flex-col gap-4 mt-3">
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>28</h6> <span class="text-sm text-slate-500 dark:text-zink-200">July</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Meeting with Designer <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">09:57
                                        AM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by Admin</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>08</h6> <span class="text-sm text-slate-500 dark:text-zink-200">June</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Developing Line Managers Conference <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">10:54
                                        AM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by HR</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>17</h6> <span class="text-sm text-slate-500 dark:text-zink-200">July</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Airplane in Las Vegas <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">12:00
                                        PM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by HR</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>11</h6> <span class="text-sm text-slate-500 dark:text-zink-200">Nov</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Hospitality Project Discuses</h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by Admin</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>20</h6> <span class="text-sm text-slate-500 dark:text-zink-200">Nov</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Gartner Digital Workplace <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">03:49
                                        PM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by HR</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>04</h6> <span class="text-sm text-slate-500 dark:text-zink-200">Dec</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">Nordic People Analytics <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">11:00
                                        AM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by Admin</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>17</h6> <span class="text-sm text-slate-500 dark:text-zink-200">Jan</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">CIPD Festival of Work <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">01:29
                                        PM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by HR</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div
                                class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                <h6>03</h6> <span class="text-sm text-slate-500 dark:text-zink-200">Feb</span>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1">HRO Today Forum <small
                                        class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">02:15
                                        PM</small></h6>
                                <p class="text-slate-500 dark:text-zink-200">Created by Admin</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3 p-2 mt-3 rounded-md bg-custom-500">
                        <div class="shrink-0">
                            <img src="./assets/images/support.png" alt="" class="h-24">
                        </div>
                        <div>
                            <h6 class="mb-1 text-15 text-custom-50">Need Help ?</h6>
                            <p class="text-custom-200">If you would like to learn more about transferring the license to a
                                customer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-10 lg:col-span-6 xl:col-span-4 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="flex items-center gap-2 mb-3">
                        <h6 class="text-15 grow">Total Projects (247)</h6>
                        <div class="relative dropdown shrink-0">
                            <button type="button"
                                class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                id="userDeviceDropdown" data-bs-toggle="dropdown">
                                <i data-lucide="more-vertical" class="inline-block size-4"></i>
                            </button>

                            <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                aria-labelledby="userDeviceDropdown">
                                <li>
                                    <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                        href="#!">1 Weekly</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                        href="#!">1 Monthly</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                        href="#!">3 Monthly</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                        href="#!">6 Monthly</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                        href="#!">{{ __('dashboard.this_year') }}ly</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="totalProjectChart" class="-ml-2 apex-charts"
                        data-chart-colors='["bg-custom-500", "bg-yellow-500", "bg-green-400", "bg-red-400"]' dir="ltr">
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-11 lg:col-span-6 xl:col-span-4 2xl:col-span-3 card">
                <div class="!pb-0 card-body">
                    <h6 class="mb-3 text-15">Upcoming Interview</h6>
                </div>
                <div class="pb-5">
                    <div data-simplebar class="flex flex-col h-[350px] gap-4 px-5">
                        <div class="flex flex-col gap-3">
                            <div class="border rounded-md border-slate-200 dark:border-zink-500">
                                <div class="flex flex-wrap items-center gap-3 p-2">
                                    <div class="rounded-full size-10 shrink-0">
                                        <img src="./assets/images/user-1.jpg" alt="" class="h-10 rounded-full">
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-1"><a href="#!">James Krogman</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">james@tailwick.com</p>
                                    </div>
                                    <div class="relative dropdown shrink-0">
                                        <button type="button"
                                            class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                            id="interviewDropdown" data-bs-toggle="dropdown">
                                            <i data-lucide="more-vertical" class="inline-block size-4"></i>
                                        </button>

                                        <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                            aria-labelledby="interviewDropdown">
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Overview</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Edit</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-2 border-t border-slate-200 dark:border-zink-500">
                                    <div class="flex flex-col gap-3 md:items-center md:flex-row">
                                        <p class="text-slate-500 dark:text-zink-200 shrink-0"><i data-lucide="calendar"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">25 Nov</span></p>
                                        <p class="text-slate-500 dark:text-zink-200 grow"><i data-lucide="clock-4"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">02:41 PM</span></p>
                                        <span
                                            class="px-2.5 py-0.5 text-xs inline-block text-center font-medium shrink-0 rounded border bg-white border-green-400 text-green-500 dark:bg-zink-700 dark:border-green-700">Confirm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded-md border-slate-200 dark:border-zink-500">
                                <div class="flex flex-wrap items-center gap-3 p-2">
                                    <div class="rounded-full size-10 shrink-0">
                                        <img src="./assets/images/user-2.jpg" alt="" class="h-10 rounded-full">
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-1"><a href="#!">Michael Scott</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">michaelScott@tailwick.com</p>
                                    </div>
                                    <div class="relative dropdown shrink-0">
                                        <button type="button"
                                            class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                            id="interviewDropdown2" data-bs-toggle="dropdown">
                                            <i data-lucide="more-vertical" class="inline-block size-4"></i>
                                        </button>

                                        <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                            aria-labelledby="interviewDropdown2">
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Overview</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Edit</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-2 border-t border-slate-200 dark:border-zink-500">
                                    <div class="flex flex-col gap-3 md:items-center md:flex-row">
                                        <p class="text-slate-500 dark:text-zink-200 shrink-0"><i data-lucide="calendar"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">05 Dec</span></p>
                                        <p class="text-slate-500 dark:text-zink-200 grow"><i data-lucide="clock-4"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">01:23 PM</span></p>
                                        <span
                                            class="px-2.5 py-0.5 text-xs text-center inline-block font-medium shrink-0 rounded border bg-white border-custom-400 text-custom-500 dark:bg-zink-700 dark:border-custom-700">Re-scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded-md border-slate-200 dark:border-zink-500">
                                <div class="flex flex-wrap items-center gap-3 p-2">
                                    <div class="rounded-full size-10 shrink-0">
                                        <img src="./assets/images/user-3.jpg" alt="" class="h-10 rounded-full">
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-1"><a href="#!">Denise Ledford</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">ledford@tailwick.com</p>
                                    </div>
                                    <div class="relative dropdown shrink-0">
                                        <button type="button"
                                            class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                            id="interviewDropdown3" data-bs-toggle="dropdown">
                                            <i data-lucide="more-vertical" class="inline-block size-4"></i>
                                        </button>

                                        <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                            aria-labelledby="interviewDropdown3">
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Overview</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Edit</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-2 border-t border-slate-200 dark:border-zink-500">
                                    <div class="flex flex-col gap-3 md:items-center md:flex-row">
                                        <p class="text-slate-500 dark:text-zink-200 shrink-0"><i data-lucide="calendar"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">27 Nov</span></p>
                                        <p class="text-slate-500 dark:text-zink-200 grow"><i data-lucide="clock-4"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">11:59 PM</span></p>
                                        <span
                                            class="px-2.5 py-0.5 text-xs inline-block text-center font-medium shrink-0 rounded border bg-white border-sky-400 text-sky-500 dark:bg-zink-700 dark:border-sky-700">Scheduled</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded-md border-slate-200 dark:border-zink-500">
                                <div class="flex flex-wrap items-center gap-3 p-2">
                                    <div class="rounded-full size-10 shrink-0">
                                        <img src="./assets/images/avatar-5.png" alt="" class="h-10 rounded-full">
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-1"><a href="#!">Gladys Smith</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">gap-4@tailwick.com</p>
                                    </div>
                                    <div class="relative dropdown shrink-0">
                                        <button type="button"
                                            class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                            id="interviewDropdown4" data-bs-toggle="dropdown">
                                            <i data-lucide="more-vertical" class="inline-block size-4"></i>
                                        </button>

                                        <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                            aria-labelledby="interviewDropdown4">
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Overview</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Edit</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                    href="#!">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-2 border-t border-slate-200 dark:border-zink-500">
                                    <div class="flex flex-col gap-3 md:items-center md:flex-row">
                                        <p class="text-slate-500 dark:text-zink-200 shrink-0"><i data-lucide="calendar"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">07 Dec</span></p>
                                        <p class="text-slate-500 dark:text-zink-200 grow"><i data-lucide="clock-4"
                                                class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i> <span
                                                class="align-middle">05:19 PM</span></p>
                                        <span
                                            class="px-2.5 py-0.5 text-xs inline-block text-center font-medium shrink-0 rounded border bg-white border-red-400 text-red-500 dark:bg-zink-700 dark:border-red-700">Cancelled</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-12 lg:col-span-12 xl:col-span-8 2xl:col-span-3">
                <div class="grid grid-cols-12 gap-x-5">
                    <div
                        class="relative col-span-12 card bg-gradient-to-r to-custom-100 dark:to-custom-500/20 from-transparent">
                        <div class="bg-[url('../images/hr-dashboard.png')] absolute inset-0 bg-cover opacity-30"></div>
                        <div class="relative card-body">
                            <div class="flex gap-3 mb-4">
                                <div class="bg-purple-100 rounded-full size-10 dark:bg-purple-500/20 shrink-0">
                                    <img src="./assets/images/avatar-6.png" alt="" class="h-10 rounded-full">
                                </div>
                                <div class="grow">
                                    <h6 class="mb-1">Nakisha Short</h6>
                                    <p class="text-slate-500 dark:text-zink-200">Her Birthday Today</p>
                                </div>
                            </div>
                            <button type="button"
                                class="px-2 py-1.5 text-xs text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Wish
                                Her</button>
                        </div>
                        <img src="./assets/images/birthday.png" alt="" class="absolute bottom-0 right-0">
                    </div>
                    <div class="col-span-12 card">
                        <div class="!pb-0 card-body">
                            <div class="flex items-center gap-2 mb-3">
                                <h6 class="text-15 grow">Recent Payroll</h6>
                                <div class="relative dropdown shrink-0">
                                    <button type="button"
                                        class="flex items-center justify-center w-[30px] h-[30px] p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10 dropdown-toggle"
                                        id="userDeviceDropdown" data-bs-toggle="dropdown">
                                        <i data-lucide="more-vertical" class="inline-block size-4"></i>
                                    </button>

                                    <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                        aria-labelledby="userDeviceDropdown">
                                        <li>
                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                href="#!">Today</a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                href="#!">Yesterday</a>
                                        </li>
                                        <li>
                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                href="#!">Thursday</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <div data-simplebar class="flex flex-col h-[198px] gap-4 px-5">
                                <div class="flex flex-col gap-3">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-red-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-up-right" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Christopher Horn</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$145.32</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Paid</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Richard Peters</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$4512.99</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-yellow-100 border-transparent text-yellow-500 dark:bg-yellow-500/20 dark:border-transparent">Pending</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">James Perez</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$879.99</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Paid</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-red-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-up-right" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Myrtle Velez</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$978.14</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent">Cancelled</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Brad Castillo</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$412.59</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-yellow-100 border-transparent text-yellow-500 dark:bg-yellow-500/20 dark:border-transparent">Pending</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Robert Jump</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$666.99</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Paid</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-red-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-up-right" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Myrtle Velez</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$978.14</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent">Cancelled</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-red-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-up-right" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Christopher Horn</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$145.32</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Paid</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">Richard Peters</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$4512.99</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-yellow-100 border-transparent text-yellow-500 dark:bg-yellow-500/20 dark:border-transparent">Pending</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div
                                            class="flex items-center justify-center text-green-500 rounded-full size-6 shrink-0">
                                            <i data-lucide="move-down-left" class="size-4"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-0">James Perez</h6>
                                        </div>
                                        <div class="shrink-0">
                                            <h6>$879.99</h6>
                                        </div>
                                        <div class="w-20 ltr:text-right rtl:text-left shrink-0">
                                            <span
                                                class="px-2.5 py-0.5 inline-block text-[11px] font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Paid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
@endpush

@section('script')
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialiser DataTable avec les options de pagination
            const dataTable = $('#recentApplicantTable').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                info: true,
                language: {
                    search: "Rechercher : ",
                    paginate: {
                        next: "Suivant",
                        previous: "Précédent"
                    },
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    lengthMenu: "Afficher _MENU_ entrées",
                    loadingRecords: "Chargement...",
                    infoEmpty: 'Aucun candidat jusque-là ! ',
                    zeroRecords: 'Aucun candidat trouvé, désolé !',
                },
                layout: {
                    topStart: {
                        buttons: ['copy', 'excel', 'pdf', 'print']
                    },
                },
            });
        })
    </script>
@endsection