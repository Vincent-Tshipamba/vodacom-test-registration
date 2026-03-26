<?php

namespace App\Http\Controllers;

use App\Models\EvaluationScore;
use App\Models\InterviewEvaluator;
use App\Models\InterviewPhaseCriteria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewEvaluatorController extends Controller
{
    public function authenticateEvaluator(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($this->resolveAuthenticatedAgentId($request)) {
                return redirect()->route('evaluator.panel', ['locale' => app()->getLocale()]);
            }

            return view('interview-evaluators.authenticate');
        }

        $data = $request->validate([
            'email' => ['required', 'email'],
            'coupon' => ['required', 'string', 'max:20'],
        ]);

        $assignment = InterviewEvaluator::query()
            ->with(['evaluator.user', 'interviewSession.interviewPhase'])
            ->where('coupon', strtoupper(trim($data['coupon'])))
            ->whereHas('evaluator.user', function ($query) use ($data) {
                $query->whereRaw('LOWER(email) = ?', [mb_strtolower($data['email'])]);
            })
            ->first();

        if (!$assignment) {
            return back()->withInput($request->only('email'))->with('error', 'Identifiants invalides.');
        }

        if (($assignment->interviewSession?->interviewPhase?->status ?? null) !== 'IN_PROGRESS') {
            return back()->withInput($request->only('email'))->with('error', 'La phase interview n est pas accessible actuellement.');
        }

        $request->session()->put('authenticated_interview_evaluator_agent_id', $assignment->evaluator_id);
        $request->session()->put('authenticated_interview_evaluator_entry_id', $assignment->id);

        return redirect()->route('evaluator.panel', ['locale' => app()->getLocale()]);
    }

    public function panel(Request $request)
    {
        $agentId = $this->resolveAuthenticatedAgentId($request);
        if (!$agentId) {
            return redirect()->route('evaluator.authenticate', ['locale' => app()->getLocale()])
                ->with('error', 'Veuillez vous connecter pour acceder a cette page.');
        }

        $assignments = InterviewEvaluator::query()
            ->with([
                'evaluator.user',
                'interviewSession.applicant',
                'interviewSession.interviewPhase',
                'scores.criteria',
            ])
            ->where('evaluator_id', $agentId)
            ->whereHas('interviewSession.interviewPhase', fn ($query) => $query->where('status', 'IN_PROGRESS'))
            ->orderByDesc('id')
            ->get()
            ->unique(fn ($assignment) => ($assignment->interviewSession?->interview_phase_id ?? 'x') . '-' . ($assignment->interviewSession?->applicant_id ?? $assignment->id))
            ->values();

        if ($assignments->isEmpty()) {
            $this->forgetEvaluatorSession($request);
            return redirect()->route('evaluator.authenticate', ['locale' => app()->getLocale()])
                ->with('error', 'Aucune affectation active n a ete trouvee pour cet evaluateur.');
        }

        return view('interview-evaluators.panel', [
            'assignments' => $assignments,
            'evaluatorName' => $assignments->first()->evaluator?->user?->full_name ?? 'Evaluateur',
        ]);
    }

    public function evaluate(String $locale, Request $request, InterviewEvaluator $interviewEvaluator)
    {
        $assignment = $this->resolveAccessibleAssignment($request, $interviewEvaluator);
        if (!$assignment) {
            return redirect()->route('evaluator.authenticate', ['locale' => app()->getLocale()])
                ->with('error', 'Session evaluateur invalide.');
        }

        if ($assignment->scores()->exists()) {
            return redirect()->route('evaluator.panel', ['locale' => app()->getLocale()])
                ->with('success', 'Cette evaluation a deja ete soumise.');
        }

        return view('interview-evaluators.evaluate', [
            'assignment' => $assignment,
        ]);
    }

    public function submitEvaluation(Request $request, InterviewEvaluator $interviewEvaluator): RedirectResponse
    {
        $assignment = $this->resolveAccessibleAssignment($request, $interviewEvaluator);
        if (!$assignment) {
            return redirect()->route('evaluator.authenticate', ['locale' => app()->getLocale()])
                ->with('error', 'Session evaluateur invalide.');
        }

        $criteria = InterviewPhaseCriteria::query()
            ->where('interview_phase_id', $assignment->interviewSession->interview_phase_id)
            ->get()
            ->keyBy('criteria_id');

        $rules = [];
        foreach ($criteria as $criteriaId => $phaseCriteria) {
            $rules["scores.$criteriaId"] = ['required', 'integer', 'min:0', 'max:' . (int) $phaseCriteria->ponderation];
            $rules["comments.$criteriaId"] = ['nullable', 'string'];
        }

        $data = $request->validate($rules);

        DB::transaction(function () use ($assignment, $criteria, $data): void {
            foreach ($criteria as $criteriaId => $phaseCriteria) {
                EvaluationScore::updateOrCreate(
                    [
                        'interview_evaluator_id' => $assignment->id,
                        'criteria_id' => $criteriaId,
                    ],
                    [
                        'score_given' => (int) data_get($data, "scores.$criteriaId"),
                        'comment' => data_get($data, "comments.$criteriaId") ?: null,
                    ]
                );
            }

            $this->refreshSessionAverage($assignment->interviewSession->id);
        });

        return redirect()->route('evaluator.panel', ['locale' => app()->getLocale()])
            ->with('success', 'Evaluation enregistree.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->forgetEvaluatorSession($request);

        return redirect()->route('evaluator.authenticate', ['locale' => app()->getLocale()])
            ->with('success', 'Deconnexion effectuee.');
    }

    public function index()
    {
        $items = InterviewEvaluator::with(['interviewSession', 'evaluator'])->paginate(20);
        return view('interview-evaluators.index', compact('items'));
    }

    public function create()
    {
        return view('interview-evaluators.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'interview_session_id' => ['required', 'exists:interview_sessions,id'],
            'evaluator_id' => ['required', 'exists:agents,id'],
        ]);
        $row = InterviewEvaluator::create($data);
        return redirect()->route('interview-evaluators.show', $row)->with('success', 'Created successfully');
    }

    public function show(InterviewEvaluator $interviewEvaluator)
    {
        $interviewEvaluator->load(['interviewSession', 'evaluator', 'scores']);
        return view('interview-evaluators.show', compact('interviewEvaluator'));
    }

    public function edit(InterviewEvaluator $interviewEvaluator)
    {
        return view('interview-evaluators.edit', compact('interviewEvaluator'));
    }

    public function update(Request $request, InterviewEvaluator $interviewEvaluator)
    {
        $data = $request->validate([
            'evaluator_id' => ['sometimes', 'exists:agents,id'],
        ]);
        $interviewEvaluator->update($data);
        return redirect()->route('interview-evaluators.show', $interviewEvaluator)->with('success', 'Updated successfully');
    }

    public function destroy(InterviewEvaluator $interviewEvaluator)
    {
        $interviewEvaluator->delete();
        return redirect()->route('interview-evaluators.index')->with('success', 'Deleted successfully');
    }

    protected function refreshSessionAverage(int $interviewSessionId): void
    {
        $assignments = InterviewEvaluator::query()
            ->with('scores')
            ->where('interview_session_id', $interviewSessionId)
            ->get();

        $totals = $assignments->map(function (InterviewEvaluator $assignment) {
            if ($assignment->scores->isEmpty()) {
                return null;
            }

            return (float) $assignment->scores->sum('score_given');
        })->filter(fn ($value) => $value !== null)->values();

        $finalAverage = $totals->isNotEmpty()
            ? round((float) $totals->avg(), 2)
            : null;

        $assignment = $assignments->first();
        $session = $assignment?->interviewSession;
        if ($session) {
            $session->update([
                'final_average_score' => $finalAverage,
            ]);
        }
    }

    protected function resolveAuthenticatedAgentId(Request $request): ?int
    {
        $agentId = $request->session()->get('authenticated_interview_evaluator_agent_id');
        return $agentId ? (int) $agentId : null;
    }

    protected function resolveAccessibleAssignment(Request $request, InterviewEvaluator $interviewEvaluator): ?InterviewEvaluator
    {
        $agentId = $this->resolveAuthenticatedAgentId($request);
        if (!$agentId || $interviewEvaluator->evaluator_id !== $agentId) {
            return null;
        }

        $interviewEvaluator->load([
            'evaluator.user',
            'interviewSession.applicant',
            'interviewSession.interviewPhase',
            'scores.criteria',
        ]);

        if (($interviewEvaluator->interviewSession?->interviewPhase?->status ?? null) !== 'IN_PROGRESS') {
            return null;
        }

        $canonicalAssignmentId = InterviewEvaluator::query()
            ->where('evaluator_id', $agentId)
            ->whereHas('interviewSession', function ($query) use ($interviewEvaluator) {
                $query->where('interview_phase_id', $interviewEvaluator->interviewSession->interview_phase_id)
                    ->where('applicant_id', $interviewEvaluator->interviewSession->applicant_id);
            })
            ->orderBy('id')
            ->value('id');

        if ($canonicalAssignmentId && (int) $canonicalAssignmentId !== (int) $interviewEvaluator->id) {
            return null;
        }

        return $interviewEvaluator;
    }

    protected function forgetEvaluatorSession(Request $request): void
    {
        $request->session()->forget([
            'authenticated_interview_evaluator_agent_id',
            'authenticated_interview_evaluator_entry_id',
        ]);
    }
}
