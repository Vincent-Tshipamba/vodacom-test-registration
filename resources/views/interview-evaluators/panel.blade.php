@extends('interview-evaluators.layout')

@section('content')
    <section class="bg-white dark:bg-gray-900 min-h-screen">
        <div class="mx-auto px-6 py-8 max-w-6xl">
            <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4 mb-8">
                <div>
                    <h1 class="font-bold text-gray-900 dark:text-white text-3xl">Espace évaluateur</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                        {{ $evaluatorName }}, voici la liste des candidats qui vous sont affectés.
                    </p>
                </div>
                <form method="post" action="{{ route('evaluator.logout', app()->getLocale()) }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-xl text-white text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 mb-6 px-4 py-3 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-neutral-900 shadow-sm border border-gray-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="divide-y divide-gray-200 dark:divide-neutral-800 min-w-full">
                        <thead class="bg-gray-50 dark:bg-neutral-950">
                            <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">Candidat</th>
                                <th class="px-6 py-3 text-left">Code</th>
                                <th class="px-6 py-3 text-left">Horaire</th>
                                <th class="px-6 py-3 text-left">Score soumis</th>
                                <th class="px-6 py-3 text-left">Progression</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-800">
                            @forelse ($assignments as $assignment)
                                @php
                                    $submittedScore = (int) $assignment->scores->sum('score_given');
                                @endphp
                                <tr class="text-sm">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $assignment->interviewSession?->applicant?->full_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $assignment->interviewSession?->applicant?->registration_code ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ optional($assignment->interviewSession?->scheduled_at)->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        @if ($assignment->scores->isNotEmpty())
                                            {{ $submittedScore }} / 100
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $assignment->scores->count() }} note(s)
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($assignment->scores->isNotEmpty())
                                            <span class="inline-flex items-center bg-emerald-100 dark:bg-emerald-900/30 px-4 py-2 rounded-xl text-emerald-700 dark:text-emerald-300 text-sm">
                                                Déjà évalué
                                            </span>
                                        @else
                                            <a href="{{ route('evaluator.evaluate', ['locale' => app()->getLocale(), 'interviewEvaluator' => $assignment]) }}"
                                                class="bg-gray-900 hover:bg-gray-800 dark:bg-white dark:hover:bg-gray-200 px-4 py-2 rounded-xl text-white dark:text-black text-sm">
                                                Evaluer
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-gray-500 dark:text-gray-400 text-center">
                                        Aucune affectation active pour cet évaluateur.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
