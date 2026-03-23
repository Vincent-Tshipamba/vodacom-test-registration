<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\PhaseTest;
use App\Models\QuestionPhaseTest;
use App\Models\ScholarshipEdition;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $currentEdition = ScholarshipEdition::getCurrentEdition();

        $baseQuery = Applicant::query()
            ->where('edition_id', $currentEdition->id)
            ->where('application_status', 'SHORTLISTED');

        $candidatsTotal = (clone $baseQuery)->count();
        $candidatsFemale = (clone $baseQuery)->where('gender', 'female')->count();
        $candidatsMale = (clone $baseQuery)->where('gender', 'male')->count();

        $candidats = (clone $baseQuery)
            ->with('application_documents.document_type')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $phaseTest = PhaseTest::withCount('questions')
            ->where('scholarship_edition_id', $currentEdition->id)
            ->first();

        $phaseQuestions = $phaseTest
            ? QuestionPhaseTest::query()
                ->with([
                    'question.category_question',
                    'question.answer_options',
                ])
                ->where('phase_test_id', $phaseTest->id)
                ->orderBy('id')
                ->get()
            : collect();

        $phaseQuestionsCount = (int) ($phaseTest?->questions_count ?? 0);
        $phaseTotalPoints = (float) $phaseQuestions->sum('ponderation');
        $passingScorePercent = (float) ($phaseTest?->passing_score ?? 0);

        $applicantIds = $candidats->pluck('id');

        $latestSessionsByApplicant = TestSession::query()
            ->whereIn('applicant_id', $applicantIds)
            ->orderByDesc('id')
            ->get()
            ->unique('applicant_id')
            ->keyBy('applicant_id');

        $completedSessions = TestSession::query()
            ->with([
                'applicant.application_documents.document_type',
                'responses.selected_option',
                'responses.question_phase_test.question.category_question',
                'responses.question_phase_test.question.answer_options',
            ])
            ->whereIn('applicant_id', $applicantIds)
            ->whereNotNull('finished_at')
            ->orderByDesc('finished_at')
            ->orderByDesc('id')
            ->get()
            ->unique('applicant_id')
            ->values();

        $resultRows = $completedSessions->map(function (TestSession $session) use ($phaseQuestions, $phaseQuestionsCount, $phaseTotalPoints, $passingScorePercent) {
            $responsesByQuestion = $session->responses->keyBy('question_phase_test_id');
            $percentage = $phaseTotalPoints > 0
                ? round(((float) $session->total_score / $phaseTotalPoints) * 100, 2)
                : 0.0;
            $passed = $percentage >= $passingScorePercent;
            $answeredCount = $session->responses->whereNotNull('selected_option_id')->count();
            $secondsUsed = $session->started_at && $session->finished_at
                ? max(0, $session->started_at->diffInSeconds($session->finished_at))
                : 0;

            $details = $phaseQuestions->map(function (QuestionPhaseTest $phaseQuestion) use ($responsesByQuestion) {
                $response = $responsesByQuestion->get($phaseQuestion->id);
                $selectedOptionId = $response?->selected_option_id;
                $correctOptionId = optional($phaseQuestion->question->answer_options->firstWhere('pivot.is_correct', true))->id;

                return [
                    'category' => optional($phaseQuestion->question->category_question)->name,
                    'question_text' => $phaseQuestion->question->question_text,
                    'ponderation' => (int) $phaseQuestion->ponderation,
                    'selected_option_id' => $selectedOptionId,
                    'is_correct' => $selectedOptionId && $correctOptionId ? (int) $selectedOptionId === (int) $correctOptionId : false,
                    'options' => $phaseQuestion->question->answer_options->map(function ($option) use ($selectedOptionId) {
                        return [
                            'option_text' => $option->option_text,
                            'is_selected' => (int) $option->id === (int) $selectedOptionId,
                        ];
                    })->values()->all(),
                ];
            })->values()->all();

            return [
                'session_id' => $session->id,
                'applicant_id' => $session->applicant_id,
                'candidate_name' => $session->applicant?->full_name ?? '-',
                'candidate_gender' => strtolower((string) ($session->applicant?->gender ?? '')),
                'candidate_phone' => $session->applicant?->phone_number ? '+243' . substr($session->applicant->phone_number, -9) : '-',
                'candidate_photo_url' => ($session->applicant && !empty($session->applicant->documents->photo['url']) && file_exists(public_path($session->applicant->documents->photo['url'])))
                    ? asset($session->applicant->documents->photo['url'])
                    : asset('img/profil.jpg'),
                'raw_score' => round((float) $session->total_score, 2),
                'score_percentage' => $percentage,
                'is_passed' => $passed,
                'answered_count' => $answeredCount,
                'total_questions' => $phaseQuestionsCount,
                'cheating_attempts' => (int) $session->cheating_attempts,
                'auto_submitted' => (bool) $session->auto_submitted,
                'started_at' => optional($session->started_at)?->format('d/m/Y H:i'),
                'finished_at' => optional($session->finished_at)?->format('d/m/Y H:i'),
                'time_used' => sprintf('%02d:%02d:%02d', intdiv($secondsUsed, 3600), intdiv($secondsUsed % 3600, 60), $secondsUsed % 60),
                'details' => $details,
            ];
        })->values();

        $resultDetails = $resultRows
            ->mapWithKeys(fn (array $row) => [(string) $row['session_id'] => $row['details']])
            ->all();

        $results = $resultRows
            ->map(fn (array $row) => Arr::except($row, ['details']))
            ->values();

        $startedCount = $latestSessionsByApplicant->filter(fn ($session) => !is_null($session?->started_at))->count();
        $completedCount = $results->count();
        $passedCount = $results->where('is_passed', true)->count();
        $failedCount = $results->where('is_passed', false)->count();
        $passedMaleCount = $results->filter(fn ($row) => $row['is_passed'] && $row['candidate_gender'] === 'male')->count();
        $passedFemaleCount = $results->filter(fn ($row) => $row['is_passed'] && $row['candidate_gender'] === 'female')->count();
        $averagePercentage = round((float) ($results->avg('score_percentage') ?? 0), 2);
        $autoSubmittedCount = $results->where('auto_submitted', true)->count();

        return view('admin.tests.index', compact(
            'currentEdition',
            'candidats',
            'candidatsTotal',
            'candidatsFemale',
            'candidatsMale',
            'phaseTest',
            'phaseQuestionsCount',
            'phaseTotalPoints',
            'passingScorePercent',
            'results',
            'resultDetails',
            'startedCount',
            'completedCount',
            'passedCount',
            'failedCount',
            'passedMaleCount',
            'passedFemaleCount',
            'averagePercentage',
            'autoSubmittedCount'
        ));
    }
}
