<?php

use App\Models\EvaluationScore;
use App\Models\InterviewEvaluator;
use App\Models\InterviewPhaseCriteria;
use Livewire\Component;

new class extends Component {
    public InterviewEvaluator $assignment;
    public array $criteriaRows = [];
    public array $scores = [];
    public array $comments = [];
    public ?string $savedMessage = null;

    public function mount($assignment): void
    {
        $this->assignment = InterviewEvaluator::query()
            ->with([
                'evaluator.user',
                'interviewSession.applicant',
                'interviewSession.interviewPhase',
                'scores.criteria',
            ])
            ->findOrFail($assignment->id);

        $criteria = InterviewPhaseCriteria::query()
            ->with('evaluationCriteria')
            ->where('interview_phase_id', $this->assignment->interviewSession->interview_phase_id)
            ->orderBy('id')
            ->get();

        $existingScores = $this->assignment->scores->keyBy('criteria_id');

        $this->criteriaRows = $criteria->map(function (InterviewPhaseCriteria $criterion) use ($existingScores): array {
            $criteriaId = (int) $criterion->criteria_id;
            $saved = $existingScores->get($criteriaId);

            $this->scores[$criteriaId] = $saved?->score_given ?? 0;
            $this->comments[$criteriaId] = $saved?->comment ?? '';

            return [
                'criteria_id' => $criteriaId,
                'name' => $criterion->evaluationCriteria?->criteria_name ?? 'Critere',
                'description' => $criterion->evaluationCriteria?->description ?? '',
                'max_score' => (int) $criterion->ponderation,
            ];
        })->all();
    }

    public function save(): void
    {
        $rules = [];
        foreach ($this->criteriaRows as $criterion) {
            $criteriaId = $criterion['criteria_id'];
            $rules["scores.$criteriaId"] = ['required', 'integer', 'min:0', 'max:' . $criterion['max_score']];
            $rules["comments.$criteriaId"] = ['nullable', 'string'];
        }

        $this->validate($rules);

        if ($this->assignment->scores()->exists()) {
            $this->redirectRoute('evaluator.panel', ['locale' => app()->getLocale()], navigate: true);
            return;
        }

        foreach ($this->criteriaRows as $criterion) {
            $criteriaId = $criterion['criteria_id'];

            EvaluationScore::updateOrCreate(
                [
                    'interview_evaluator_id' => $this->assignment->id,
                    'criteria_id' => $criteriaId,
                ],
                [
                    'score_given' => (int) $this->scores[$criteriaId],
                    'comment' => $this->comments[$criteriaId] ?: null,
                ]
            );
        }

        $this->refreshSessionAverage();
        $candidateName = $this->assignment->interviewSession?->applicant?->full_name ?? 'ce candidat';
        session()->flash('success', "Evaluation de {$candidateName} enregistree avec succes. Cette fiche est maintenant verrouillee.");
        $this->redirectRoute('evaluator.panel', ['locale' => app()->getLocale()], navigate: true);
    }

    public function syncScore(int $criteriaId, int $value): void
    {
        $criterion = collect($this->criteriaRows)->firstWhere('criteria_id', $criteriaId);
        abort_unless($criterion, 404);

        $this->scores[$criteriaId] = max(0, min((int) $criterion['max_score'], $value));
    }

    protected function refreshSessionAverage(): void
    {
        $assignments = InterviewEvaluator::query()
            ->with('scores')
            ->where('interview_session_id', $this->assignment->interview_session_id)
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

        $this->assignment->interviewSession->update([
            'final_average_score' => $finalAverage,
        ]);
    }
};
?>

<div class="space-y-6">
    @if ($savedMessage)
        <div class="bg-emerald-50 dark:bg-emerald-900/20 px-4 py-3 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-300 text-sm">
            {{ $savedMessage }}
        </div>
    @endif

    @foreach ($criteriaRows as $criterion)
        @php
            $criteriaId = $criterion['criteria_id'];
            $maxScore = $criterion['max_score'];
        @endphp
        <div
            x-data="{ currentScore: {{ (int) ($scores[$criteriaId] ?? 0) }} }"
            class="bg-white dark:bg-neutral-900 shadow-sm p-6 border border-gray-200 dark:border-neutral-800 rounded-2xl"
        >
            <div class="flex md:flex-row flex-col md:justify-between md:items-start gap-3 mb-4">
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white text-xl">
                        {{ $criterion['name'] }}
                    </h2>
                    <p class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
                        {{ $criterion['description'] ?: 'Aucune description.' }}
                    </p>
                </div>
                <span class="inline-flex items-center bg-amber-100 dark:bg-amber-900/30 px-3 py-1 rounded-full text-amber-700 dark:text-amber-300 text-xs">
                    Max: {{ $maxScore }}
                </span>
            </div>

            <div wire:ignore class="mb-4">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">Score attribue</span>
                    <span class="font-semibold text-gray-900 dark:text-white text-lg">
                        <span x-text="currentScore"></span> / {{ $maxScore }}
                    </span>
                </div>

                <input
                    type="range"
                    min="0"
                    max="{{ $maxScore }}"
                    step="1"
                    x-model="currentScore"
                    x-on:change="$wire.syncScore({{ $criteriaId }}, Number(currentScore))"
                    x-on:pointerup="$wire.syncScore({{ $criteriaId }}, Number(currentScore))"
                    x-on:touchend="$wire.syncScore({{ $criteriaId }}, Number(currentScore))"
                    class="bg-transparent w-full h-2 accent-[#fe042c] cursor-pointer"
                >

                <div class="flex justify-between mt-2 text-gray-500 dark:text-gray-400 text-xs">
                    <span>0</span>
                    <span>{{ (int) floor($maxScore / 2) }}</span>
                    <span>{{ $maxScore }}</span>
                </div>
            </div>
            @error("scores.$criteriaId")
                <p class="mb-4 text-red-600 text-xs">{{ $message }}</p>
            @enderror

            <div>
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200 text-sm">Commentaire</label>
                <textarea wire:model.defer="comments.{{ $criteriaId }}" rows="3" class="dark:bg-neutral-950 px-4 py-3 border border-gray-200 dark:border-neutral-700 rounded-xl focus:outline-none w-full text-gray-900 dark:text-white text-sm"></textarea>
            </div>
        </div>
    @endforeach

    <div class="flex justify-end">
        <button type="button" wire:click="save" class="bg-[#fe042c] hover:bg-[#d90429] px-5 py-3 rounded-xl text-white text-sm">
            Enregistrer l'évaluation
        </button>
    </div>
</div>
