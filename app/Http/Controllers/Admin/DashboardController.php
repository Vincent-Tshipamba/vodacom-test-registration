<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\InterviewPhase;
use App\Models\PhaseTest;
use App\Models\Scholar;
use App\Models\ScholarshipEdition;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $applicants = Applicant::with(['application_documents', 'current_city'])
            ->where('edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->latest()
            ->limit(10)
            ->get();
        $current_edition = ScholarshipEdition::getCurrentEdition();
        $count_applicants_this_year = $current_edition
            ? Applicant::where('edition_id', $current_edition->id)->count()
            : 0;
        $count_accepted_applicants = $current_edition
            ? Applicant::where('application_status', 'ADMITTED')->where('edition_id', $current_edition->id)->count()
            : 0;
        $count_rejected_applicants = $current_edition
            ? Applicant::where('application_status', 'REJECTED')->where('edition_id', $current_edition->id)->count()
            : 0;
        $count_boursiers = Scholar::count();
        $count_editions = ScholarshipEdition::count();

        $currentYear = now()->year;
        $years = range(2018, $currentYear);

        $applicantsByYear = array_fill_keys($years, 0);

        // $payments = Payment::with('academic_year_records', 'scholars')->get();

        $editions = ScholarshipEdition::withCount('applicants')
            ->whereIn('year', $years)
            ->get()
            ->groupBy(function ($edition) {
                return Carbon::parse($edition->application_start_date)->year;
            });

        foreach ($editions as $year => $editionsForYear) {
            if (isset($applicantsByYear[$year])) {
                $applicantsByYear[$year] = $editionsForYear->sum('applicants_count');
            }
        }

        $editionStatusStats = ScholarshipEdition::query()
            ->withCount([
                'applicants as pending_count' => fn ($query) => $query->where('application_status', 'PENDING'),
                'applicants as rejected_count' => fn ($query) => $query->where('application_status', 'REJECTED'),
                'applicants as shortlisted_count' => fn ($query) => $query->where('application_status', 'SHORTLISTED'),
                'applicants as test_passed_count' => fn ($query) => $query->where('application_status', 'TEST_PASSED'),
                'applicants as interview_passed_count' => fn ($query) => $query->where('application_status', 'INTERVIEW_PASSED'),
                'applicants as admitted_count' => fn ($query) => $query->where('application_status', 'ADMITTED'),
            ])
            ->orderByDesc('year')
            ->limit(6)
            ->get();

        $editionStatusStats = $editionStatusStats
            ->sortBy('year')
            ->values();

        $editionStatusChartLabels = $editionStatusStats
            ->map(fn ($edition) => $edition->name ?: (string) $edition->year)
            ->values();

        $editionStatusChartSeries = [
            [
                'name' => 'En attente',
                'data' => $editionStatusStats->pluck('pending_count')->map(fn ($value) => (int) $value)->values(),
            ],
            [
                'name' => 'Rejetés',
                'data' => $editionStatusStats->pluck('rejected_count')->map(fn ($value) => (int) $value)->values(),
            ],
            [
                'name' => 'En ordre',
                'data' => $editionStatusStats->pluck('shortlisted_count')->map(fn ($value) => (int) $value)->values(),
            ],
            [
                'name' => 'Test passé',
                'data' => $editionStatusStats->pluck('test_passed_count')->map(fn ($value) => (int) $value)->values(),
            ],
            [
                'name' => 'Entretien passé',
                'data' => $editionStatusStats->pluck('interview_passed_count')->map(fn ($value) => (int) $value)->values(),
            ],
            [
                'name' => 'Admis',
                'data' => $editionStatusStats->pluck('admitted_count')->map(fn ($value) => (int) $value)->values(),
            ],
        ];

        [
            'calendarEventMap' => $calendarEventMap,
            'upcomingSchedule' => $upcomingSchedule,
            'upcomingInterviews' => $upcomingInterviews,
        ] = $this->buildUpcomingEvents($current_edition);

        return response()->view('admin.dashboard', compact(
            'applicants',
            'current_edition',
            'count_applicants_this_year',
            'count_accepted_applicants',
            'count_rejected_applicants',
            'count_boursiers',
            'count_editions',
            'applicantsByYear',
            'years',
            'editionStatusChartLabels',
            'editionStatusChartSeries',
            'calendarEventMap',
            'upcomingSchedule',
            'upcomingInterviews'
        ));
    }

    private function buildUpcomingEvents(?ScholarshipEdition $edition): array
    {
        $calendarEvents = [];
        $upcomingSchedule = collect();
        $upcomingInterviews = collect();

        if (! $edition) {
            return [
                'calendarEventMap' => [],
                'upcomingSchedule' => $upcomingSchedule,
                'upcomingInterviews' => $upcomingInterviews,
            ];
        }

        $now = now();

        $phaseTest = PhaseTest::where('scholarship_edition_id', $edition->id)->first();
        if ($phaseTest?->start_time && $phaseTest->start_time->greaterThanOrEqualTo($now)) {
            $timeLabel = $this->formatTimeRange($phaseTest->start_time, $phaseTest->end_time);

            $upcomingSchedule->push([
                'type' => 'test',
                'title' => 'Jour de test',
                'subtitle' => $edition->name ?? 'Edition en cours',
                'starts_at' => $phaseTest->start_time->copy(),
                'time_label' => $timeLabel,
                'badge' => 'Test',
                'badge_class' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
                'link' => route('admin.tests.index'),
            ]);

            $calendarEvents[] = [
                'date' => $phaseTest->start_time->toDateString(),
                'title' => 'Jour de test',
                'time' => $timeLabel,
                'kind' => 'test',
                'modifier' => '!bg-blue-500 !text-white',
            ];
        }

        $interviewPhase = InterviewPhase::with([
            'interviewSessions' => function ($query) use ($now) {
                $query->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '>=', $now)
                    ->orderBy('scheduled_at');
                    // ->with('applicant.user');
            },
        ])->where('scholarship_edition_id', $edition->id)->first();

        if ($interviewPhase?->start_date) {
            $phaseStart = $interviewPhase->start_date->copy()->startOfDay()->setTime(8, 0);
            if ($phaseStart->greaterThanOrEqualTo($now)) {
                $upcomingSchedule->push([
                    'type' => 'interview-phase',
                    'title' => 'Début des interviews',
                    'subtitle' => $edition->name ?? 'Edition en cours',
                    'starts_at' => $phaseStart,
                    'time_label' => '08:00',
                    'badge' => 'Interviews',
                    'badge_class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
                    'link' => route('admin.interview-sessions.index', app()->getLocale()),
                ]);

                $calendarEvents[] = [
                    'date' => $interviewPhase->start_date->toDateString(),
                    'title' => 'Début des interviews',
                    'time' => '08:00',
                    'kind' => 'interview',
                    'modifier' => '!bg-emerald-500 !text-white',
                ];
            }
        }

        foreach ($interviewPhase?->interviewSessions ?? collect() as $session) {
            if (! $session->scheduled_at) {
                continue;
            }

            $candidateName = trim(($session->applicant->first_name ?? '') . ' ' . ($session->applicant->last_name ?? ''));
            $candidateName = $candidateName !== '' ? $candidateName : 'Candidat';

            $scheduleItem = [
                'type' => 'interview-session',
                'title' => $candidateName,
                'subtitle' => 'Interview candidat',
                'starts_at' => $session->scheduled_at->copy(),
                'time_label' => $session->scheduled_at->format('H:i'),
                'badge' => 'Interview',
                'badge_class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
                'link' => route('admin.interview-sessions.index', app()->getLocale()),
                'applicant_code' => $session->applicant->reference_code ?? null,
                'email' => $session->applicant->user->email ?? null,
            ];

            $upcomingSchedule->push($scheduleItem);
            $upcomingInterviews->push($scheduleItem);

            $calendarEvents[] = [
                'date' => $session->scheduled_at->toDateString(),
                'title' => $candidateName,
                'time' => $session->scheduled_at->format('H:i'),
                'kind' => 'interview-session',
                'modifier' => '!bg-emerald-500 !text-white',
            ];
        }

        return [
            'calendarEventMap' => $this->buildCalendarEventMap($calendarEvents),
            'upcomingSchedule' => $upcomingSchedule
                ->sortBy('starts_at')
                ->take(8)
                ->values(),
            'upcomingInterviews' => $upcomingInterviews
                ->sortBy('starts_at')
                ->take(6)
                ->values(),
        ];
    }

    private function buildCalendarEventMap(array $events): array
    {
        return collect($events)
            ->groupBy('date')
            ->map(function (Collection $items) {
                return [
                    'modifier' => $items->first()['modifier'] ?? '!bg-custom-500 !text-white',
                    'items' => $items->map(fn (array $item) => [
                        'title' => $item['title'],
                        'time' => $item['time'],
                        'kind' => $item['kind'],
                    ])->values()->all(),
                ];
            })
            ->all();
    }

    private function formatTimeRange(Carbon $start, ?Carbon $end): string
    {
        if (! $end) {
            return $start->format('H:i');
        }

        return $start->format('H:i') . ' - ' . $end->format('H:i');
    }
}
