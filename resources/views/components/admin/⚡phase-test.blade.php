<?php

use Livewire\Component;
use App\Models\PhaseTest;
use App\Models\ScholarshipEdition;

new class extends Component {
    public ScholarshipEdition $scholarshipEdition;
    public ?PhaseTest $phaseTest = null;
    public array $fields = [];

    public array $editing = [];

    public array $values = [];

    protected $rules = [
        'phaseTest.duration' => 'nullable|integer|min:1',
        'phaseTest.start_time' => 'nullable',
        'phaseTest.end_time' => 'nullable',
        'phaseTest.total_questions' => 'nullable|integer|min:1',
        'phaseTest.passing_score' => 'nullable|integer|min:0|max:100',
    ];

    public function mount($currentEdition)
    {
        $this->scholarshipEdition = $currentEdition;
        $this->phaseTest = PhaseTest::where('scholarship_edition_id', $currentEdition->id)->first();

        $this->fields = [
            'duration' => [
                'label' => __('test.duration'),
                'type' => 'number',
                'icon' => 'duration-icon',
            ],
            'start_time' => [
                'label' => __('test.start_time'),
                'type' => 'datetime-local',
                'icon' => 'start-time-icon',
            ],
            'end_time' => [
                'label' => __('test.end_time'),
                'type' => 'datetime-local',
                'icon' => 'end-time-icon',
            ],
            'total_questions' => [
                'label' => __('test.total_questions'),
                'type' => 'number',
                'icon' => 'questions-icon',
            ],
            'passing_score' => [
                'label' => __('test.passing_score'),
                'type' => 'number',
                'icon' => 'score-icon',
            ],
        ];

        foreach ($this->fields as $field => $data) {
            $this->editing[$field] = false;
            $this->values[$field] = $this->phaseTest?->$field;
        }
    }

    public function edit(string $field)
    {
        $this->editing[$field] = true;
        $this->values[$field] = $this->phaseTest?->$field;
    }

    public function cancel(string $field)
    {
        $this->editing[$field] = false;
    }

    public function save(string $field)
    {
        if (!$this->phaseTest) {
            $this->phaseTest = PhaseTest::create([
                'scholarship_edition_id' => $this->scholarshipEdition->id,
                $field => $this->values[$field],
            ]);
        } else {
            $this->phaseTest->update([
                $field => $this->values[$field],
            ]);
        }

        $this->editing[$field] = false;
    }
};
?>

<div class="">
    <div class="flex flex-col justify-center gap-2 my-auto py-6 w-full">
        <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
            <div class="w-full">
                <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-white">
                    <div class="flex space-x-4 py-3">
                        <dt class="flex items-center space-x-2 mb-1 text-gray-500 md:text-md dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="size-4" style="margin-right: 0.5rem;">
                                <path fill-rule="evenodd"
                                    d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M2 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm6.585 1.08a.75.75 0 0 1 .336 1.005l-1.75 3.5a.75.75 0 0 1-1.16.234l-1.75-1.5a.75.75 0 0 1 .977-1.139l1.02.875 1.321-2.64a.75.75 0 0 1 1.006-.336Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('test.status_phase') }} :
                        </dt>
                        <dd class="font-semibold md:text-md text-sm">
                            @if ($phaseTest)
                                {{ __("db_values.phase_status.$phaseTest->status") }}
                            @else
                                {{ __('db_values.phase_status.AWAITING') }}
                            @endif
                        </dd>
                    </div>
                    @foreach ($fields as $field => $data)
                        <div class="flex space-x-4 py-3">
                            <dt class="flex items-center space-x-2 mb-1 text-gray-500 md:text-md dark:text-gray-400">
                                <x-icon :name="$data['icon']" />
                                <span>
                                    {{ $data['label'] }} :
                                </span>
                            </dt>
                            <dd class="font-semibold md:text-md text-sm">
                                @if (!$editing[$field])
                                    <div class="flex items-center space-x-2">
                                        <span>
                                            {{ $phaseTest?->$field }}
                                        </span>

                                        <button wire:click="edit('{{ $field }}')"
                                            class="text-blue-600 text-sm hover:underline">
                                            ✏️ {{ $phaseTest?->$field ? __('test.modify') : __('test.define') }}
                                        </button>
                                    </div>
                                @else
                                    <div wire:loading.class="opacity-50" wire:target="save, cancel" class="flex items-center space-x-2">
                                        <input type="{{ $data['type'] }}" wire:model.defer="values.{{ $field }}"
                                            class="bg-transparent px-2 py-1 border border-x-0 border-t-0 border-b rounded focus:outline-none focus:ring-0 w-full text-gray-800 dark:text-gray-300 transition-all duration-200 ease-in-out">

                                        <button wire:click="save('{{ $field }}')"
                                            class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-white text-sm">
                                            {{ __('test.save') }}
                                        </button>

                                        <button wire:click="cancel('{{ $field }}')"
                                            class="text-gray-500 hover:text-gray-700 text-sm">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</div>
