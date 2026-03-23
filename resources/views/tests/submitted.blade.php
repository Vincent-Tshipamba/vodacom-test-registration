@extends('tests.layout')

@section('content')
    <section class="bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.18),_transparent_42%),linear-gradient(180deg,#eaf7f9_0%,#d9eef2_48%,#d8edf0_100%)] dark:bg-[radial-gradient(circle_at_top,_rgba(20,184,166,0.12),_transparent_38%),linear-gradient(180deg,#08141e_0%,#0f172a_48%,#111827_100%)] min-h-screen">
        <div class="mx-auto px-4 md:px-10 py-10 max-w-5xl">
            <div class="bg-white/90 dark:bg-slate-900/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] border border-white/60 dark:border-slate-800/80 rounded-[28px] overflow-hidden">
                <div class="gap-8 grid lg:grid-cols-[1.05fr_0.95fr] px-5 md:px-8 py-8">
                    <div class="space-y-6 text-slate-700 dark:text-slate-200">
                        <div>
                            <h1 class="font-semibold text-slate-900 dark:text-white text-2xl md:text-3xl">
                                Votre évaluation a été soumise avec succès !
                            </h1>
                        </div>

                        <p class="text-sm md:text-base leading-7">
                            Merci, {{ $applicant->full_name }}. Votre participation a bien été enregistrée. Vous serez recontacté(e) plus tard en fonction de l'issue du processus de sélection.
                        </p>

                        @if (!empty($summary['auto_submitted']))
                            <div class="bg-amber-50/90 dark:bg-amber-950/40 px-5 py-4 border border-amber-200/80 dark:border-amber-900/60 rounded-2xl text-amber-800 dark:text-amber-200 text-sm leading-6">
                                Cette évaluation a été soumise automatiquement.
                            </div>
                        @endif
                    </div>

                    <div class="gap-4 grid sm:grid-cols-2 lg:grid-cols-2">
                        <div class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                            <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Questions répondues</p>
                            <p class="mt-2 font-semibold text-slate-900 dark:text-white text-2xl">{{ $summary['answered_count'] }} / {{ $summary['total_questions'] }}</p>
                        </div>
                        <div class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                            <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Temps utilisé</p>
                            <p class="mt-2 font-semibold text-slate-900 dark:text-white text-2xl">{{ $summary['time_used_label'] }}</p>
                        </div>
                        <div class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                            <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Tentatives de triche</p>
                            <p class="mt-2 font-semibold text-slate-900 dark:text-white text-2xl">{{ $summary['cheating_attempts'] }}</p>
                        </div>
                        <div class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                            <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Date de soumission</p>
                            <p class="mt-2 font-semibold text-slate-900 dark:text-white text-xl">{{ $summary['submitted_at'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        history.pushState(null, '', window.location.href);
        window.addEventListener('popstate', function () {
            history.pushState(null, '', window.location.href);
        });

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
@endsection
