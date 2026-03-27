<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Applicant;
use App\Models\EvaluationCriteria;
use App\Models\InterviewPhase;
use App\Models\InterviewPhaseCriteria;
use App\Models\InterviewEvaluator;
use App\Models\InterviewSession;
use App\Models\ScholarshipEdition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InterviewSessionController extends Controller
{
    public function index()
    {
        $currentEdition = ScholarshipEdition::getCurrentEdition();
        abort_unless($currentEdition, 404);
        return view('admin.interview-sessions.index', compact('currentEdition'));
    }

    public function updatePhase(string $locale, Request $request, InterviewPhase $interviewPhase)
    {
        $data = $request->validate([
            'description' => ['nullable', 'string'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:AWAITING,IN_PROGRESS,CANCELLED,COMPLETED'],
        ]);

        if (($data['status'] ?? null) === 'IN_PROGRESS') {
            $criteriaTotal = (int) InterviewPhaseCriteria::query()
                ->where('interview_phase_id', $interviewPhase->id)
                ->sum('ponderation');
            $jurorsCount = InterviewEvaluator::query()
                ->whereHas('interviewSession', fn ($query) => $query->where('interview_phase_id', $interviewPhase->id))
                ->count();

            if ($criteriaTotal !== 100) {
                throw ValidationException::withMessages([
                    'status' => __('La somme des pondérations des critères doit être exactement 100 avant de lancer la phase.'),
                ]);
            }

            if ($jurorsCount < 1) {
                throw ValidationException::withMessages([
                    'status' => __('Ajoute au moins un membre du jury avant de lancer la phase.'),
                ]);
            }
        }

        $interviewPhase->update($data);

        return back()->with('success', __('messages.updated'));
    }

    public function scheduleCandidate(string $locale, Request $request, Applicant $applicant)
    {
        $interviewPhase = InterviewPhase::query()
            ->where('scholarship_edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->firstOrFail();

        $data = $request->validate([
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $session = InterviewSession::query()->firstOrNew([
            'applicant_id' => $applicant->id,
            'interview_phase_id' => $interviewPhase->id,
        ]);
        $session->scheduled_at = $data['scheduled_at'] ?? null;
        $session->save();

        return back()->with('success', __('messages.updated'));
    }

    public function storeCriteria(string $locale, Request $request)
    {
        $interviewPhase = InterviewPhase::query()
            ->where('scholarship_edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->firstOrFail();

        $data = $request->validate([
            'criteria_name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'ponderation' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $currentTotal = (int) InterviewPhaseCriteria::query()
            ->where('interview_phase_id', $interviewPhase->id)
            ->sum('ponderation');

        if ($currentTotal + (int) $data['ponderation'] > 100) {
            throw ValidationException::withMessages([
                'ponderation' => __('La somme des pondérations ne peut pas dépasser 100.'),
            ]);
        }

        DB::transaction(function () use ($interviewPhase, $data) {
            $criteria = EvaluationCriteria::create([
                'criteria_name' => $data['criteria_name'],
                'description' => $data['description'] ?? null,
            ]);

            InterviewPhaseCriteria::create([
                'interview_phase_id' => $interviewPhase->id,
                'criteria_id' => $criteria->id,
                'ponderation' => $data['ponderation'],
            ]);
        });

        return back()->with('success', __('messages.saved'));
    }

    public function updateCriteria(string $locale, Request $request, InterviewPhaseCriteria $interviewPhaseCriteria)
    {
        $data = $request->validate([
            'criteria_name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'ponderation' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $currentTotal = (int) InterviewPhaseCriteria::query()
            ->where('interview_phase_id', $interviewPhaseCriteria->interview_phase_id)
            ->where('id', '!=', $interviewPhaseCriteria->id)
            ->sum('ponderation');

        if ($currentTotal + (int) $data['ponderation'] > 100) {
            throw ValidationException::withMessages([
                'ponderation' => __('La somme des pondérations ne peut pas dépasser 100.'),
            ]);
        }

        DB::transaction(function () use ($interviewPhaseCriteria, $data) {
            $interviewPhaseCriteria->evaluationCriteria?->update([
                'criteria_name' => $data['criteria_name'],
                'description' => $data['description'] ?? null,
            ]);

            $interviewPhaseCriteria->update([
                'ponderation' => $data['ponderation'],
            ]);
        });

        return back()->with('success', __('messages.updated'));
    }

    public function destroyCriteria(string $locale, InterviewPhaseCriteria $interviewPhaseCriteria)
    {
        DB::transaction(function () use ($interviewPhaseCriteria) {
            $criteria = $interviewPhaseCriteria->evaluationCriteria;
            $interviewPhaseCriteria->delete();
            if ($criteria) {
                $criteria->delete();
            }
        });

        return back()->with('success', __('messages.deleted'));
    }

    public function addJuror(string $locale, Request $request)
    {
        $data = $request->validate([
            'agent_id' => ['required', 'exists:agents,id'],
            'interview_session_id' => ['required', 'exists:interview_sessions,id'],
        ]);

        $this->ensureSessionBelongsToCurrentInterviewPhase((int) $data['interview_session_id']);

        InterviewEvaluator::firstOrCreate(
            [
                'interview_session_id' => $data['interview_session_id'],
                'evaluator_id' => $data['agent_id'],
            ],
            [
                'coupon' => strtoupper(Str::random(10)),
                'qr_token' => (string) Str::uuid(),
            ]
        );

        return back()->with('success', __('messages.saved'));
    }

    public function createJuror(string $locale, Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'interview_session_id' => ['required', 'exists:interview_sessions,id'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'max:20'],
            'job_title' => ['nullable', 'string', 'max:120'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        $this->ensureSessionBelongsToCurrentInterviewPhase((int) $data['interview_session_id']);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'name' => trim($data['first_name'] . ' ' . $data['last_name']),
                'email' => $data['email'],
                'phone_number' => $data['phone_number'] ?? null,
                'gender' => $data['gender'] ?? null,
                'password' => Str::password(12),
                'is_active' => true,
            ]);

            $agent = Agent::create([
                'user_id' => $user->id,
                'department_id' => $data['department_id'],
                'job_title' => $data['job_title'] ?? 'Jury',
            ]);

            InterviewEvaluator::create([
                'interview_session_id' => $data['interview_session_id'],
                'evaluator_id' => $agent->id,
                'coupon' => strtoupper(Str::random(10)),
                'qr_token' => (string) Str::uuid(),
            ]);
        });

        return back()->with('success', __('messages.saved'));
    }

    public function removeJuror(string $locale, InterviewEvaluator $juror)
    {
        $juror->delete();

        return back()->with('success', __('messages.deleted'));
    }

    protected function ensureSessionBelongsToCurrentInterviewPhase(int $sessionId): void
    {
        $phaseId = InterviewPhase::query()
            ->where('scholarship_edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->value('id');

        $exists = InterviewSession::query()
            ->where('id', $sessionId)
            ->where('interview_phase_id', $phaseId)
            ->exists();

        if (!$exists) {
            throw ValidationException::withMessages([
                'interview_session_id' => __('La session sélectionnée n appartient pas à la phase courante.'),
            ]);
        }
    }
}
