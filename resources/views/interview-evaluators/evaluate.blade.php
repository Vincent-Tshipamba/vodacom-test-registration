@extends('interview-evaluators.layout')

@section('content')
    <section class="bg-white dark:bg-gray-900 min-h-screen">
        <div class="mx-auto px-6 py-8 max-w-6xl">
            <div class="flex md:flex-row flex-col md:justify-between md:items-start gap-4 mb-8">
                <div>
                    <a href="{{ route('evaluator.panel', app()->getLocale()) }}" class="text-gray-500 dark:text-gray-400 text-sm">← Retour a mes candidats</a>
                    <h1 class="mt-3 font-bold text-gray-900 dark:text-white text-3xl">
                        Evaluation de {{ $assignment->interviewSession?->applicant?->full_name ?? 'Candidat' }}
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                        Horaire: {{ optional($assignment->interviewSession?->scheduled_at)->format('d/m/Y H:i') ?? '-' }}
                    </p>
                </div>
                <form method="post" action="{{ route('evaluator.logout', app()->getLocale()) }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-xl text-white text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>

            <livewire:interview-evaluators.evaluate-assignment :assignment="$assignment" />
        </div>
    </section>
@endsection
