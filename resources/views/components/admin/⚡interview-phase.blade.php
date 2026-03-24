<?php

use App\Models\Agent;
use App\Models\Applicant;
use App\Models\Department;
use App\Models\EvaluationCriteria;
use App\Models\InterviewEvaluator;
use App\Models\InterviewPhase;
use App\Models\InterviewPhaseCriteria;
use App\Models\InterviewSession;
use App\Models\ScholarshipEdition;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component {
    public ScholarshipEdition $currentEdition;
    public InterviewPhase $interviewPhase;
    public string $activeTab = 'dashboard';

    public array $phaseForm = [
        'description' => '',
        'duration' => '',
        'start_date' => '',
        'end_date' => '',
        'status' => 'AWAITING',
    ];

    public array $candidateRows = [];
    public array $candidateSchedules = [];
    public array $criteriaRows = [];
    public array $criterionEdits = [];
    public array $jurorRows = [];
    public array $resultRows = [];
    public array $availableAgents = [];
    public array $departments = [];
    public array $existingJurorForm = [
        'interview_session_id' => '',
        'agent_id' => '',
    ];
    public array $newJurorForm = [
        'interview_session_id' => '',
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone_number' => '',
        'gender' => '',
        'department_id' => '',
        'job_title' => '',
    ];
    public array $criterionDraft = [
        'criteria_name' => '',
        'description' => '',
        'ponderation' => '',
    ];
    public array $stats = [];
    public int $criteriaTotal = 0;
    public ?int $expandedResultSessionId = null;

    public function mount($currentEdition): void
    {
        $this->currentEdition = $currentEdition;
        $this->interviewPhase = InterviewPhase::firstOrCreate(
            ['scholarship_edition_id' => $this->currentEdition->id],
            ['status' => 'AWAITING']
        );

        $this->loadState();
    }

    public function updated($name): void
    {
        $this->resetValidation($name);

        if (in_array($name, ['phaseForm.duration', 'phaseForm.start_date', 'phaseForm.end_date'], true)) {
            $this->loadCandidates();
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function toggleResultDetails(int $sessionId): void
    {
        $this->expandedResultSessionId = $this->expandedResultSessionId === $sessionId ? null : $sessionId;
    }

    public function savePhase(): void
    {
        $this->validate([
            'phaseForm.description' => ['nullable', 'string'],
            'phaseForm.duration' => ['required', 'integer', 'min:1', 'max:480'],
            'phaseForm.start_date' => ['required', 'date'],
            'phaseForm.end_date' => ['required', 'date', 'after_or_equal:phaseForm.start_date'],
            'phaseForm.status' => ['required', 'in:AWAITING,IN_PROGRESS,CANCELLED,COMPLETED'],
        ]);

        if ($this->phaseForm['status'] === 'IN_PROGRESS' && $this->criteriaTotal !== 100) {
            $this->addError('phaseForm.status', 'La somme des ponderations doit etre egale a 100 pour lancer la phase.');
            $this->activeTab = 'criteria';
            return;
        }

        $unscheduledCount = collect($this->candidateRows)->where('schedule_saved', false)->count();
        if ($this->phaseForm['status'] === 'IN_PROGRESS' && $unscheduledCount > 0) {
            $this->addError('phaseForm.status', 'Toutes les interviews doivent etre planifiees avant le lancement de la phase.');
            $this->activeTab = 'candidates';
            return;
        }

        $this->interviewPhase->update([
            'description' => $this->phaseForm['description'] ?: null,
            'duration' => (int) $this->phaseForm['duration'],
            'start_date' => $this->phaseForm['start_date'],
            'end_date' => $this->phaseForm['end_date'],
            'status' => $this->phaseForm['status'],
        ]);

        $this->loadState();
        session()->flash('interview_success', 'Configuration de la phase enregistree.');
    }

    public function applySuggestedSchedules(): void
    {
        if (!$this->ensureScheduleConfiguration()) {
            return;
        }

        DB::transaction(function (): void {
            foreach ($this->candidateRows as $candidate) {
                $applicantId = (int) $candidate['id'];
                $value = $this->candidateSchedules[$applicantId] ?? null;

                if (!$value) {
                    continue;
                }

                $this->persistCandidateSchedule($applicantId, $value);
            }
        });

        $this->loadState();
        $this->activeTab = 'candidates';
        session()->flash('interview_success', 'Les horaires proposés ont été appliqués.');
    }

    public function saveCandidateSchedule(int $applicantId): void
    {
        if (!$this->ensureScheduleConfiguration()) {
            return;
        }

        $value = $this->candidateSchedules[$applicantId] ?? null;
        if (!$value) {
            $this->addError("candidateSchedules.$applicantId", 'Choisissez une date et une heure.');
            return;
        }

        $this->persistCandidateSchedule($applicantId, $value);

        $this->loadState();
        $this->activeTab = 'candidates';
        session()->flash('interview_success', 'Horaire enregistré pour le candidat.');
    }

    public function addCriterion(): void
    {
        $this->validate([
            'criterionDraft.criteria_name' => ['required', 'string', 'max:255'],
            'criterionDraft.description' => ['nullable', 'string'],
            'criterionDraft.ponderation' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $criterion = EvaluationCriteria::firstOrCreate(
            ['criteria_name' => trim($this->criterionDraft['criteria_name'])],
            ['description' => $this->criterionDraft['description'] ?: null]
        );

        $exists = InterviewPhaseCriteria::query()
            ->where('interview_phase_id', $this->interviewPhase->id)
            ->where('criteria_id', $criterion->id)
            ->exists();

        if ($exists) {
            $this->addError('criterionDraft.criteria_name', 'Ce critère existe déja pour cette phase.');
            return;
        }

        InterviewPhaseCriteria::create([
            'interview_phase_id' => $this->interviewPhase->id,
            'criteria_id' => $criterion->id,
            'ponderation' => (int) $this->criterionDraft['ponderation'],
        ]);

        $this->criterionDraft = [
            'criteria_name' => '',
            'description' => '',
            'ponderation' => '',
        ];

        $this->loadCriteria();
        $this->loadStats();
        $this->activeTab = 'criteria';
        session()->flash('interview_success', 'Critère ajouté.');
    }

    public function updateCriterion(int $phaseCriteriaId): void
    {
        $edit = $this->criterionEdits[$phaseCriteriaId] ?? null;
        abort_unless($edit, 404);

        $this->validate([
            "criterionEdits.$phaseCriteriaId.criteria_name" => ['required', 'string', 'max:255'],
            "criterionEdits.$phaseCriteriaId.description" => ['nullable', 'string'],
            "criterionEdits.$phaseCriteriaId.ponderation" => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $phaseCriteria = InterviewPhaseCriteria::with('evaluationCriteria')->findOrFail($phaseCriteriaId);
        abort_unless((int) $phaseCriteria->interview_phase_id === (int) $this->interviewPhase->id, 404);

        $phaseCriteria->evaluationCriteria->update([
            'criteria_name' => trim($edit['criteria_name']),
            'description' => $edit['description'] ?: null,
        ]);

        $phaseCriteria->update([
            'ponderation' => (int) $edit['ponderation'],
        ]);

        $this->loadCriteria();
        $this->loadStats();
        $this->activeTab = 'criteria';
        session()->flash('interview_success', 'Critère mis à jour.');
    }

    public function removeCriterion(int $phaseCriteriaId): void
    {
        $phaseCriteria = InterviewPhaseCriteria::findOrFail($phaseCriteriaId);
        abort_unless((int) $phaseCriteria->interview_phase_id === (int) $this->interviewPhase->id, 404);

        $phaseCriteria->delete();

        $this->loadCriteria();
        $this->loadStats();
        $this->activeTab = 'criteria';
        session()->flash('interview_success', 'Critère retiré.');
    }

    public function addExistingEvaluator(): void
    {
        $this->validate([
            'existingJurorForm.interview_session_id' => ['required', 'integer'],
            'existingJurorForm.agent_id' => ['required', 'integer'],
        ]);

        $session = $this->resolveInterviewSession((int) $this->existingJurorForm['interview_session_id']);

        $alreadyAssigned = InterviewEvaluator::query()
            ->where('interview_session_id', $session->id)
            ->where('evaluator_id', (int) $this->existingJurorForm['agent_id'])
            ->exists();

        if ($alreadyAssigned) {
            $this->addError('existingJurorForm.agent_id', 'Cet évaluateur est déjà affecté à cette session.');
            return;
        }

        InterviewEvaluator::create([
            'interview_session_id' => $session->id,
            'evaluator_id' => (int) $this->existingJurorForm['agent_id'],
            'coupon' => $this->generateCoupon(),
            'qr_token' => (string) Str::uuid(),
        ]);

        $this->existingJurorForm = [
            'interview_session_id' => '',
            'agent_id' => '',
        ];

        $this->loadJurors();
        $this->loadCandidates();
        $this->loadStats();
        $this->activeTab = 'jury';
        session()->flash('interview_success', 'Evaluateur affecté.');
    }

    public function createAndAssignEvaluator(): void
    {
        $this->validate([
            'newJurorForm.interview_session_id' => ['required', 'integer'],
            'newJurorForm.first_name' => ['required', 'string', 'max:100'],
            'newJurorForm.last_name' => ['required', 'string', 'max:100'],
            'newJurorForm.email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'newJurorForm.phone_number' => ['nullable', 'string', 'max:20'],
            'newJurorForm.gender' => ['nullable', 'in:male,female'],
            'newJurorForm.department_id' => ['required', 'integer', 'exists:departments,id'],
            'newJurorForm.job_title' => ['nullable', 'string', 'max:100'],
        ]);

        $session = $this->resolveInterviewSession((int) $this->newJurorForm['interview_session_id']);

        DB::transaction(function () use ($session): void {
            $user = User::create([
                'first_name' => trim($this->newJurorForm['first_name']),
                'last_name' => trim($this->newJurorForm['last_name']),
                'name' => trim($this->newJurorForm['first_name'] . ' ' . $this->newJurorForm['last_name']),
                'email' => $this->newJurorForm['email'] ?: null,
                'phone_number' => $this->newJurorForm['phone_number'] ?: null,
                'gender' => $this->newJurorForm['gender'] ?: null,
                'password' => Str::random(16),
            ]);

            $agent = Agent::create([
                'user_id' => $user->id,
                'department_id' => (int) $this->newJurorForm['department_id'],
                'job_title' => $this->newJurorForm['job_title'] ?: null,
            ]);

            InterviewEvaluator::create([
                'interview_session_id' => $session->id,
                'evaluator_id' => $agent->id,
                'coupon' => $this->generateCoupon(),
                'qr_token' => (string) Str::uuid(),
            ]);
        });

        $this->newJurorForm = [
            'interview_session_id' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone_number' => '',
            'gender' => '',
            'department_id' => '',
            'job_title' => '',
        ];

        $this->loadAgents();
        $this->loadJurors();
        $this->loadCandidates();
        $this->loadStats();
        $this->activeTab = 'jury';
        session()->flash('interview_success', 'Nouvel evaluateur cree et affecte.');
    }

    public function removeEvaluator(int $interviewEvaluatorId): void
    {
        $juror = InterviewEvaluator::with('interviewSession')->findOrFail($interviewEvaluatorId);
        abort_unless((int) $juror->interviewSession->interview_phase_id === (int) $this->interviewPhase->id, 404);

        $juror->delete();

        $this->loadJurors();
        $this->loadCandidates();
        $this->loadStats();
        $this->activeTab = 'jury';
        session()->flash('interview_success', 'Affectation retiree.');
    }

    protected function loadState(): void
    {
        $this->interviewPhase->refresh();

        $this->phaseForm = [
            'description' => (string) ($this->interviewPhase->description ?? ''),
            'duration' => $this->interviewPhase->duration ? (string) $this->interviewPhase->duration : '',
            'start_date' => optional($this->interviewPhase->start_date)->format('Y-m-d') ?? '',
            'end_date' => optional($this->interviewPhase->end_date)->format('Y-m-d') ?? '',
            'status' => (string) ($this->interviewPhase->status ?? 'AWAITING'),
        ];

        $this->loadCriteria();
        $this->loadAgents();
        $this->loadJurors();
        $this->loadCandidates();
        $this->loadResults();
        $this->loadStats();
    }

    protected function loadCandidates(): void
    {
        $applicants = Applicant::query()
            ->where('edition_id', $this->currentEdition->id)
            ->where('application_status', 'TEST_PASSED')
            ->with([
                'interviewSessions' => fn($query) => $query
                    ->where('interview_phase_id', $this->interviewPhase->id)
                    ->with(['evaluators.user']),
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $suggestions = $this->buildScheduleSuggestions($applicants);

        $this->candidateRows = $applicants->map(function (Applicant $applicant) use ($suggestions): array {
            $session = $applicant->interviewSessions->first();
            $scheduledAt = $session?->scheduled_at;

            return [
                'id' => $applicant->id,
                'name' => $applicant->full_name,
                'registration_code' => $applicant->registration_code,
                'gender' => $applicant->gender,
                'phone_number' => $applicant->phone_number,
                'session_id' => $session?->id,
                'scheduled_at' => optional($scheduledAt)->format('d/m/Y H:i'),
                'scheduled_input' => $scheduledAt?->format('Y-m-d\\TH:i') ?? ($suggestions[$applicant->id] ?? ''),
                'started_at' => optional($session?->started_at)->format('d/m/Y H:i'),
                'evaluators_count' => $session?->evaluators?->count() ?? 0,
                'schedule_saved' => $session !== null,
            ];
        })->values()->all();

        foreach ($this->candidateRows as $candidate) {
            $this->candidateSchedules[$candidate['id']] = $candidate['scheduled_input'];
        }
    }

    protected function loadCriteria(): void
    {
        $criteria = InterviewPhaseCriteria::query()
            ->with('evaluationCriteria')
            ->where('interview_phase_id', $this->interviewPhase->id)
            ->orderBy('id')
            ->get();

        $this->criteriaRows = $criteria->map(function (InterviewPhaseCriteria $criterion): array {
            return [
                'id' => $criterion->id,
                'criteria_name' => $criterion->evaluationCriteria?->criteria_name ?? '',
                'description' => $criterion->evaluationCriteria?->description ?? '',
                'ponderation' => (int) $criterion->ponderation,
            ];
        })->all();

        $this->criterionEdits = [];
        foreach ($this->criteriaRows as $criterion) {
            $this->criterionEdits[$criterion['id']] = $criterion;
        }

        $this->criteriaTotal = (int) collect($this->criteriaRows)->sum('ponderation');
    }

    protected function loadAgents(): void
    {
        $this->availableAgents = Agent::query()
            ->with(['user', 'department'])
            ->orderBy('id')
            ->get()
            ->map(function (Agent $agent): array {
                return [
                    'id' => $agent->id,
                    'name' => $agent->user?->full_name ?? $agent->user?->name ?? 'Agent',
                    'email' => $agent->user?->email ?? '',
                    'department' => $agent->department?->name ?? '-',
                    'job_title' => $agent->job_title ?? '',
                ];
            })
            ->all();

        $this->departments = Department::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn($department) => [
                'id' => $department->id,
                'name' => $department->name,
            ])
            ->all();
    }

    protected function loadJurors(): void
    {
        $jurors = InterviewEvaluator::query()
            ->with(['evaluator.user', 'evaluator.department', 'interviewSession.applicant'])
            ->whereHas('interviewSession', fn($query) => $query->where('interview_phase_id', $this->interviewPhase->id))
            ->orderByDesc('id')
            ->get();

        $this->jurorRows = $jurors->map(function (InterviewEvaluator $juror): array {
            $email = $juror->evaluator?->user?->email;
            $phone = preg_replace('/[^0-9]/', '', (string) ($juror->evaluator?->user?->phone_number ?? ''));
            $shareText = rawurlencode('Coupon: ' . ($juror->coupon ?? '-') . ' | QR: ' . ($juror->qr_token ?? '-'));

            return [
                'id' => $juror->id,
                'name' => $juror->evaluator?->user?->full_name ?? $juror->evaluator?->user?->name ?? 'Evaluateur',
                'candidate' => $juror->interviewSession?->applicant?->full_name ?? 'Candidat',
                'department' => $juror->evaluator?->department?->name ?? '-',
                'coupon' => $juror->coupon ?? '-',
                'qr_token' => $juror->qr_token ?? '-',
                'scheduled_at' => optional($juror->interviewSession?->scheduled_at)->format('d/m/Y H:i'),
                'mailto' => $email ? 'mailto:' . $email . '?subject=Invitation%20jury&body=' . $shareText : null,
                'whatsapp' => $phone ? 'https://wa.me/' . $phone . '?text=' . $shareText : null,
            ];
        })->all();
    }

    protected function loadResults(): void
    {
        $sessions = InterviewSession::query()
            ->with([
                'applicant',
                'evaluators.user',
                'evaluators.department',
            ])
            ->where('interview_phase_id', $this->interviewPhase->id)
            ->orderBy('scheduled_at')
            ->get();

        $this->resultRows = $sessions->map(function (InterviewSession $session): array {
            $assignments = InterviewEvaluator::query()
                ->with(['evaluator.user', 'scores.criteria'])
                ->where('interview_session_id', $session->id)
                ->get();

            $evaluatorRows = $assignments->map(function (InterviewEvaluator $assignment): array {
                $scores = $assignment->scores->map(function ($score): array {
                    return [
                        'criteria' => $score->criteria?->criteria_name ?? 'Critere',
                        'score' => (int) $score->score_given,
                        'comment' => $score->comment,
                    ];
                })->all();

                $average = $assignment->scores->count() > 0
                    ? round((float) $assignment->scores->avg('score_given'), 2)
                    : null;

                return [
                    'name' => $assignment->evaluator?->user?->full_name ?? $assignment->evaluator?->user?->name ?? 'Evaluateur',
                    'coupon' => $assignment->coupon ?? '-',
                    'average' => $average,
                    'scores' => $scores,
                ];
            })->values();

            $finalAverage = $evaluatorRows->pluck('average')->filter(fn ($value) => $value !== null)->avg();
            $finalAverage = $finalAverage !== null ? round((float) $finalAverage, 2) : null;

            return [
                'session_id' => $session->id,
                'candidate' => $session->applicant?->full_name ?? 'Candidat',
                'registration_code' => $session->applicant?->registration_code ?? '-',
                'scheduled_at' => optional($session->scheduled_at)->format('d/m/Y H:i'),
                'started_at' => optional($session->started_at)->format('d/m/Y H:i'),
                'average_score' => $finalAverage,
                'recommended_status' => $this->recommendedStatus($finalAverage),
                'evaluators_count' => $evaluatorRows->count(),
                'details' => $evaluatorRows->all(),
            ];
        })->all();
    }

    protected function loadStats(): void
    {
        $scheduledCount = collect($this->candidateRows)->filter(fn($row) => !empty($row['schedule_saved']))->count();
        $startedCount = collect($this->candidateRows)->filter(fn($row) => !empty($row['started_at']))->count();
        $femaleCount = collect($this->candidateRows)->where('gender', 'female')->count();
        $maleCount = collect($this->candidateRows)->where('gender', 'male')->count();
        $completedCount = collect($this->resultRows)->filter(fn ($row) => $row['average_score'] !== null)->count();
        $passedCount = collect($this->resultRows)->where('recommended_status', 'INTERVIEW_PASSED')->count();
        $averageScore = collect($this->resultRows)->pluck('average_score')->filter(fn ($value) => $value !== null)->avg();

        $this->stats = [
            'retained' => count($this->candidateRows),
            'scheduled' => $scheduledCount,
            'started' => $startedCount,
            'jury_assignments' => count($this->jurorRows),
            'criteria_total' => $this->criteriaTotal,
            'female' => $femaleCount,
            'male' => $maleCount,
            'completed' => $completedCount,
            'passed' => $passedCount,
            'average_score' => $averageScore !== null ? round((float) $averageScore, 2) : null,
        ];
    }

    protected function ensureScheduleConfiguration(): bool
    {
        if (!$this->phaseForm['duration'] || !$this->phaseForm['start_date'] || !$this->phaseForm['end_date']) {
            $this->addError('phaseForm.duration', 'Definissez la duree et l intervalle de la phase avant la planification.');
            $this->activeTab = 'dashboard';
            return false;
        }

        return true;
    }

    protected function persistCandidateSchedule(int $applicantId, string $value): void
    {
        $applicant = Applicant::query()
            ->where('edition_id', $this->currentEdition->id)
            ->where('application_status', 'TEST_PASSED')
            ->findOrFail($applicantId);

        $scheduledAt = Carbon::createFromFormat('Y-m-d\\TH:i', $value);
        $existingSession = InterviewSession::query()
            ->where('interview_phase_id', $this->interviewPhase->id)
            ->where('applicant_id', $applicant->id)
            ->first();

        $this->assertSlotIsValid($scheduledAt, $existingSession?->id);

        if ($existingSession) {
            $existingSession->update([
                'scheduled_at' => $scheduledAt,
            ]);

            return;
        }

        InterviewSession::create([
            'applicant_id' => $applicant->id,
            'interview_phase_id' => $this->interviewPhase->id,
            'scheduled_at' => $scheduledAt,
        ]);
    }

    protected function assertSlotIsValid(Carbon $start, ?int $excludeSessionId = null): void
    {
        $duration = (int) $this->phaseForm['duration'];
        $phaseStart = Carbon::parse($this->phaseForm['start_date'])->startOfDay();
        $phaseEnd = Carbon::parse($this->phaseForm['end_date'])->endOfDay();
        $end = (clone $start)->addMinutes($duration);

        if ($duration < 1 || $duration > 480) {
            throw ValidationException::withMessages([
                'phaseForm.duration' => 'La duree doit rester comprise entre 1 et 480 minutes.',
            ]);
        }

        if ($start->lt($phaseStart) || $end->gt($phaseEnd)) {
            throw ValidationException::withMessages([
                'phaseForm.start_date' => 'Le rendez-vous doit rester dans l\'intervalle configuré.',
            ]);
        }

        if ($start->isWeekend()) {
            throw ValidationException::withMessages([
                'phaseForm.start_date' => 'La planification doit se faire du lundi au vendredi.',
            ]);
        }

        if ($start->copy()->setTime(8, 0)->gt($start) || $end->gt($start->copy()->setTime(16, 0))) {
            throw ValidationException::withMessages([
                'phaseForm.duration' => 'Les interviews doivent rester entre 08:00 et 16:00.',
            ]);
        }

        $otherSessions = InterviewSession::query()
            ->where('interview_phase_id', $this->interviewPhase->id)
            ->when($excludeSessionId, fn($query) => $query->where('id', '!=', $excludeSessionId))
            ->get();

        foreach ($otherSessions as $session) {
            if (!$session->scheduled_at) {
                continue;
            }

            $sessionStart = $session->scheduled_at->copy();
            $sessionEnd = $session->scheduled_at->copy()->addMinutes($duration);

            if ($start->lt($sessionEnd) && $end->gt($sessionStart)) {
                throw ValidationException::withMessages([
                    'phaseForm.start_date' => 'Ce slot chevauche déjà une autre interview.',
                ]);
            }
        }
    }

    protected function buildScheduleSuggestions($applicants): array
    {
        $duration = (int) ($this->phaseForm['duration'] ?: 0);
        $startDate = $this->phaseForm['start_date'] ?? null;
        $endDate = $this->phaseForm['end_date'] ?? null;

        if (!$duration || !$startDate || !$endDate || $duration > 480) {
            return [];
        }

        $phaseStart = Carbon::parse($startDate)->startOfDay();
        $phaseEnd = Carbon::parse($endDate)->endOfDay();
        $cursor = $this->moveToWorkingStart($phaseStart->copy());
        $reserved = [];
        $suggestions = [];

        foreach ($applicants as $applicant) {
            $session = $applicant->interviewSessions->first();

            if ($session?->scheduled_at) {
                $reserved[] = [
                    'start' => $session->scheduled_at->copy(),
                    'end' => $session->scheduled_at->copy()->addMinutes($duration),
                ];
                $suggestions[$applicant->id] = $session->scheduled_at->format('Y-m-d\\TH:i');
                continue;
            }

            $slot = $this->findNextAvailableSlot($cursor, $phaseEnd, $duration, $reserved);
            if (!$slot) {
                $suggestions[$applicant->id] = '';
                continue;
            }

            $suggestions[$applicant->id] = $slot->format('Y-m-d\\TH:i');
            $reserved[] = [
                'start' => $slot->copy(),
                'end' => $slot->copy()->addMinutes($duration),
            ];
            $cursor = $slot->copy()->addMinutes($duration);
        }

        return $suggestions;
    }

    protected function findNextAvailableSlot(Carbon $cursor, Carbon $phaseEnd, int $duration, array $reserved): ?Carbon
    {
        $slot = $this->moveToWorkingStart($cursor->copy());

        while ($slot->lte($phaseEnd)) {
            $slotEnd = $slot->copy()->addMinutes($duration);

            if ($slot->isWeekend()) {
                $slot = $this->nextWorkingDay($slot);
                continue;
            }

            if ($slot->hour < 8) {
                $slot->setTime(8, 0);
                $slotEnd = $slot->copy()->addMinutes($duration);
            }

            if ($slotEnd->gt($slot->copy()->setTime(16, 0))) {
                $slot = $this->nextWorkingDay($slot);
                continue;
            }

            if ($slotEnd->gt($phaseEnd)) {
                return null;
            }

            $overlap = false;
            foreach ($reserved as $range) {
                if ($slot->lt($range['end']) && $slotEnd->gt($range['start'])) {
                    $slot = $this->moveToWorkingStart($range['end']->copy());
                    $overlap = true;
                    break;
                }
            }

            if ($overlap) {
                continue;
            }

            return $slot;
        }

        return null;
    }

    protected function moveToWorkingStart(Carbon $dateTime): Carbon
    {
        if ($dateTime->isWeekend()) {
            return $this->nextWorkingDay($dateTime);
        }

        if ($dateTime->hour < 8) {
            return $dateTime->setTime(8, 0);
        }

        if ($dateTime->hour > 15 || ($dateTime->hour === 15 && $dateTime->minute > 59)) {
            return $this->nextWorkingDay($dateTime);
        }

        return $dateTime->copy()->second(0);
    }

    protected function nextWorkingDay(Carbon $dateTime): Carbon
    {
        $next = $dateTime->copy()->addDay()->setTime(8, 0);
        while ($next->isWeekend()) {
            $next->addDay()->setTime(8, 0);
        }

        return $next;
    }

    protected function resolveInterviewSession(int $sessionId): InterviewSession
    {
        $session = InterviewSession::query()->findOrFail($sessionId);
        abort_unless((int) $session->interview_phase_id === (int) $this->interviewPhase->id, 404);
        return $session;
    }

    protected function generateCoupon(): string
    {
        do {
            $coupon = 'JRY-' . strtoupper(Str::random(8));
        } while (InterviewEvaluator::query()->where('coupon', $coupon)->exists());

        return $coupon;
    }

    protected function statusBadgeClasses(string $status): string
    {
        return match ($status) {
            'IN_PROGRESS' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
            'COMPLETED' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
            'CANCELLED' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            default => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
        };
    }

    protected function recommendedStatus(?float $average): string
    {
        if ($average === null) {
            return 'TEST_PASSED';
        }

        return $average >= 50 ? 'INTERVIEW_PASSED' : 'TEST_PASSED';
    }

    protected function resultBadgeClasses(string $status): string
    {
        return match ($status) {
            'INTERVIEW_PASSED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
            'TEST_PASSED' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
            default => 'bg-slate-100 text-slate-700 dark:bg-slate-900/40 dark:text-slate-300',
        };
    }
};
?>

<div class="space-y-6 my-3">
    @if (session()->has('interview_success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 px-4 py-3 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('interview_success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-neutral-900 shadow-sm border border-gray-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
        <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4 px-6 py-5 border-gray-200 dark:border-neutral-800 border-b">
            <div>
                <div class="flex flex-wrap items-center gap-3 mt-2">
                    <h2 class="font-semibold text-gray-900 dark:text-white text-xl">Interviews {{ $currentEdition->name }}</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs {{ $this->statusBadgeClasses($phaseForm['status']) }}">
                        {{ $phaseForm['status'] }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($phaseForm['status'] !== 'AWAITING')
                <button type="button" wire:click="$set('phaseForm.status', 'AWAITING')" class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 px-3 py-2 border border-gray-200 dark:border-neutral-700 rounded-xl text-gray-700 dark:text-gray-200 text-sm">
                    En attente
                </button>
                @endif
                @if($phaseForm['status'] !== 'IN_PROGRESS')
                <button type="button" wire:click="$set('phaseForm.status', 'IN_PROGRESS')" class="bg-emerald-600 hover:bg-emerald-700 px-3 py-2 rounded-xl text-white text-sm">
                    Lancer
                </button>
                @endif
                @if($phaseForm['status'] !== 'CANCELLED')
                <button type="button" wire:click="$set('phaseForm.status', 'CANCELLED')" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded-xl text-white text-sm">
                    Annuler
                </button>
                @endif
                @if($phaseForm['status'] !== 'COMPLETED')
                <button type="button" wire:click="$set('phaseForm.status', 'COMPLETED')" class="bg-slate-700 hover:bg-slate-800 px-3 py-2 rounded-xl text-white text-sm">
                    Cloturer
                </button>
                @endif
            </div>
        </div>

        <div class="gap-4 grid md:grid-cols-2 xl:grid-cols-5 px-6 py-5">
            <div>
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Durée par candidat (min)</label>
                <input type="number" min="1" max="480" wire:model.live="phaseForm.duration" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 focus:border-[#fe042c] dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                @error('phaseForm.duration') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Date de début</label>
                <input type="date" wire:model.live="phaseForm.start_date" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 focus:border-[#fe042c] dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                @error('phaseForm.start_date') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Date de fin</label>
                <input type="date" wire:model.live="phaseForm.end_date" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 focus:border-[#fe042c] dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                @error('phaseForm.end_date') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="xl:col-span-2">
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Description</label>
                <textarea wire:model.defer="phaseForm.description" rows="3" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 focus:border-[#fe042c] dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm"></textarea>
                @error('phaseForm.description') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
        </div>
        <button type="button" wire:click="savePhase" class="float-right justify-end bg-[#039116] hover:bg-[#02ac18] me-2 mb-2 px-4 py-2 rounded-xl text-white text-sm">
            Enregistrer la phase
        </button>
    </div>

    <div class="border-gray-300 dark:border-neutral-700 border-b">
        <div class="flex flex-wrap gap-2">
            <button type="button" wire:click="setTab('dashboard')" class="px-4 py-3 border-b-2 text-sm {{ $activeTab === 'dashboard' ? 'border-[#fe042c] text-[#fe042c]' : 'border-transparent text-gray-600 dark:text-gray-400' }}">
                Dashboard
            </button>
            <button type="button" wire:click="setTab('candidates')" class="px-4 py-3 border-b-2 text-sm {{ $activeTab === 'candidates' ? 'border-[#fe042c] text-[#fe042c]' : 'border-transparent text-gray-600 dark:text-gray-400' }}">
                Candidats retenus
            </button>
            <button type="button" wire:click="setTab('criteria')" class="px-4 py-3 border-b-2 text-sm {{ $activeTab === 'criteria' ? 'border-[#fe042c] text-[#fe042c]' : 'border-transparent text-gray-600 dark:text-gray-400' }}">
                Critères
            </button>
            <button type="button" wire:click="setTab('jury')" class="px-4 py-3 border-b-2 text-sm {{ $activeTab === 'jury' ? 'border-[#fe042c] text-[#fe042c]' : 'border-transparent text-gray-600 dark:text-gray-400' }}">
                Jury
            </button>
            <button type="button" wire:click="setTab('results')" class="px-4 py-3 border-b-2 text-sm {{ $activeTab === 'results' ? 'border-[#fe042c] text-[#fe042c]' : 'border-transparent text-gray-600 dark:text-gray-400' }}">
                Resultats
            </button>
        </div>
    </div>

    @if ($activeTab === 'dashboard')
        <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 mb-4">
            <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Candidats retenus</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['retained'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs"></p>
            </div>
            <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Sessions planifiées</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['scheduled'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Créneaux compris entre 08:00 et 16:00.</p>
            </div>
            {{-- <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Pondération totale</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['criteria_total'] ?? 0 }}%</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">La phase ne peut passer en cours qu'à 100%.</p>
            </div> --}}
            {{-- <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Affectations jury</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['jury_assignments'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Affectations sur les sessions planifiées.</p>
            </div> --}}
            <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Femmes</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['female'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Parmi les candidats retenus.</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Hommes</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['male'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Parmi les candidats retenus.</p>
            </div>
            {{-- <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Evaluations completees</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['completed'] ?? 0 }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Moyenne calculable depuis les notes des evaluateurs.</p>
            </div> --}}
            
            {{-- <div class="bg-white dark:bg-neutral-900 shadow-sm p-5 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Moyenne generale</p>
                <p class="mt-3 font-semibold text-gray-900 dark:text-white text-3xl">{{ $stats['average_score'] ?? '-' }}</p>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-xs">Moyenne des scores finaux disponibles.</p>
            </div> --}}
        </div>
    @endif

    @if ($activeTab === 'candidates')
        <div class="bg-white dark:bg-neutral-900 shadow-sm border border-gray-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
            <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-3 px-6 py-4 border-gray-200 dark:border-neutral-800 border-b">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Planification des candidats</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Le système propose des créneaux dans l'intervalle de la phase et sur les horaires ouvrables.</p>
                </div>
                <button type="button" wire:click="applySuggestedSchedules" class="bg-[#fe042c] hover:bg-[#d90429] px-4 py-2 rounded-xl text-white text-sm">
                    Appliquer toutes les propositions
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="divide-y divide-gray-200 dark:divide-neutral-800 min-w-full">
                    <thead class="bg-gray-50 dark:bg-neutral-950">
                        <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Candidat</th>
                            <th class="px-6 py-3 text-left">Code</th>
                            <th class="px-6 py-3 text-left">Créneau</th>
                            <th class="px-6 py-3 text-left">Démarrée</th>
                            <th class="px-6 py-3 text-left">Jury</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-800">
                        @forelse ($candidateRows as $candidate)
                            <tr class="text-sm">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $candidate['name'] }}</p>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $candidate['phone_number'] ?: '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $candidate['registration_code'] }}</td>
                                <td class="px-6 py-4">
                                    <input type="datetime-local" wire:model.defer="candidateSchedules.{{ $candidate['id'] }}" class="dark:bg-neutral-950 px-3 py-2 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full min-w-[220px] text-gray-900 dark:text-white text-sm">
                                    @error("candidateSchedules.{$candidate['id']}") <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                                    @if ($candidate['scheduled_at'])
                                        <p class="mt-1 text-gray-500 dark:text-gray-400 text-xs">Enregistré: {{ $candidate['scheduled_at'] }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $candidate['started_at'] ?: '-' }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $candidate['evaluators_count'] }}</td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" wire:click="saveCandidateSchedule({{ $candidate['id'] }})" class="bg-slate-900 hover:bg-slate-700 dark:bg-slate-100 dark:hover:bg-white px-3 py-2 rounded-xl text-white dark:text-slate-900 text-sm">
                                        Enregistrer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-gray-500 dark:text-gray-400 text-center">Aucun candidat TEST_PASSED pour cette édition.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($activeTab === 'criteria')
        <div class="gap-6 grid xl:grid-cols-[360px,minmax(0,1fr)]">
            <div class="bg-white dark:bg-neutral-900 shadow-sm p-6 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Ajouter un critère</h3>
                <div class="space-y-4 mt-5">
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Nom</label>
                        <input type="text" required wire:model.defer="criterionDraft.criteria_name" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                        @error('criterionDraft.criteria_name') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Description</label>
                        <textarea rows="2" wire:model.defer="criterionDraft.description" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm"></textarea>
                        @error('criterionDraft.description') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Pondération</label>
                        <input type="number" inputmode="numeric" required min="1" max="100" wire:model.defer="criterionDraft.ponderation" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                        @error('criterionDraft.ponderation') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <button type="button" wire:click="addCriterion" class="bg-[#fe042c] hover:bg-[#d90429] px-4 py-3 rounded-xl w-full text-white text-sm">
                        Ajouter le critère
                    </button>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 shadow-sm p-6 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                <div class="flex justify-between items-center gap-3 mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Liste des critères</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Total actuel: {{ $criteriaTotal }}%</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs {{ $criteriaTotal === 100 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' }}">
                        {{ $criteriaTotal === 100 ? 'Pret' : 'Ajuster à 100%' }}
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse ($criteriaRows as $criterion)
                        <div class="dark:bg-neutral-950 p-4 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                            <div class="items-start gap-3 grid md:grid-cols-[minmax(0,1.4fr),minmax(0,1fr),120px,auto,auto]">
                                <input type="text" wire:model.defer="criterionEdits.{{ $criterion['id'] }}.criteria_name" class="dark:bg-neutral-900 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <textarea rows="3" wire:model.defer="criterionEdits.{{ $criterion['id'] }}.description" class="dark:bg-neutral-900 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full h-full text-gray-900 dark:text-white text-sm"></textarea>
                                <input type="number" min="1" max="100" wire:model.defer="criterionEdits.{{ $criterion['id'] }}.ponderation" class="dark:bg-neutral-900 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <button type="button" wire:click="updateCriterion({{ $criterion['id'] }})" class="bg-gray-300 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-800 px-2 py-2 rounded-xl text-white dark:text-slate-900 text-sm">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                                    </svg>
                                </button>
                                <button type="button" wire:click="removeCriterion({{ $criterion['id'] }})" class="bg-red-600 hover:bg-red-700 px-2 py-2 rounded-xl text-white text-sm">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-gray-500 dark:text-gray-400 text-center">Aucun critère enregistré.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'jury')
        <div class="gap-6 grid xl:grid-cols-[420px,minmax(0,1fr)]">
            <div class="space-y-6">
                <div class="bg-white dark:bg-neutral-900 shadow-sm p-6 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Affecter un agent existant</h3>
                    <div class="space-y-4 mt-5">
                        <div>
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Session candidat</label>
                            <select wire:model.defer="existingJurorForm.interview_session_id" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <option value="">Choisir</option>
                                @foreach ($candidateRows as $candidate)
                                    @if ($candidate['session_id'])
                                        <option value="{{ $candidate['session_id'] }}">{{ $candidate['name'] }} - {{ $candidate['scheduled_at'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('existingJurorForm.interview_session_id') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Agent</label>
                            <select wire:model.defer="existingJurorForm.agent_id" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <option value="">Choisir</option>
                                @foreach ($availableAgents as $agent)
                                    <option value="{{ $agent['id'] }}">{{ $agent['name'] }} - {{ $agent['department'] }}</option>
                                @endforeach
                            </select>
                            @error('existingJurorForm.agent_id') <p class="mt-1 text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>
                        <button type="button" wire:click="addExistingEvaluator" class="bg-[#fe042c] hover:bg-[#d90429] px-4 py-3 rounded-xl w-full text-white text-sm">
                            Affecter cet agent
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-neutral-900 shadow-sm p-6 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Créer un nouvel évaluateur</h3>
                    <div class="space-y-4 mt-5">
                        <select wire:model.defer="newJurorForm.interview_session_id" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                            <option value="">Session candidat</option>
                            @foreach ($candidateRows as $candidate)
                                @if ($candidate['session_id'])
                                    <option value="{{ $candidate['session_id'] }}">{{ $candidate['name'] }} - {{ $candidate['scheduled_at'] }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="gap-3 grid md:grid-cols-2">
                            <input type="text" wire:model.defer="newJurorForm.first_name" placeholder="Prénom" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                            <input type="text" wire:model.defer="newJurorForm.last_name" placeholder="Nom" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                        </div>
                        <div class="gap-3 grid md:grid-cols-2">
                            <input type="email" wire:model.defer="newJurorForm.email" placeholder="Email" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                            <input type="text" wire:model.defer="newJurorForm.phone_number" placeholder="Téléphone" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                        </div>
                        <div class="gap-3 grid md:grid-cols-2">
                            <select wire:model.defer="newJurorForm.gender" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <option value="">Genre</option>
                                <option value="male">Masculin</option>
                                <option value="female">Feminin</option>
                            </select>
                            <select wire:model.defer="newJurorForm.department_id" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                                <option value="">Département</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" wire:model.defer="newJurorForm.job_title" placeholder="Fonction" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm">
                        <button type="button" wire:click="createAndAssignEvaluator" class="bg-slate-900 hover:bg-slate-700 dark:bg-slate-100 dark:hover:bg-white px-4 py-3 rounded-xl w-full text-white dark:text-slate-900 text-sm">
                            Créer et affecter
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 shadow-sm border border-gray-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-gray-200 dark:border-neutral-800 border-b">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Affectations actuelles</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="divide-y divide-gray-200 dark:divide-neutral-800 min-w-full">
                        <thead class="bg-gray-50 dark:bg-neutral-950">
                            <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">Evaluateur</th>
                                <th class="px-6 py-3 text-left">Candidat</th>
                                <th class="px-6 py-3 text-left">Coupon</th>
                                {{-- <th class="px-6 py-3 text-left">QR</th> --}}
                                <th class="px-6 py-3 text-left">Partage</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-800">
                            @forelse ($jurorRows as $juror)
                                <tr class="text-sm">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $juror['name'] }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $juror['department'] }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        <p>{{ $juror['candidate'] }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $juror['scheduled_at'] ?: '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-gray-700 dark:text-gray-300">{{ $juror['coupon'] }}</td>
                                    {{-- <td class="px-6 py-4 font-mono text-gray-700 dark:text-gray-300">{{ $juror['qr_token'] }}</td> --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @if ($juror['mailto'])
                                                <a href="{{ $juror['mailto'] }}" target="_blank" class="bg-emerald-100 hover:bg-emerald-200 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 px-3 py-2 rounded-xl text-emerald-700 dark:text-emerald-300 text-xs">
                                                    Mail
                                                </a>
                                            @endif
                                            @if ($juror['whatsapp'])
                                                <a href="{{ $juror['whatsapp'] }}" target="_blank" class="bg-sky-100 hover:bg-sky-200 dark:bg-sky-900/30 dark:hover:bg-sky-900/50 px-3 py-2 rounded-xl text-sky-700 dark:text-sky-300 text-xs">
                                                    WhatsApp
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" wire:click="removeEvaluator({{ $juror['id'] }})" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded-xl text-white text-sm">
                                            Retirer
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-gray-500 dark:text-gray-400 text-center">Aucune affectation jury pour l instant.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'results')
        <div class="bg-white dark:bg-neutral-900 shadow-sm border border-gray-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-gray-200 dark:border-neutral-800 border-b">
                <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Resultats des interviews</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Clique sur une ligne pour voir le detail des evaluateurs, notes et commentaires.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="divide-y divide-gray-200 dark:divide-neutral-800 min-w-full">
                    <thead class="bg-gray-50 dark:bg-neutral-950">
                        <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Candidat</th>
                            <th class="px-6 py-3 text-left">Code</th>
                            <th class="px-6 py-3 text-left">Moyenne</th>
                            <th class="px-6 py-3 text-left">Statut</th>
                            <th class="px-6 py-3 text-left">Evaluateurs</th>
                            <th class="px-6 py-3 text-left">Horaire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-800">
                        @forelse ($resultRows as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-950/60 text-sm cursor-pointer" wire:click="toggleResultDetails({{ $row['session_id'] }})">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $row['candidate'] }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $row['registration_code'] }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $row['average_score'] ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs {{ $this->resultBadgeClasses($row['recommended_status']) }}">
                                        {{ $row['recommended_status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $row['evaluators_count'] }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $row['scheduled_at'] ?: '-' }}</td>
                            </tr>
                            @if ($expandedResultSessionId === $row['session_id'])
                                <tr class="bg-gray-50 dark:bg-neutral-950/40">
                                    <td colspan="6" class="px-6 py-5">
                                        <div class="space-y-4">
                                            @forelse ($row['details'] as $detail)
                                                <div class="bg-white dark:bg-neutral-900 p-4 border border-gray-200 dark:border-neutral-800 rounded-2xl">
                                                    <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-2 mb-4">
                                                        <div>
                                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $detail['name'] }}</p>
                                                            <p class="text-gray-500 dark:text-gray-400 text-xs">Coupon: {{ $detail['coupon'] }}</p>
                                                        </div>
                                                        <p class="font-medium text-gray-700 dark:text-gray-300 text-sm">Moyenne evaluateur: {{ $detail['average'] ?? '-' }}</p>
                                                    </div>
                                                    <div class="space-y-3">
                                                        @forelse ($detail['scores'] as $score)
                                                            <div class="items-start gap-4 grid md:grid-cols-[minmax(0,1fr),110px,minmax(0,1fr)] text-sm">
                                                                <div class="text-gray-900 dark:text-white">{{ $score['criteria'] }}</div>
                                                                <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $score['score'] }}/100</div>
                                                                <div class="text-gray-600 dark:text-gray-400">{{ $score['comment'] ?: '-' }}</div>
                                                            </div>
                                                        @empty
                                                            <p class="text-gray-500 dark:text-gray-400 text-sm">Aucune note enregistree pour cet evaluateur.</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Aucun evaluateur ou aucune note pour cette session.</p>
                                            @endforelse
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-gray-500 dark:text-gray-400 text-center">Aucun resultat disponible pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
