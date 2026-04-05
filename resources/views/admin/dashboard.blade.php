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
    @php
        $statusLabels = [
            'PENDING' => 'En attente',
            'REJECTED' => 'Candidature rejetée',
            'SHORTLISTED' => 'Présélectionné pour le test',
            'TEST_PASSED' => 'A réussi le test de sélection',
            'INTERVIEW_PASSED' => 'A réussi l\'entretien',
            'ADMITTED' => 'Retenu comme boursier',
        ];
        $statusClasses = [
            'PENDING' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-300',
            'REJECTED' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300',
            'SHORTLISTED' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300',
            'TEST_PASSED' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
            'INTERVIEW_PASSED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
            'ADMITTED' => 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300',
        ];
        $calendarKindLabels = [
            'test' => 'Test',
            'interview' => 'Interviews',
            'interview-session' => 'Interview',
        ];
        $calendarKindClasses = [
            'test' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
            'interview' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
            'interview-session' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
        ];
    @endphp
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
                    </div><!--end grid-->
                    <div class="-mx-5 overflow-x-auto">
                        @if ($current_edition && $current_edition->status == 'SELECTION_PHASE')
                            <table class="w-full whitespace-nowrap" id="recentApplicantTable">
                                <thead
                                    class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                    <tr>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
                                            #</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
                                            Noms</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
                                            Téléphone</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
                                            Pourcentage</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
                                            Ville</th>
                                        <th
                                            class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold text-gray-900 dark:text-white border-y border-slate-200 dark:border-zink-500">
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
                                                        <img src="{{ $applicant->documents->photo['url'] }}" loading="lazy" alt="" class="h-10 rounded-full mx-auto">
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
                                                {{ number_format($applicant->percentage - 0.00) }}%
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 text-green-500">
                                                {{ $applicant->current_city->name }}
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                <span
                                                    class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border {{ $statusClasses[$applicant->application_status] }} dark:bg-green-500/20 dark:border-green-500/20">
                                                    {{ $statusLabels[$applicant->application_status] }}
                                                </span>
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
                        @forelse ($upcomingSchedule as $event)
                            <a href="{{ $event['link'] }}"
                                class="flex gap-3 transition-all duration-200 rounded-md hover:bg-slate-50 dark:hover:bg-zink-700/40 p-2 -mx-2">
                                <div
                                    class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                    <h6>{{ $event['starts_at']->format('d') }}</h6>
                                    <span class="text-sm text-slate-500 dark:text-zink-200">
                                        {{ $event['starts_at']->translatedFormat('M') }}
                                    </span>
                                </div>
                                <div class="grow min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h6 class="mb-1 truncate">{{ $event['title'] }}</h6>
                                        <small
                                            class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">
                                            {{ $event['time_label'] }}
                                        </small>
                                        <span
                                            class="px-2.5 py-0.5 text-[11px] inline-block font-medium rounded {{ $event['badge_class'] }}">
                                            {{ $event['badge'] }}
                                        </span>
                                    </div>
                                    <p class="text-slate-500 dark:text-zink-200 truncate">{{ $event['subtitle'] }}</p>
                                </div>
                            </a>
                        @empty
                            <div
                                class="rounded-md border border-dashed border-slate-200 dark:border-zink-500 px-4 py-5 text-sm text-slate-500 dark:text-zink-200">
                                Aucun événement à venir pour le moment.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:order-10 lg:col-span-6 xl:col-span-4 2xl:col-span-3 card">
                <div class="card-body">
                    <div class="flex items-center gap-2 mb-3">
                        <h6 class="text-15 grow">Stats des 6 dernières éditions</h6>
                    </div>
                    <div id="totalProjectChart" class="-ml-2 apex-charts"
                        data-chart-colors='["bg-orange-500", "bg-red-500", "bg-yellow-500", "bg-blue-500", "bg-emerald-500", "bg-green-600"]'
                        data-labels='@json($editionStatusChartLabels)'
                        data-series='@json($editionStatusChartSeries)' dir="ltr">
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
                            @forelse ($upcomingInterviews as $interview)
                                @php
                                    $initials = collect(explode(' ', $interview['title']))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                                        ->implode('');
                                @endphp
                                <a href="{{ $interview['link'] }}"
                                    class="border rounded-md border-slate-200 dark:border-zink-500 transition-all duration-200 hover:border-emerald-300 dark:hover:border-emerald-500/40">
                                    <div class="flex flex-wrap items-center gap-3 p-3">
                                        <div
                                            class="rounded-full size-10 shrink-0 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 flex items-center justify-center font-semibold">
                                            {{ $initials ?: 'C' }}
                                        </div>
                                        <div class="grow min-w-0">
                                            <h6 class="mb-1 truncate">{{ $interview['title'] }}</h6>
                                            <p class="text-slate-500 dark:text-zink-200 truncate">
                                                {{ $interview['email'] ?: ($interview['applicant_code'] ?: 'Candidat planifié') }}
                                            </p>
                                        </div>
                                        <span
                                            class="px-2.5 py-0.5 text-xs inline-block text-center font-medium rounded {{ $interview['badge_class'] }}">
                                            {{ $interview['badge'] }}
                                        </span>
                                    </div>
                                    <div class="p-3 border-t border-slate-200 dark:border-zink-500">
                                        <div class="flex flex-col gap-3 md:items-center md:flex-row">
                                            <p class="text-slate-500 dark:text-zink-200 shrink-0">
                                                <i data-lucide="calendar" class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i>
                                                <span class="align-middle">{{ $interview['starts_at']->translatedFormat('d M Y') }}</span>
                                            </p>
                                            <p class="text-slate-500 dark:text-zink-200 grow">
                                                <i data-lucide="clock-4" class="inline-block size-4 ltr:mr-1 rtl::ml-1"></i>
                                                <span class="align-middle">{{ $interview['time_label'] }}</span>
                                            </p>
                                            @if (!empty($interview['applicant_code']))
                                                <span
                                                    class="px-2.5 py-0.5 text-xs inline-block text-center font-medium rounded border border-slate-200 text-slate-600 dark:border-zink-500 dark:text-zink-100">
                                                    {{ $interview['applicant_code'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div
                                    class="rounded-md border border-dashed border-slate-200 dark:border-zink-500 px-4 py-5 text-sm text-slate-500 dark:text-zink-200">
                                    Aucun entretien planifié pour le moment.
                                </div>
                            @endforelse
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
            const recentApplicantTable = document.getElementById('recentApplicantTable');
            if (recentApplicantTable && window.jQuery && $.fn.DataTable) {
                $('#recentApplicantTable').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: false,
                    info: true,
                    language: {
                        search: "Rechercher : ",
                        paginate: {
                            next: "Suivant",
                            previous: "Precedent"
                        },
                        info: "Affichage de _START_ a _END_ sur _TOTAL_ entrees",
                        lengthMenu: "Afficher _MENU_ entrees",
                        loadingRecords: "Chargement...",
                        infoEmpty: 'Aucun candidat jusque-la !',
                        zeroRecords: 'Aucun candidat trouve, desole !',
                    },
                    layout: {
                        topStart: {
                            buttons: ['copy', 'excel', 'pdf', 'print']
                        },
                    },
                });
            }

            const calendarElement = document.querySelector('#calendar');
            const calendarEvents = @json($calendarEventMap);
            const kindLabels = {
                test: 'Test',
                interview: 'Interviews',
                'interview-session': 'Interview'
            };
            const kindClasses = {
                test: 'bg-blue-100 text-blue-700',
                interview: 'bg-emerald-100 text-emerald-700',
                'interview-session': 'bg-emerald-100 text-emerald-700'
            };

            const escapeHtml = (value) => String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

            if (calendarElement && typeof VanillaCalendar !== 'undefined') {
                const popupDates = Object.entries(calendarEvents).reduce((carry, [date, event]) => {
                    const html = (event.items || []).map((item) => `
                        <div class="space-y-1">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-medium text-slate-700">${escapeHtml(item.title)}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold ${kindClasses[item.kind] || 'bg-slate-100 text-slate-600'}">
                                    ${escapeHtml(kindLabels[item.kind] || 'Evenement')}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500">${escapeHtml(item.time || '')}</p>
                        </div>
                    `).join('<div class="my-2 h-px bg-slate-200"></div>');

                    carry[date] = {
                        modifier: event.modifier || '!bg-custom-500 !text-white',
                        html,
                    };

                    return carry;
                }, {});

                const calendar = new VanillaCalendar('#calendar', {
                    settings: {
                        lang: 'fr',
                    },
                    popups: {
                        dates: popupDates,
                    },
                });

                calendar.init();
            }
        })
    </script>
@endsection

