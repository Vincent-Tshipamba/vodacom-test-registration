<?php

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\{Question, PhaseTest, AnswerOption, CategoryQuestion, ScholarshipEdition};

new class extends Component {
    public ScholarshipEdition $currentEdition;
    public PhaseTest $currentPhaseTest;
    public array $categories = [];
    public array $questions = [];
    public array $questionSuggestions = [];
    public array $optionSuggestions = [];
    public ?string $editingQuestionUuid = null;
    public array $editingBackups = [];
    public array $newDraftUuids = [];
    public string $filterCategoryId = '';
    public string $savedStateHash = '';

    public function mount(): void
    {
        $this->currentEdition = ScholarshipEdition::getCurrentEdition();
        abort_unless($this->currentEdition, 404);

        $this->currentPhaseTest = PhaseTest::where('scholarship_edition_id', $this->currentEdition->id)->where('status', 'AWAITING')->first();

        $this->categories = CategoryQuestion::orderBy('name')->get(['id', 'name'])->toArray();
        $this->questions = $this->loadExistingQuestions();
        if (empty($this->questions)) {
            $draft = $this->newQuestion(0);
            $this->questions[] = $draft;
            $this->editingQuestionUuid = $draft['uuid'];
            $this->newDraftUuids[$draft['uuid']] = true;
        } else {
            $this->editingQuestionUuid = null;
        }
        $this->savedStateHash = $this->builderStateHash($this->questions);
    }

    private function loadExistingQuestions(): array
    {
        $items = [];
        $existing = $this->currentPhaseTest->questions()
            ->with(['answer_options' => fn($q) => $q->orderBy('question_answer_options.id')])
            ->orderBy('question_phase_tests.id')
            ->get();

        foreach ($existing as $i => $question) {
            $options = [];
            $correct = 0;
            foreach ($question->answer_options as $j => $opt) {
                $isCorrect = (bool) ($opt->pivot->is_correct ?? false);
                if ($isCorrect) {
                    $correct++;
                }
                $options[] = [
                    'uuid' => (string) Str::uuid(),
                    'id' => $opt->id,
                    'option_text' => $opt->option_text,
                    'is_correct' => $isCorrect,
                    'position' => $j,
                ];
            }

            $items[] = [
                'uuid' => (string) Str::uuid(),
                'id' => $question->id,
                'category_question_id' => $question->category_question_id,
                'question_text' => $question->question_text,
                'ponderation' => (int) ($question->pivot->ponderation ?? 1),
                'allow_multiple' => $correct > 1,
                'suggestions_enabled' => true,
                'is_validated' => true,
                'position' => $i,
                'options' => count($options) ? $options : [$this->newOption(0), $this->newOption(1)],
            ];
        }

        return $items;
    }

    private function newQuestion(int $position): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'id' => null,
            'category_question_id' => null,
            'question_text' => '',
            'ponderation' => 1,
            'allow_multiple' => false,
            'suggestions_enabled' => true,
            'is_validated' => false,
            'position' => $position,
            'options' => [$this->newOption(0), $this->newOption(1)],
        ];
    }

    private function newOption(int $position): array
    {
        return ['uuid' => (string) Str::uuid(), 'id' => null, 'option_text' => '', 'is_correct' => false, 'position' => $position];
    }

    public function addQuestion(): void
    {
        if ($this->editingQuestionUuid) {
            $this->cancelEditing($this->editingQuestionUuid);
        }

        $new = $this->newQuestion(count($this->questions));
        if ($this->filterCategoryId !== '') {
            $new['category_question_id'] = (int) $this->filterCategoryId;
        }
        $this->questions[] = $new;
        $this->editingQuestionUuid = $new['uuid'];
        $this->newDraftUuids[$new['uuid']] = true;
    }

    public function addQuestionAfter(string $qUuid): void
    {
        if ($this->editingQuestionUuid) {
            $this->cancelEditing($this->editingQuestionUuid);
        }

        $index = $this->qi($qUuid);
        if ($index === null) {
            $this->addQuestion();
            return;
        }

        $new = $this->newQuestion($index + 1);
        if ($this->filterCategoryId !== '') {
            $new['category_question_id'] = (int) $this->filterCategoryId;
        }
        array_splice($this->questions, $index + 1, 0, [$new]);
        $this->reindexQuestions();
        $this->editingQuestionUuid = $new['uuid'];
        $this->newDraftUuids[$new['uuid']] = true;
    }
    public function addOption(string $qUuid): void
    {
        if (($q = $this->qi($qUuid)) !== null) {
            $this->questions[$q]['options'][] = $this->newOption(count($this->questions[$q]['options']));
            $this->questions[$q]['is_validated'] = false;
            $this->resetValidation("questions.$q.options");
            $this->resetValidation("questions.$q.options_correct");
        }
    }
    public function moveQuestionUp(string $qUuid): void
    {
        $this->swapQ($qUuid, -1);
    }
    public function moveQuestionDown(string $qUuid): void
    {
        $this->swapQ($qUuid, 1);
    }
    public function moveOptionUp(string $qUuid, string $oUuid): void
    {
        $this->swapO($qUuid, $oUuid, -1);
    }
    public function moveOptionDown(string $qUuid, string $oUuid): void
    {
        $this->swapO($qUuid, $oUuid, 1);
    }
    public function removeQuestion(string $qUuid): void
    {
        if (($q = $this->qi($qUuid)) === null)
            return;
        unset($this->questions[$q], $this->questionSuggestions[$qUuid]);
        unset($this->editingBackups[$qUuid], $this->newDraftUuids[$qUuid]);
        $this->questions = array_values($this->questions);
        if (!$this->questions) {
            $draft = $this->newQuestion(0);
            $this->questions[] = $draft;
            $this->editingQuestionUuid = $draft['uuid'];
            $this->newDraftUuids[$draft['uuid']] = true;
        } elseif ($this->editingQuestionUuid === $qUuid) {
            $this->editingQuestionUuid = null;
        }
        $this->reindexQuestions();
    }

    public function startEditing(string $qUuid): void
    {
        if ($this->editingQuestionUuid && $this->editingQuestionUuid !== $qUuid) {
            $this->cancelEditing($this->editingQuestionUuid);
        }

        $q = $this->qi($qUuid);
        if ($q === null) {
            return;
        }
        if (!array_key_exists($qUuid, $this->editingBackups) && empty($this->newDraftUuids[$qUuid])) {
            $this->editingBackups[$qUuid] = $this->questions[$q];
        }
        $this->editingQuestionUuid = $qUuid;
    }

    public function cancelEditing(?string $qUuid = null): void
    {
        $targetUuid = $qUuid ?: $this->editingQuestionUuid;
        if (!$targetUuid) {
            return;
        }

        $q = $this->qi($targetUuid);
        if ($q === null) {
            $this->editingQuestionUuid = null;
            unset($this->editingBackups[$targetUuid], $this->newDraftUuids[$targetUuid]);
            return;
        }

        if (!empty($this->newDraftUuids[$targetUuid])) {
            unset($this->questions[$q], $this->questionSuggestions[$targetUuid], $this->optionSuggestions[$targetUuid]);
            $this->questions = array_values($this->questions);
            $this->reindexQuestions();
        } elseif (array_key_exists($targetUuid, $this->editingBackups)) {
            $this->questions[$q] = $this->editingBackups[$targetUuid];
        }

        unset($this->editingBackups[$targetUuid], $this->newDraftUuids[$targetUuid], $this->questionSuggestions[$targetUuid], $this->optionSuggestions[$targetUuid]);
        $this->editingQuestionUuid = null;
    }

    public function removeOption(string $qUuid, string $oUuid): void
    {
        if (($q = $this->qi($qUuid)) === null || ($o = $this->oi($q, $oUuid)) === null)
            return;
        unset($this->questions[$q]['options'][$o], $this->optionSuggestions[$qUuid][$oUuid]);
        $this->questions[$q]['options'] = array_values($this->questions[$q]['options']);
        $this->reindexOptions($q);
        $this->questions[$q]['is_validated'] = false;
        $this->resetValidation("questions.$q.options");
        $this->resetValidation("questions.$q.options_correct");
    }

    public function duplicateQuestion(string $qUuid): void
    {
        if (($q = $this->qi($qUuid)) === null)
            return;
        $copy = $this->questions[$q];
        $copy['uuid'] = (string) Str::uuid();
        $copy['id'] = null;
        foreach ($copy['options'] as $i => &$o) {
            $o['uuid'] = (string) Str::uuid();
            $o['id'] = null;
            $o['position'] = $i;
        }
        unset($o);
        array_splice($this->questions, $q + 1, 0, [$copy]);
        $this->reindexQuestions();
    }

    public function toggleCorrectOption(string $qUuid, string $oUuid): void
    {
        if (($q = $this->qi($qUuid)) === null || ($o = $this->oi($q, $oUuid)) === null)
            return;
        if (!$this->questions[$q]['allow_multiple'])
            foreach ($this->questions[$q]['options'] as &$opt)
                $opt['is_correct'] = false;
        $this->questions[$q]['options'][$o]['is_correct'] = !$this->questions[$q]['options'][$o]['is_correct'];
        $this->questions[$q]['is_validated'] = false;
        $this->resetValidation("questions.$q.options_correct");
        $this->resetValidation("questions.$q.allow_multiple");
    }

    public function updated($name, $value): void
    {
        $p = explode('.', $name);
        if (($p[0] ?? null) !== 'questions')
            return;
        $q = isset($p[1]) ? (int) $p[1] : null;
        if (!isset($this->questions[$q]))
            return;
        $qUuid = $this->questions[$q]['uuid'];
        $this->resetValidation($name);

        if (($p[2] ?? null) === 'question_text') {
            $this->questions[$q]['is_validated'] = false;
            if (!empty($this->questions[$q]['id'])) {
                $this->questions[$q]['id'] = null;
            }
            if (empty($this->questions[$q]['suggestions_enabled'])) {
                $this->questionSuggestions[$qUuid] = [];
                return;
            }
            $this->loadQuestionSuggestions($qUuid, (string) $value);
            return;
        }
        if (($p[2] ?? null) === 'category_question_id') {
            $this->questions[$q]['is_validated'] = false;
            $this->resetValidation("questions.$q.question_text");
            if (!empty($this->questions[$q]['id'])) {
                $this->questions[$q]['id'] = null;
            }
            if (empty($this->questions[$q]['suggestions_enabled'])) {
                $this->questionSuggestions[$qUuid] = [];
                return;
            }
            $this->loadQuestionSuggestions($qUuid, (string) ($this->questions[$q]['question_text'] ?? ''));
            return;
        }
        if (($p[2] ?? null) === 'suggestions_enabled') {
            if (empty($this->questions[$q]['suggestions_enabled'])) {
                $this->questionSuggestions[$qUuid] = [];
                unset($this->optionSuggestions[$qUuid]);
            }
            return;
        }
        if (($p[2] ?? null) === 'ponderation') {
            $this->questions[$q]['is_validated'] = false;
            return;
        }
        if (($p[2] ?? null) === 'allow_multiple' && !$this->questions[$q]['allow_multiple']) {
            $this->questions[$q]['is_validated'] = false;
            $this->resetValidation("questions.$q.options_correct");
            $this->resetValidation("questions.$q.allow_multiple");
            $one = false;
            foreach ($this->questions[$q]['options'] as &$opt) {
                if ($opt['is_correct'] && !$one) {
                    $one = true;
                    continue;
                }
                $opt['is_correct'] = false;
            }
            return;
        }
        if (($p[2] ?? null) === 'options' && ($p[4] ?? null) === 'option_text') {
            $this->questions[$q]['is_validated'] = false;
            if (!empty($this->questions[$q]['id'])) {
                $this->questions[$q]['id'] = null;
            }
            if (empty($this->questions[$q]['suggestions_enabled'])) {
                return;
            }
            $o = (int) $p[3];
            $oUuid = $this->questions[$q]['options'][$o]['uuid'] ?? null;
            if ($oUuid)
                $this->loadOptionSuggestions($qUuid, $oUuid, (string) $value);
            if (isset($this->questions[$q]['options'][$o]['id'])) {
                $this->questions[$q]['options'][$o]['id'] = null;
            }
        }
    }

    public function validateQuestionAndAdd(string $qUuid): void
    {
        $q = $this->qi($qUuid);
        if ($q === null)
            return;

        $errors = [];
        $this->validateQuestionAtIndex($q, $errors);
        if ($errors)
            throw ValidationException::withMessages($errors);

        $this->questions[$q]['is_validated'] = true;
        $this->questionSuggestions[$qUuid] = [];
        unset($this->editingBackups[$qUuid], $this->newDraftUuids[$qUuid]);
        $this->editingQuestionUuid = null;
    }

    public function loadQuestionSuggestions(string $qUuid, string $term): void
    {
        $this->questionSuggestions[$qUuid] = [];
        if (($q = $this->qi($qUuid)) === null)
            return;
        if (empty($this->questions[$q]['suggestions_enabled']))
            return;
        $cat = $this->questions[$q]['category_question_id'];
        if (!$cat || mb_strlen(trim($term)) < 2)
            return;

        $this->questionSuggestions[$qUuid] = Question::where('category_question_id', $cat)
            ->where('question_text', 'like', '%' . trim($term) . '%')
            ->when(!empty($this->questions[$q]['id']), fn($x) => $x->where('questions.id', '!=', $this->questions[$q]['id']))
            ->withCount('phase_tests as usage_count')
            ->orderByDesc('usage_count')->orderByDesc('id')->limit(8)
            ->get(['id', 'question_text', 'category_question_id'])->toArray();
    }

    public function loadOptionSuggestions(string $qUuid, string $oUuid, string $term): void
    {
        $this->optionSuggestions[$qUuid][$oUuid] = [];
        if (($q = $this->qi($qUuid)) === null)
            return;
        if (empty($this->questions[$q]['suggestions_enabled']))
            return;
        $cat = $this->questions[$q]['category_question_id'];
        if (!$cat || mb_strlen(trim($term)) < 2)
            return;

        $this->optionSuggestions[$qUuid][$oUuid] = AnswerOption::where('option_text', 'like', '%' . trim($term) . '%')
            ->whereHas('questions', function ($x) use ($cat) {
                $x->where('category_question_id', $cat);
            })
            ->distinct()->limit(8)->get(['answer_options.id', 'answer_options.option_text'])->toArray();
    }

    public function selectQuestionSuggestion(string $qUuid, int $id): void
    {
        if (($q = $this->qi($qUuid)) === null)
            return;
        $question = Question::with(['answer_options' => fn($x) => $x->orderBy('question_answer_options.id')])->find($id);
        if (!$question)
            return;

        $opts = [];
        $correct = 0;
        foreach ($question->answer_options as $i => $o) {
            $is = (bool) ($o->pivot->is_correct ?? false);
            if ($is)
                $correct++;
            $opts[] = ['uuid' => (string) Str::uuid(), 'id' => $o->id, 'option_text' => $o->option_text, 'is_correct' => $is, 'position' => $i];
        }

        $this->questions[$q]['id'] = $question->id;
        $this->questions[$q]['question_text'] = $question->question_text;
        $this->questions[$q]['category_question_id'] = $question->category_question_id;
        $this->questions[$q]['allow_multiple'] = $correct > 1;
        $this->questions[$q]['options'] = $opts ?: [$this->newOption(0), $this->newOption(1)];
        $this->questions[$q]['is_validated'] = false;
        $this->questionSuggestions[$qUuid] = [];
    }

    public function selectOptionSuggestion(string $qUuid, string $oUuid, int $id): void
    {
        if (($q = $this->qi($qUuid)) === null || ($o = $this->oi($q, $oUuid)) === null)
            return;
        $opt = AnswerOption::find($id);
        if (!$opt)
            return;
        $this->questions[$q]['options'][$o]['id'] = $opt->id;
        $this->questions[$q]['options'][$o]['option_text'] = $opt->option_text;
        $this->optionSuggestions[$qUuid][$oUuid] = [];
    }

    public function saveAll(): void
    {
        $toSave = array_values(array_filter($this->questions, fn($q) => !empty($q['is_validated'])));
        if (empty($toSave)) {
            throw ValidationException::withMessages(['questions' => __('Valide au moins une question avant d enregistrer.')]);
        }

        $this->validateBuilder($toSave);
        DB::transaction(function () use ($toSave) {
            $phaseSync = [];
            foreach ($toSave as $q) {
                $qId = $q['id'];
                if (!$qId) {
                    $qId = Question::create([
                        'category_question_id' => $q['category_question_id'],
                        'question_text' => trim($q['question_text']),
                        'question_type' => 'MCQ',
                    ])->id;
                    $sync = [];
                    foreach ($q['options'] as $o) {
                        $oId = $o['id'] ?: AnswerOption::create(['option_text' => trim($o['option_text'])])->id;
                        $sync[$oId] = ['is_correct' => (bool) $o['is_correct']];
                    }
                    Question::find($qId)?->answer_options()->sync($sync);
                } else {
                    $question = Question::find($qId);
                    if ($question) {
                        $question->update([
                            'category_question_id' => $q['category_question_id'],
                            'question_text' => trim($q['question_text']),
                            'question_type' => 'MCQ',
                        ]);

                        $sync = [];
                        foreach ($q['options'] as $o) {
                            if (!empty($o['id'])) {
                                $opt = AnswerOption::find($o['id']);
                                if ($opt) {
                                    $opt->update(['option_text' => trim($o['option_text'])]);
                                    $oId = $opt->id;
                                } else {
                                    $oId = AnswerOption::create(['option_text' => trim($o['option_text'])])->id;
                                }
                            } else {
                                $oId = AnswerOption::create(['option_text' => trim($o['option_text'])])->id;
                            }
                            $sync[$oId] = ['is_correct' => (bool) $o['is_correct']];
                        }

                        $question->answer_options()->sync($sync);
                    }
                }
                $phaseSync[$qId] = ['ponderation' => (int) $q['ponderation']];
            }
            // Keep phase questions exactly aligned with the validated builder state.
            $this->currentPhaseTest->questions()->sync($phaseSync);
            $this->currentPhaseTest->update(['total_questions' => count($phaseSync)]);
        });
        session()->flash('success', __('Questions enregistrées avec succès !'));
        $this->editingBackups = [];
        $this->newDraftUuids = [];
        $this->questions = $this->loadExistingQuestions();
        if (empty($this->questions)) {
            $draft = $this->newQuestion(0);
            $this->questions[] = $draft;
            $this->editingQuestionUuid = $draft['uuid'];
            $this->newDraftUuids[$draft['uuid']] = true;
        } else {
            $this->editingQuestionUuid = null;
        }
        $this->savedStateHash = $this->builderStateHash($this->questions);
        $this->questionSuggestions = [];
        $this->optionSuggestions = [];
    }

    private function builderStateHash(array $questions): string
    {
        $normalized = [];
        foreach ($questions as $q) {
            $row = [
                'id' => $q['id'] ?? null,
                'category_question_id' => $q['category_question_id'] ?? null,
                'question_text' => trim((string) ($q['question_text'] ?? '')),
                'ponderation' => (int) ($q['ponderation'] ?? 1),
                'allow_multiple' => (bool) ($q['allow_multiple'] ?? false),
                'suggestions_enabled' => (bool) ($q['suggestions_enabled'] ?? true),
                'is_validated' => (bool) ($q['is_validated'] ?? false),
                'position' => (int) ($q['position'] ?? 0),
                'options' => [],
            ];

            foreach (($q['options'] ?? []) as $o) {
                $row['options'][] = [
                    'id' => $o['id'] ?? null,
                    'option_text' => trim((string) ($o['option_text'] ?? '')),
                    'is_correct' => (bool) ($o['is_correct'] ?? false),
                    'position' => (int) ($o['position'] ?? 0),
                ];
            }

            $normalized[] = $row;
        }

        return md5(json_encode($normalized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function hasUnsavedChanges(): bool
    {
        return $this->builderStateHash($this->questions) !== $this->savedStateHash;
    }

    public function phaseQuestionsCount(): int
    {
        return count(array_filter($this->questions, fn($q) => !empty($q['is_validated'])));
    }

    private function validateBuilder(array $questions): void
    {
        $errors = [];
        $dup = [];
        $seenIds = [];
        foreach ($questions as $i => $_q) {
            if (!empty($_q['id'])) {
                if (isset($seenIds[$_q['id']])) {
                    $errors["questions.$i.question_text"] = __('Cette question est deja presente dans la phase en cours.');
                }
                $seenIds[$_q['id']] = true;
            }
            $this->validateQuestionPayload($_q, "questions.$i", $dup, $errors);
        }

        if ($errors)
            throw ValidationException::withMessages($errors);
    }

    private function validateQuestionAtIndex(int $index, array &$errors): void
    {
        $dup = [];
        $seenIds = [];
        foreach ($this->questions as $i => $q) {
            if ($i === $index || !empty($q['is_validated'])) {
                if (!empty($q['id'])) {
                    if (isset($seenIds[$q['id']])) {
                        $errors["questions.$i.question_text"] = __('Cette question est deja presente dans la phase en cours.');
                    }
                    $seenIds[$q['id']] = true;
                }
                $this->validateQuestionPayload($q, "questions.$i", $dup, $errors);
            }
        }
    }

    private function validateQuestionPayload(array $q, string $p, array &$dup, array &$errors): void
    {
        if (!$q['category_question_id'])
            $errors["$p.category_question_id"] = __('La categorie est obligatoire.');
        if (!$q['id'] && blank(trim((string) $q['question_text'])))
            $errors["$p.question_text"] = __('Le texte de la question est obligatoire.');
        if ((int) $q['ponderation'] < 1)
            $errors["$p.ponderation"] = __('La ponderation doit etre au moins 1.');

        if (!$q['id']) {
            $k = ($q['category_question_id'] ?? 'x') . '|' . $this->norm($q['question_text']);
            if (isset($dup[$k]))
                $errors["$p.question_text"] = __('Question dupliquee dans la meme categorie.');
            $dup[$k] = true;
        }

        if (count($q['options']) < 2)
            $errors["$p.options"] = __('Une question QCM necessite au moins 2 assertions.');
        $good = 0;
        $seen = [];
        foreach ($q['options'] as $j => $o) {
            if (blank(trim((string) $o['option_text'])))
                $errors["$p.options.$j.option_text"] = __('Le texte de l assertion est obligatoire.');
            $n = $this->norm($o['option_text']);
            if ($n && isset($seen[$n]))
                $errors["$p.options.$j.option_text"] = __('Assertion dupliquee dans la meme question.');
            $seen[$n] = true;
            if ($o['is_correct'])
                $good++;
        }
        if ($good < 1)
            $errors["$p.options_correct"] = __('Selectionne au moins une bonne reponse.');
        if (!$q['allow_multiple'] && $good > 1)
            $errors["$p.allow_multiple"] = __('Le mode reponse unique autorise une seule bonne reponse.');
    }

    private function qi(string $uuid): ?int
    {
        foreach ($this->questions as $i => $q)
            if (($q['uuid'] ?? null) === $uuid)
                return $i;
        return null;
    }
    private function oi(int $q, string $uuid): ?int
    {
        foreach ($this->questions[$q]['options'] ?? [] as $i => $o)
            if (($o['uuid'] ?? null) === $uuid)
                return $i;
        return null;
    }
    private function norm(string $t): string
    {
        return preg_replace('/\s+/', ' ', trim(mb_strtolower($t))) ?? '';
    }

    public function isDuplicateInPhase(string $qUuid): bool
    {
        $idx = $this->qi($qUuid);
        if ($idx === null) {
            return false;
        }

        $current = $this->questions[$idx];
        $currentId = $current['id'] ?? null;
        $currentKey = ($current['category_question_id'] ?? 'x') . '|' . $this->norm((string) ($current['question_text'] ?? ''));

        foreach ($this->questions as $i => $q) {
            if ($i === $idx || empty($q['is_validated'])) {
                continue;
            }

            if ($currentId && !empty($q['id']) && (int) $q['id'] === (int) $currentId) {
                return true;
            }

            $otherKey = ($q['category_question_id'] ?? 'x') . '|' . $this->norm((string) ($q['question_text'] ?? ''));
            if ($currentKey !== 'x|' && $currentKey === $otherKey) {
                return true;
            }
        }

        return false;
    }
    private function isMathCategory($categoryId): bool
    {
        if (!$categoryId) {
            return false;
        }

        foreach ($this->categories as $cat) {
            if ((int) ($cat['id'] ?? 0) !== (int) $categoryId) {
                continue;
            }

            $name = mb_strtolower(trim((string) ($cat['name'] ?? '')));
            return in_array($name, ['maths', 'math', 'mathematiques', 'mathematique'], true);
        }

        return false;
    }
    private function passesCategoryFilter(array $question): bool
    {
        if ($this->filterCategoryId === '') {
            return true;
        }

        return (int) ($question['category_question_id'] ?? 0) === (int) $this->filterCategoryId;
    }
    private function canShowGlobalAddButton(): bool
    {
        if (is_null($this->editingQuestionUuid)) {
            return true;
        }

        $idx = $this->qi($this->editingQuestionUuid);
        if ($idx === null || !isset($this->questions[$idx])) {
            return true;
        }

        return !$this->passesCategoryFilter($this->questions[$idx]);
    }
    private function reindexQuestions(): void
    {
        foreach ($this->questions as $i => &$q)
            $q['position'] = $i;
    }
    private function reindexOptions(int $q): void
    {
        foreach ($this->questions[$q]['options'] as $i => &$o)
            $o['position'] = $i;
    }

    private function swapQ(string $qUuid, int $delta): void
    {
        $i = $this->qi($qUuid);
        if ($i === null)
            return;
        $j = $i + $delta;
        if (!isset($this->questions[$j]))
            return;
        [$this->questions[$i], $this->questions[$j]] = [$this->questions[$j], $this->questions[$i]];
        $this->reindexQuestions();
        $this->dispatch('focus-question-after-move', questionUuid: $qUuid);
    }

    public function syncQuestionOrder(array $orderedUuids): void
    {
        if (empty($orderedUuids) || count($orderedUuids) !== count($this->questions)) {
            return;
        }

        $map = [];
        foreach ($this->questions as $q) {
            $map[$q['uuid']] = $q;
        }

        $reordered = [];
        foreach ($orderedUuids as $uuid) {
            if (!isset($map[$uuid])) {
                return;
            }
            $reordered[] = $map[$uuid];
        }

        $this->questions = $reordered;
        $this->reindexQuestions();
    }

    private function swapO(string $qUuid, string $oUuid, int $delta): void
    {
        $q = $this->qi($qUuid);
        if ($q === null)
            return;
        $i = $this->oi($q, $oUuid);
        if ($i === null)
            return;
        $j = $i + $delta;
        if (!isset($this->questions[$q]['options'][$j]))
            return;
        [$this->questions[$q]['options'][$i], $this->questions[$q]['options'][$j]] = [$this->questions[$q]['options'][$j], $this->questions[$q]['options'][$i]];
        $this->reindexOptions($q);
        $this->dispatch('focus-option-after-move', questionUuid: $qUuid, optionUuid: $oUuid);
    }
};
?>

<div class="mx-auto px-4 md:px-6 py-6 max-w-5xl">
    <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-3 mb-5">
        <div>
            <h1 class="font-semibold text-gray-900 dark:text-gray-100 text-xl">{{ __('Gestion des questions') }}</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $currentEdition->name }}</p>
            <p class="mt-1 text-gray-600 dark:text-gray-300 text-sm">
                {{ __('Total questions de la phase') }}: <span class="font-semibold">{{ $this->phaseQuestionsCount() }}</span>
            </p>
        </div>
        <div class="flex sm:flex-row flex-col items-stretch sm:items-center gap-2">
            <select wire:model.live="filterCategoryId"
                class="bg-white dark:bg-gray-900 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-[#ff1453]/30 focus:ring-2 text-gray-900 dark:text-gray-100 text-sm">
                <option value="">{{ __('Toutes les categories') }}</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                @endforeach
            </select>
            @if ($this->hasUnsavedChanges())
                <button wire:click="saveAll"
                    class="inline-flex justify-center items-center bg-[#ff1453] hover:bg-[#ff1453]/90 px-4 py-2 rounded-lg focus:outline-none focus:ring-[#ff1453]/50 focus:ring-4 font-medium text-white text-sm hover:scale-105 active:scale-95 transition-all duration-200">
                    {{ __('Enregistrer') }}
                </button>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div
            class="bg-green-50 dark:bg-green-900/20 mb-4 p-3 border border-green-200 dark:border-green-800 rounded-lg text-green-700 dark:text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $filteredQuestionIndexes = [];
        foreach ($questions as $idx => $_q) {
            if ($this->passesCategoryFilter($_q)) {
                $filteredQuestionIndexes[] = $idx;
            }
        }
    @endphp
    <div x-data x-on:click.outside="$wire.cancelEditing()">
        <div class="space-y-4 js-list" data-drag-scope="questions">
            @foreach ($filteredQuestionIndexes as $qIndex)
                @php
                    $question = $questions[$qIndex];
                    $isEditing = ($question['uuid'] === $editingQuestionUuid);
                    $isDuplicate = $this->isDuplicateInPhase($question['uuid']);
                @endphp
                <article wire:key="question-card-{{ $question['uuid'] }}" data-question-uuid="{{ $question['uuid'] }}"
                class="js-item is-idle bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden {{ !$isEditing && !empty($question['is_validated']) ? 'cursor-pointer transition transform duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:border-cyan-500/60 dark:hover:border-cyan-400/60 hover:bg-gray-50 dark:hover:bg-gray-700' : '' }}"
                @if (!$isEditing && !empty($question['is_validated'])) wire:click="startEditing('{{ $question['uuid'] }}')"
                @endif>
                <div class="bg-gray-50 dark:bg-gray-900/40 px-4 py-3 border-gray-200 dark:border-gray-700 border-b">
                    <div class="flex justify-between items-center">
                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">{{ __('Question') }}
                            {{ $qIndex + 1 }}
                        </p>
                        <div class="flex items-center gap-2">
                            <button type="button" wire:click.stop
                                class="inline-flex justify-center items-center rounded w-7 h-7 text-gray-500 dark:text-gray-300 cursor-grab active:cursor-grabbing js-drag-handle"
                                title="{{ __('Reordonner') }}">
                                <span class="text-sm leading-none">&#x283F;</span>
                            </button>
                            @if(!empty($question['is_validated']))
                                <span
                                    class="bg-green-100 dark:bg-green-900/40 px-2 py-1 rounded text-green-700 dark:text-green-300 text-xs">{{ __('Validée') }}</span>
                            @endif
                            @if($isDuplicate)
                                <span
                                    class="bg-amber-100 dark:bg-amber-900/40 px-2 py-1 rounded text-amber-700 dark:text-amber-300 text-xs">{{ __('Doublon dans la phase') }}</span>
                            @endif
                            <button wire:click.stop="moveQuestionUp('{{ $question['uuid'] }}')"
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-200 text-xs hover:scale-105 active:scale-95 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </button>
                            <button wire:click.stop="moveQuestionDown('{{ $question['uuid'] }}')"
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-200 text-xs hover:scale-105 active:scale-95 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                </svg>
                            </button>
                            <button wire:click.stop="duplicateQuestion('{{ $question['uuid'] }}')"
                                class="hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-200 text-xs hover:scale-105 active:scale-95 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="duplicate">
                                        <g id="duplicate_2">
                                            <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                class="w-5 h-5 text-gray-700 dark:text-gray-200"
                                                d="M29.2827 4.88487C28.7191 4.31826 27.954 4 27.1556 4H14.9996C13.3433 4 11.9996 5.34372 11.9996 7V37C11.9996 38.6563 13.3433 40 14.9996 40H31.9992V41C31.9992 41.5526 31.5521 42 30.9992 42H10.9992C10.4475 42 9.99921 41.5517 9.99921 41V9C9.99921 8.44772 9.55149 8 8.99921 8C8.44692 8 7.99921 8.44772 7.99921 9V41C7.99921 42.6563 9.34292 44 10.9992 44H30.9992C32.657 44 33.9992 42.6568 33.9992 41V40H34.9996C36.6574 40 37.9996 38.6568 37.9996 37V17.0162H39.0226C39.5749 17.0162 40.0226 16.5685 40.0226 16.0162C40.0226 15.4639 39.5749 15.0162 39.0226 15.0162H37.9996V14.888C37.9996 14.0969 37.6859 13.3381 37.1285 12.7747L29.2827 4.88487ZM27.0266 15.0162H35.9996V14.888C35.9996 14.6251 35.8947 14.3713 35.7085 14.1831L27.8646 6.29523C27.6764 6.10599 27.4216 6 27.1556 6H14.9996C14.4479 6 13.9996 6.44828 13.9996 7V37C13.9996 37.5517 14.4479 38 14.9996 38H34.9996C35.5525 38 35.9996 37.5526 35.9996 37V17.0162H26.2286C25.5662 17.0162 25.0266 16.4803 25.0266 15.8162V8.9482C25.0266 8.39592 25.4743 7.9482 26.0266 7.9482C26.5789 7.9482 27.0266 8.39592 27.0266 8.9482V15.0162Z"
                                                fill="currentColor" />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <button wire:click.stop="removeQuestion('{{ $question['uuid'] }}')"
                                class="hover:bg-red-50 dark:hover:bg-red-900/30 px-2 py-1 border border-red-300 dark:border-red-700 rounded text-red-600 dark:text-red-300 text-xs hover:scale-105 active:scale-95 transition-all duration-200">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="hidden px-4 py-3 text-gray-900 dark:text-gray-100 text-sm question-compact-text">
                    {{ $question['question_text'] ?: __('Question sans texte') }}
                </div>

                <div
                    class="question-detail {{ (!$isEditing && !empty($question['is_validated'])) ? 'max-h-[1200px] opacity-100' : 'max-h-0 opacity-0 pointer-events-none' }} overflow-hidden transition-all duration-300 ease-in-out">
                    <div class="p-4">
                        <p class="text-gray-900 dark:text-gray-100 text-sm">{{ $question['question_text'] }}</p>
                        <ul class="space-y-2 mt-3">
                            @foreach ($question['options'] as $option)
                                <li class="flex items-center gap-2 text-sm">
                                    <span
                                        class="inline-flex justify-center items-center border rounded-full w-5 h-5 text-xs {{ !empty($option['is_correct']) ? 'border-green-500 text-green-600 dark:text-green-300 dark:border-green-400' : 'border-gray-400 text-gray-500 dark:text-gray-300 dark:border-gray-500' }}">
                                        @if(!empty($option['is_correct']))&#10003;@else&#10005;@endif
                                    </span>
                                    <span
                                        class="{{ !empty($option['is_correct']) ? 'font-medium text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-200' }}">
                                        {{ $option['option_text'] }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-3 text-gray-500 dark:text-gray-400 text-xs">
                            {{ __('Cliquez pour modifier cette question') }}
                        </p>
                    </div>
                </div>

                <div
                    class="question-detail {{ $isEditing ? 'max-h-[2600px] opacity-100' : 'max-h-0 opacity-0 pointer-events-none' }} overflow-hidden transition-all duration-300 ease-in-out">
                    <div class="p-4">
                        <div class="gap-3 grid grid-cols-1 md:grid-cols-2 mb-3">
                            <div>
                                <label
                                    class="block mb-1 text-gray-700 dark:text-gray-300 text-xs">{{ __('Categorie') }}</label>
                                <select wire:model.live="questions.{{ $qIndex }}.category_question_id"
                                    class="bg-white dark:bg-gray-900 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-[#ff1453]/30 focus:ring-2 w-full text-gray-900 dark:text-gray-100 text-sm">
                                    <option value="">{{ __('Choisir') }}</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat['id'] }}">
                                            {{ $cat['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("questions.$qIndex.category_question_id") <p
                                class="mt-1 text-red-600 dark:text-red-400 text-xs">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label
                                    class="block mb-1 text-gray-700 dark:text-gray-300 text-xs">{{ __('Points') }}</label>
                                <input type="number" min="1" wire:model.live="questions.{{ $qIndex }}.ponderation"
                                    class="bg-white dark:bg-gray-900 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-[#ff1453]/30 focus:ring-2 w-full text-gray-900 dark:text-gray-100 text-sm">
                                @error("questions.$qIndex.ponderation") <p
                                    class="mt-1 text-red-600 dark:text-red-400 text-xs">
                                    {{ $message }}
                                </p> @enderror
                            </div>
                        </div>

                        <div class="relative">
                            <label
                                class="block mb-1 text-gray-700 dark:text-gray-300 text-xs">{{ __('Texte de la question') }}</label>
                            <textarea wire:model.live.debounce.300ms="questions.{{ $qIndex }}.question_text" rows="2"
                                class="bg-white dark:bg-gray-900 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-[#ff1453]/30 focus:ring-2 w-full text-gray-900 dark:text-gray-100 text-sm"
                                placeholder="{{ __('Saisissez la question...') }}"></textarea>
                            @error("questions.$qIndex.question_text") <p
                                class="mt-1 text-red-600 dark:text-red-400 text-xs">
                                {{ $message }}
                            </p> @enderror


                            @if (!empty($questionSuggestions[$question['uuid']] ?? []) && !empty($question['suggestions_enabled']))
                                <div
                                    class="z-20 absolute bg-white dark:bg-gray-900 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg w-full max-h-56 overflow-y-auto">
                                    @foreach ($questionSuggestions[$question['uuid']] as $s)
                                        <button type="button"
                                            wire:click="selectQuestionSuggestion('{{ $question['uuid'] }}', {{ $s['id'] }})"
                                            class="block hover:bg-gray-50 dark:hover:bg-gray-800 px-3 py-2 border-gray-100 dark:border-gray-700 border-b w-full text-left">
                                            <span
                                                class="block text-gray-900 dark:text-gray-100 text-sm">{{ $s['question_text'] }}</span>
                                            <span
                                                class="text-gray-500 dark:text-gray-400 text-xs">{{ __('Question suggeree') }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if($this->isMathCategory($question['category_question_id'] ?? null))
                            <div class="mt-2 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden math-pad">
                                <div
                                    class="flex justify-between items-center bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 border-teal-700/70 dark:border-teal-600/60 border-b text-teal-700 dark:text-teal-300 text-sm">
                                    <span>{{ __('Clavier mathematique') }}</span>
                                    <button type="button" onclick="insertMathToken('+', '{{ $question['uuid'] }}')"
                                        class="hover:bg-gray-200 dark:hover:bg-gray-700 px-2 rounded">+</button>
                                </div>
                                <div class="gap-px grid math-pad-grid grid-cols-5 md:grid-cols-10 bg-gray-300 dark:bg-gray-700">
                                    <button type="button" onclick="insertMathToken('x', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x</button>
                                    <button type="button" onclick="insertMathToken('y', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">y</button>
                                    <button type="button" onclick="insertMathToken('x_n', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x<sub>n</sub></button>
                                    <button type="button" onclick="insertMathToken('x^n', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x<sup>n</sup></button>
                                    <button type="button" onclick="insertMathToken('[ ]', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">[ ]</button>
                                    <button type="button" onclick="insertMathToken('( )', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">( )</button>
                                    <button type="button" onclick="insertMathToken('7', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">7</button>
                                    <button type="button" onclick="insertMathToken('8', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">8</button>
                                    <button type="button" onclick="insertMathToken('9', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">9</button>
                                    <button type="button" onclick="insertMathToken('\u00F7', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&divide;</button>

                                    <button type="button" onclick="insertMathToken('>', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&gt;</button>
                                    <button type="button" onclick="insertMathToken('<', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&lt;</button>
                                    <button type="button" onclick="insertMathToken('\u2265', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&ge;</button>
                                    <button type="button" onclick="insertMathToken('\u2264', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&le;</button>
                                    <button type="button" onclick="insertMathToken('\u2260', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&ne;</button>
                                    <button type="button" onclick="insertMathToken('|x|', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">|x|</button>
                                    <button type="button" onclick="insertMathToken('4', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">4</button>
                                    <button type="button" onclick="insertMathToken('5', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">5</button>
                                    <button type="button" onclick="insertMathToken('6', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">6</button>
                                    <button type="button" onclick="insertMathToken('\u00D7', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&times;</button>

                                    <button type="button" onclick="insertMathToken('\u221A', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&radic;</button>
                                    <button type="button" onclick="insertMathToken('n\u221A', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">n&radic;</button>
                                    <button type="button" onclick="insertMathToken('x^2', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x<sup>2</sup></button>
                                    <button type="button" onclick="insertMathToken('x^n', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x<sup>n</sup></button>
                                    <button type="button" onclick="insertMathToken('log', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">log</button>
                                    <button type="button" onclick="insertMathToken('ln', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">ln</button>
                                    <button type="button" onclick="insertMathToken('1', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">1</button>
                                    <button type="button" onclick="insertMathToken('2', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">2</button>
                                    <button type="button" onclick="insertMathToken('3', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">3</button>
                                    <button type="button" onclick="insertMathToken('-', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">-</button>

                                    <button type="button" onclick="insertMathToken('\u03C0', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&pi;</button>
                                    <button type="button" onclick="insertMathToken('x!', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">x!</button>
                                    <button type="button" onclick="insertMathToken('\u2211', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&sum;</button>
                                    <button type="button" onclick="insertMathToken('\u220F', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">&prod;</button>
                                    <button type="button" onclick="insertMathToken('[x]', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">[x]</button>
                                    <button type="button" onclick="insertMathToken('|x|', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">|x|</button>
                                    <button type="button" onclick="insertMathToken('0', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">0</button>
                                    <button type="button" onclick="insertMathToken('.', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">.</button>
                                    <button type="button" onclick="insertMathToken('=', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">=</button>
                                    <button type="button" onclick="insertMathToken('+', '{{ $question['uuid'] }}')"
                                        class="math-pad-key">+</button>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-2 mt-4">
                            @foreach ($question['options'] as $oIndex => $option)
                                <div class="relative flex items-center gap-2" data-option-uuid="{{ $option['uuid'] }}">
                                    <button type="button"
                                        wire:click="toggleCorrectOption('{{ $question['uuid'] }}', '{{ $option['uuid'] }}')"
                                        class="px-2.5 py-1.5 border rounded-lg text-xs transition-colors duration-200 {{ !empty($option['is_correct']) ? 'bg-green-100 dark:bg-green-900/30 border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/50' : 'bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                        @if(!empty($option['is_correct']))&#10003;@else&#10005;@endif
                                    </button>
                                    <div class="relative flex-1">
                                        <input
                                            wire:model.live.debounce.300ms="questions.{{ $qIndex }}.options.{{ $oIndex }}.option_text"
                                            class="bg-white dark:bg-gray-900 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-[#ff1453]/30 focus:ring-2 w-full text-gray-900 dark:text-gray-100 text-sm"
                                            placeholder="{{ __('Assertion') }} {{ $oIndex + 1 }}">
                                        @error("questions.$qIndex.options.$oIndex.option_text") <p
                                            class="mt-1 text-red-600 dark:text-red-400 text-xs">
                                            {{ $message }}
                                        </p> @enderror
                                        @if (!empty($optionSuggestions[$question['uuid']][$option['uuid']] ?? []) && !empty($question['suggestions_enabled']))
                                            <div
                                                class="z-20 absolute bg-white dark:bg-gray-900 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg w-full max-h-48 overflow-y-auto">
                                                @foreach ($optionSuggestions[$question['uuid']][$option['uuid']] as $s)
                                                    <button type="button"
                                                        wire:click="selectOptionSuggestion('{{ $question['uuid'] }}', '{{ $option['uuid'] }}', {{ $s['id'] }})"
                                                        class="block hover:bg-gray-50 dark:hover:bg-gray-800 px-3 py-2 border-gray-100 dark:border-gray-700 border-b w-full text-gray-900 dark:text-gray-100 text-sm text-left">{{ $s['option_text'] }}</button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button wire:click="moveOptionUp('{{ $question['uuid'] }}', '{{ $option['uuid'] }}')"
                                            class="hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-200 hover:scale-105 active:scale-95 transition-all duration-200">
                                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-200"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                            </svg>
                                        </button>
                                        <button wire:click="moveOptionDown('{{ $question['uuid'] }}', '{{ $option['uuid'] }}')"
                                            class="hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-200 hover:scale-105 active:scale-95 transition-all duration-200">
                                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-200"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                            </svg>
                                        </button>
                                        <button wire:click="removeOption('{{ $question['uuid'] }}', '{{ $option['uuid'] }}')"
                                            class="hover:bg-red-50 dark:hover:bg-red-900/30 px-2 py-1 border border-red-300 dark:border-red-700 rounded text-red-600 dark:text-red-300 hover:scale-105 active:scale-95 transition-all duration-200">
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-300"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            @error("questions.$qIndex.options") <p class="text-red-600 dark:text-red-400 text-xs">
                                {{ $message }}
                            </p> @enderror
                            @error("questions.$qIndex.options_correct") <p class="text-red-600 dark:text-red-400 text-xs">
                                {{ $message }}
                            </p> @enderror
                            <button wire:click="addOption('{{ $question['uuid'] }}')"
                                class="inline-flex items-center text-[#0e7490] hover:text-[#155e75] dark:hover:text-cyan-300 text-sm">+
                                {{ __('Ajouter une assertion') }}</button>
                        </div>

                        <div
                            class="flex flex-wrap items-center gap-5 mt-4 pt-3 border-gray-200 dark:border-gray-700 border-t">
                            <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 text-sm"><input
                                    type="checkbox" wire:model.live="questions.{{ $qIndex }}.allow_multiple"
                                    class="border-gray-300 dark:border-gray-600 rounded focus:ring-[#ff1453] text-[#ff1453]">{{ __('Plusieurs reponses') }}</label>
                            <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 text-sm"><input
                                    type="checkbox" wire:model.live="questions.{{ $qIndex }}.suggestions_enabled"
                                    class="border-gray-300 dark:border-gray-600 rounded focus:ring-[#ff1453] text-[#ff1453]">{{ __('Suggestions') }}</label>
                        </div>
                        @if($isDuplicate)
                            <p class="mt-2 text-amber-600 dark:text-amber-300 text-xs">
                                {{ __('Cette question existe deja dans cette phase. Corrige ou choisis une autre question avant validation.') }}
                            </p>
                        @endif
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" wire:click="cancelEditing('{{ $question['uuid'] }}')"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 text-xs">
                                {{ __('Annuler') }}
                            </button>
                            <button wire:click="validateQuestionAndAdd('{{ $question['uuid'] }}')" @disabled($isDuplicate)
                                class="inline-flex items-center px-3 py-2 rounded-lg text-white text-xs {{ $isDuplicate ? 'bg-gray-400 cursor-not-allowed' : 'bg-cyan-700 hover:bg-cyan-800' }}">
                                {{ __('Valider la question') }}
                            </button>
                        </div>
                    </div>
                </div>
            </article>

                @if ($isEditing)
                    <div wire:key="question-add-after-{{ $question['uuid'] }}" class="py-2 question-add-after">
                        <button wire:click="addQuestionAfter('{{ $question['uuid'] }}')"
                            class="inline-flex items-center font-medium text-[#0e7490] hover:text-[#155e75] dark:hover:text-cyan-300">
                            + {{ __('Ajouter une question') }}
                        </button>
                    </div>
                @endif
            @endforeach
        </div>
        @if (empty($filteredQuestionIndexes))
            <div class="mt-4 text-gray-500 dark:text-gray-400 text-sm">
                {{ __('Aucune question pour cette categorie.') }}
            </div>
        @endif

        @if ($this->canShowGlobalAddButton())
            <div class="mt-5">
                <button wire:click="addQuestion"
                    class="inline-flex items-center font-medium text-[#0e7490] hover:text-[#155e75] dark:hover:text-cyan-300">
                    + {{ __('Ajouter une question') }}
                </button>
            </div>
        @endif
    </div>

    <style>
        .js-list.is-reordering .question-detail,
        .js-list.is-reordering .question-add-after {
            display: none !important;
        }

        .js-list.is-reordering .question-compact-text {
            display: block !important;
        }

        .js-item.is-idle {
            transition: transform .2s ease;
        }

        .js-item.is-draggable {
            z-index: 20;
            cursor: grabbing;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
        }

        .math-pad-grid>button {
            background: #f3f4f6;
            color: #0f766e;
            min-height: 42px;
            font-size: 16px;
            line-height: 1;
            border: 0;
        }

        .dark .math-pad-grid>button {
            background: #111827;
            color: #5eead4;
        }

        .math-pad-grid>button:hover {
            background: #e5e7eb;
        }

        .dark .math-pad-grid>button:hover {
            background: #1f2937;
        }

        .focus-follow {
            animation: focusFollowPulse .8s ease-in-out 1;
        }

        @keyframes focusFollowPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(14, 116, 144, 0.45);
            }

            100% {
                box-shadow: 0 0 0 12px rgba(14, 116, 144, 0);
            }
        }
    </style>

    <script>
        (() => {
            let listContainer = null;
            let draggableItem = null;
            let pointerStartX = 0;
            let pointerStartY = 0;
            let itemsGap = 0;
            let items = [];
            let prevRect = {};

            const getAllItems = () => {
                if (!items.length && listContainer) {
                    items = Array.from(listContainer.querySelectorAll('.js-item'));
                }
                return items;
            };

            const getIdleItems = () => getAllItems().filter(item => item.classList.contains('is-idle'));
            const isItemAbove = item => item.hasAttribute('data-is-above');
            const isItemToggled = item => item.hasAttribute('data-is-toggled');

            function onPointerDown(e) {
                const handle = e.target.closest('.js-drag-handle');
                if (!handle) return;

                listContainer = handle.closest('.js-list');
                draggableItem = handle.closest('.js-item');
                if (!listContainer || !draggableItem) return;

                pointerStartX = e.clientX || e.touches?.[0]?.clientX || 0;
                pointerStartY = e.clientY || e.touches?.[0]?.clientY || 0;

                setItemsGap();
                disablePageScroll();
                initDraggableItem();
                initItemsState();
                prevRect = draggableItem.getBoundingClientRect();
                listContainer.classList.add('is-reordering');

                document.addEventListener('mousemove', onPointerMove);
                document.addEventListener('touchmove', onPointerMove, { passive: false });
            }

            function setItemsGap() {
                const idle = getIdleItems();
                if (idle.length <= 1) { itemsGap = 0; return; }
                const r1 = idle[0].getBoundingClientRect();
                const r2 = idle[1].getBoundingClientRect();
                itemsGap = Math.abs(r1.bottom - r2.top);
            }

            function disablePageScroll() {
                document.body.style.overflow = 'hidden';
                document.body.style.touchAction = 'none';
                document.body.style.userSelect = 'none';
            }

            function enablePageScroll() {
                document.body.style.overflow = '';
                document.body.style.touchAction = '';
                document.body.style.userSelect = '';
            }

            function initItemsState() {
                getIdleItems().forEach((item, i) => {
                    if (getAllItems().indexOf(draggableItem) > i) item.dataset.isAbove = '';
                });
            }

            function initDraggableItem() {
                draggableItem.classList.remove('is-idle');
                draggableItem.classList.add('is-draggable');
            }

            function onPointerMove(e) {
                if (!draggableItem) return;
                e.preventDefault();

                const clientX = e.clientX || e.touches?.[0]?.clientX || 0;
                const clientY = e.clientY || e.touches?.[0]?.clientY || 0;
                const offsetX = clientX - pointerStartX;
                const offsetY = clientY - pointerStartY;

                draggableItem.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
                updateIdleItemsStateAndPosition();
            }

            function updateIdleItemsStateAndPosition() {
                const r = draggableItem.getBoundingClientRect();
                const draggableY = r.top + r.height / 2;

                getIdleItems().forEach((item) => {
                    const itemRect = item.getBoundingClientRect();
                    const itemY = itemRect.top + itemRect.height / 2;
                    if (isItemAbove(item)) {
                        if (draggableY <= itemY) item.dataset.isToggled = '';
                        else delete item.dataset.isToggled;
                    } else {
                        if (draggableY >= itemY) item.dataset.isToggled = '';
                        else delete item.dataset.isToggled;
                    }
                });

                getIdleItems().forEach((item) => {
                    if (isItemToggled(item)) {
                        const direction = isItemAbove(item) ? 1 : -1;
                        item.style.transform = `translateY(${direction * (r.height + itemsGap)}px)`;
                    } else {
                        item.style.transform = '';
                    }
                });
            }

            function onPointerUp(e) {
                if (!draggableItem || !listContainer) return;
                applyNewItemsOrder(e);
                cleanup();
            }

            function applyNewItemsOrder(e) {
                const reorderedItems = [];
                const all = getAllItems();

                all.forEach((item, index) => {
                    if (item === draggableItem) return;
                    if (!isItemToggled(item)) {
                        reorderedItems[index] = item;
                        return;
                    }
                    const newIndex = isItemAbove(item) ? index + 1 : index - 1;
                    reorderedItems[newIndex] = item;
                });

                for (let index = 0; index < all.length; index++) {
                    if (typeof reorderedItems[index] === 'undefined') reorderedItems[index] = draggableItem;
                }

                reorderedItems.forEach(item => listContainer.appendChild(item));
                draggableItem.style.transform = '';

                requestAnimationFrame(() => {
                    const rect = draggableItem.getBoundingClientRect();
                    const yDiff = prevRect.y - rect.y;
                    const currentX = e.clientX || e.changedTouches?.[0]?.clientX || pointerStartX;
                    const currentY = e.clientY || e.changedTouches?.[0]?.clientY || pointerStartY;
                    const offsetX = currentX - pointerStartX;
                    const offsetY = currentY - pointerStartY;
                    draggableItem.style.transform = `translate(${offsetX}px, ${offsetY + yDiff}px)`;
                    requestAnimationFrame(() => unsetDraggableItem());
                });

                syncOrderWithLivewire();
            }

            function syncOrderWithLivewire() {
                const orderedUuids = Array.from(listContainer.querySelectorAll('.js-item'))
                    .map(el => el.getAttribute('data-question-uuid'))
                    .filter(Boolean);

                const wireRoot = listContainer.closest('[wire\\:id]');
                if (!wireRoot || !window.Livewire || typeof window.Livewire.find !== 'function') return;
                const component = window.Livewire.find(wireRoot.getAttribute('wire:id'));
                if (!component || typeof component.call !== 'function') return;
                component.call('syncQuestionOrder', orderedUuids);
            }

            function unsetDraggableItem() {
                if (!draggableItem) return;
                draggableItem.style = null;
                draggableItem.classList.remove('is-draggable');
                draggableItem.classList.add('is-idle');
                draggableItem = null;
            }

            function unsetItemState() {
                getIdleItems().forEach((item) => {
                    delete item.dataset.isAbove;
                    delete item.dataset.isToggled;
                    item.style.transform = '';
                });
            }

            function cleanup() {
                itemsGap = 0;
                items = [];
                unsetItemState();
                unsetDraggableItem();
                enablePageScroll();
                if (listContainer) listContainer.classList.remove('is-reordering');
                listContainer = null;
                prevRect = {};

                document.removeEventListener('mousemove', onPointerMove);
                document.removeEventListener('touchmove', onPointerMove);
            }

            document.addEventListener('mousedown', onPointerDown);
            document.addEventListener('touchstart', onPointerDown, { passive: true });
            document.addEventListener('mouseup', onPointerUp);
            document.addEventListener('touchend', onPointerUp);

            document.addEventListener('livewire:init', () => {
                if (!window.Livewire || typeof window.Livewire.on !== 'function') return;

                const pulse = (el) => {
                    if (!el) return;
                    el.classList.remove('focus-follow');
                    requestAnimationFrame(() => el.classList.add('focus-follow'));
                    setTimeout(() => el.classList.remove('focus-follow'), 900);
                };

                Livewire.on('focus-question-after-move', (event) => {
                    const uuid = event?.questionUuid;
                    if (!uuid) return;
                    const article = document.querySelector(`article[data-question-uuid="${uuid}"]`);
                    if (!article) return;
                    article.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    pulse(article);
                });

                Livewire.on('focus-option-after-move', (event) => {
                    const questionUuid = event?.questionUuid;
                    const optionUuid = event?.optionUuid;
                    if (!questionUuid || !optionUuid) return;
                    const article = document.querySelector(`article[data-question-uuid="${questionUuid}"]`);
                    if (!article) return;
                    const row = article.querySelector(`[data-option-uuid="${optionUuid}"]`);
                    if (!row) return;
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    pulse(row);
                    const input = row.querySelector('input,textarea,button');
                    if (input) input.focus({ preventScroll: true });
                });
            });
        })();
    </script>
</div>
