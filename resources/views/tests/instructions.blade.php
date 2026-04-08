@extends('tests.layout')

@section('content')
    <section id="evaluationUser"
        class="bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.18),_transparent_42%),linear-gradient(180deg,#eaf7f9_0%,#d9eef2_48%,#d8edf0_100%)] dark:bg-[radial-gradient(circle_at_top,_rgba(20,184,166,0.12),_transparent_38%),linear-gradient(180deg,#08141e_0%,#0f172a_48%,#111827_100%)] min-h-screen select-none">
        @if (!$examStarted)
            <div class="mx-auto px-4 md:px-10 py-10 max-w-5xl">
                @if (session('error'))
                    <div
                        class="bg-red-50/90 dark:bg-red-950/40 mb-6 px-5 py-4 border border-red-200/70 dark:border-red-900/50 rounded-2xl text-red-700 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <div
                    class="bg-white/90 dark:bg-slate-900/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] border border-white/60 dark:border-slate-800/80 rounded-[28px] overflow-hidden">

                    <div class="gap-8 grid lg:grid-cols-[1.15fr_0.85fr] px-5 md:px-8 py-8">
                        <div class="space-y-6 text-slate-700 dark:text-slate-200">
                            <div>
                                <h1 class="font-semibold text-slate-900 dark:text-white text-2xl md:text-3xl">
                                    {{ $phaseTest->description ?: 'Test de sélection Bourse Vodacom' }}
                                </h1>
                            </div>

                            <p class="text-sm md:text-base leading-7">
                                Cette évaluation vise à mesurer tes connaissances et tes capacités de
                                raisonnement
                                à travers plusieurs disciplines, notamment le français, l'anglais, les
                                mathématiques,
                                la biologie, la physique, la chimie et les tests psychotechniques.
                                Elle permet d'évaluer ton niveau global et ton aptitude à intégrer le programme
                                concerné.
                            </p>

                            <div class="gap-4 grid sm:grid-cols-2">
                                <div
                                    class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                                    <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Duree</p>
                                    <p class="mt-2 font-semibold text-slate-900 dark:text-white text-xl">
                                        {{ (int) $phaseTest->duration }} min
                                    </p>
                                </div>
                                <div
                                    class="bg-slate-50/80 dark:bg-slate-950/40 px-5 py-4 border border-slate-200/70 dark:border-slate-800 rounded-2xl">
                                    <p class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.2em]">Candidat
                                    </p>
                                    <p class="mt-2 font-semibold text-slate-900 dark:text-white text-xl">
                                        {{ $applicant->full_name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-[linear-gradient(180deg,rgba(13,148,136,0.08),rgba(255,255,255,0))] dark:bg-[linear-gradient(180deg,rgba(20,184,166,0.12),rgba(15,23,42,0))] px-5 py-6 border border-slate-200/70 dark:border-slate-800 rounded-[24px] text-slate-700 dark:text-slate-200">
                            <h2 class="font-semibold text-slate-900 dark:text-white text-lg">Consignes importantes</h2>
                            <ul class="space-y-3 mt-4 text-sm leading-6 list-disc">
                                <li>
                                    Dès que tu démarres l'évaluation, le compte à rebours se lance automatiquement.
                                    L'évaluation se termine automatiquement lorsque le temps imparti expire.
                                </li>
                                <li>
                                    Toute perte de focus de la fenêtre d'examen est enregistrée comme tentative de tricherie.
                                    Après 3 tentatives, l'évaluation est soumise automatiquement.
                                </li>
                                <li>
                                    Assure-toi d'avoir répondu à toutes les questions et d'avoir soumis tes
                                    réponses avant de quitter la page d'évaluation.
                                </li>
                            </ul>

                            <form action="{{ route('scholarship.exam.start', app()->getLocale()) }}" method="POST" class="mt-8">
                                @csrf
                                <button type="submit"
                                    class="inline-flex justify-center items-center gap-2 bg-[#ff1453] hover:bg-[#e0114a] px-5 py-3 rounded-2xl focus:outline-none focus:ring-[#ff1453]/20 focus:ring-4 w-full font-semibold text-white transition">
                                    Démarrer l'évaluation
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M2 10a.75.75 0 0 1 .75-.75h11.69L10.22 5.03a.75.75 0 0 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H2.75A.75.75 0 0 1 2 10Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mx-auto px-3 md:px-6 py-4 md:py-6 max-w-7xl" id="exam-app">
                <div
                    class="top-0 z-30 sticky bg-white/90 dark:bg-slate-900/90 shadow-[0_16px_48px_rgba(15,23,42,0.16)] backdrop-blur mb-5 px-4 md:px-6 py-3 border border-white/70 dark:border-slate-800/80 rounded-[26px]">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="bg-slate-200 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                                    <div id="timer-progress"
                                        class="bg-gradient-to-r from-teal-600 to-cyan-500 rounded-full h-full transition-all duration-700"
                                        style="width:100%"></div>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-2 md:gap-3 bg-slate-50 dark:bg-slate-950/50 px-3 md:px-4 py-1 rounded-2xl shrink-0">
                                <p id="timer-label"
                                    class="font-semibold tabular-nums text-slate-900 dark:text-white text-lg md:text-2xl">00:00</p>
                                <div
                                    class="flex justify-center items-center border border-slate-200 dark:border-slate-700 rounded-full w-7 md:w-9 h-7 md:h-9 text-slate-500 dark:text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" class="w-5 md:w-6 h-5 md:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-wrap justify-between items-center gap-3 mt-4 text-slate-600 dark:text-slate-300 text-sm">
                        <div>Question <span id="current-question-number"
                                class="font-semibold text-slate-900 dark:text-white">1</span> / <span
                                id="total-question-count">{{ count($examQuestions) }}</span></div>
                        <div>Répondues : <span id="answered-count" class="font-semibold text-slate-900 dark:text-white">0</span>
                        </div>
                    </div>
                </div>

                <div id="warning-banner"
                    class="hidden bg-amber-50/90 dark:bg-amber-950/40 mb-5 px-5 py-4 border border-amber-200/80 dark:border-amber-900/60 rounded-2xl text-amber-800 dark:text-amber-200 text-sm">
                </div>

                <div class="gap-5 grid xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div
                        class="bg-white/90 dark:bg-slate-900/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] px-4 md:px-8 py-6 border border-white/70 dark:border-slate-800/80 rounded-[28px]">
                        <div class="flex flex-wrap justify-between items-center gap-4">
                            <div>
                                <p id="question-category"
                                    class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-[0.22em]"></p>
                                <div id="question-text"
                                    class="mt-2 font-semibold text-slate-900 dark:text-white text-xl md:text-2xl leading-8">
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full font-semibold text-slate-600 dark:text-slate-300 text-xs">
                                Point(s) : <span id="question-points" class="ml-1"></span>
                            </span>
                        </div>

                        <div id="question-options" class="space-y-4 mt-8"></div>

                        <div
                            class="flex sm:flex-row flex-col sm:justify-between sm:items-center gap-4 mt-8 pt-6 border-slate-200/80 dark:border-slate-800 border-t">
                            <div class="flex items-center gap-3">
                                <button type="button" id="prev-question"
                                    class="inline-flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-2xl font-medium text-slate-700 dark:text-slate-200 text-sm transition disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M11.78 14.78a.75.75 0 0 1-1.06 0l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 1 1 1.06 1.06L8.06 10l3.72 3.72a.75.75 0 0 1 0 1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Précédent
                                </button>
                                <button type="button" id="next-question"
                                    class="inline-flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-2xl font-medium text-slate-700 dark:text-slate-200 text-sm transition disabled:cursor-not-allowed">
                                    Suivant
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <form id="exam-submit-form" action="{{ route('scholarship.exam.submit', app()->getLocale()) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="current_index" id="submit-current-index"
                                    value="{{ $currentQuestionIndex }}">
                                <input type="hidden" name="auto_submitted" id="submit-auto-submitted" value="0">
                                <button type="submit" id="submit-exam-button"
                                    class="inline-flex justify-center items-center gap-2 bg-[#ff1453] hover:bg-[#e0114a] px-5 py-3 rounded-2xl focus:outline-none focus:ring-[#ff1453]/20 focus:ring-4 w-full sm:w-auto font-semibold text-white transition">
                                    Soumettre l'évaluation
                                </button>
                            </form>
                        </div>
                    </div>

                    <aside class="space-y-5">
                        <div
                            class="bg-white/90 dark:bg-slate-900/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] p-5 border border-white/70 dark:border-slate-800/80 rounded-[26px]">
                            <div class="flex justify-between items-center gap-3">
                                <h3
                                    class="font-semibold text-slate-500 dark:text-slate-400 text-sm uppercase tracking-[0.22em]">
                                    Navigation</h3>
                                <span class="text-slate-500 dark:text-slate-400 text-xs">Clique sur un numéro</span>
                            </div>
                            <div id="question-nav" class="gap-2 grid grid-cols-5 sm:grid-cols-8 xl:grid-cols-5 mt-4"></div>
                        </div>

                        <div
                            class="bg-white/90 dark:bg-slate-900/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] p-5 border border-white/70 dark:border-slate-800/80 rounded-[26px] text-slate-600 dark:text-slate-300 text-sm">
                            <h3 class="font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-[0.22em]">
                                Surveillance</h3>
                            <p class="mt-4 leading-6">Tentatives détectées: <span id="violation-count"
                                    class="font-semibold text-slate-900 dark:text-white">{{ $violationCount }}</span> /
                                {{ $maxViolations }}
                            </p>
                            <p class="mt-2 leading-6">Ne réduis pas la fenêtre et ne change pas d'onglet. Au maximum
                                autorisé, tout est soumis automatiquement.</p>
                        </div>
                    </aside>
                </div>

                <div id="violation-modal" class="hidden z-50 fixed inset-0 justify-center items-center bg-slate-950/55 px-4">
                    <div
                        class="bg-white dark:bg-slate-900 shadow-2xl p-6 border border-slate-200/80 dark:border-slate-800 rounded-[28px] w-full max-w-md">
                        <h3 class="font-semibold text-slate-900 dark:text-white text-lg">Attention</h3>
                        <p id="violation-modal-message" class="mt-3 text-slate-600 dark:text-slate-300 text-sm leading-6"></p>
                        <div class="flex justify-end mt-6">
                            <button type="button" id="close-violation-modal"
                                class="bg-[#ff1453] hover:bg-[#e0114a] px-4 py-2 rounded-2xl font-medium text-white transition">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

<style>
    #question-text p,
    #question-text div,
    .rich-render p,
    .rich-render div {
        margin: 0 0 0.5rem;
    }

    #question-text ul,
    #question-text ol,
    .rich-render ul,
    .rich-render ol {
        margin: 0.5rem 0 0.5rem 1.25rem;
        padding: 0;
    }

    #question-text,
    .rich-render {
        white-space: break-spaces;
    }

    #question-text ul,
    .rich-render ul {
        list-style: disc;
    }

    #question-text ol,
    .rich-render ol {
        list-style: decimal;
    }
</style>

@section('script')
    @if ($examStarted)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const examState = {
                    questions: @json($examQuestions),
                    currentIndex: {{ $currentQuestionIndex }},
                    violationCount: {{ $violationCount }},
                    maxViolations: {{ $maxViolations }},
                    saveUrl: @json(route('scholarship.exam.save', app()->getLocale())),
                    violationUrl: @json(route('scholarship.exam.violation', app()->getLocale())),
                    redirectUrl: @json(route('scholarship.test', app()->getLocale())),
                    endsAt: @json($examMeta['ends_at']),
                    startedAt: @json($examMeta['started_at']),
                    submitting: false,
                    countdownInterval: null,
                    saveTimeout: null,
                    lastViolationAt: 0,
                };

                const els = {
                    warningBanner: document.getElementById('warning-banner'),
                    timerLabel: document.getElementById('timer-label'),
                    timerProgress: document.getElementById('timer-progress'),
                    currentQuestionNumber: document.getElementById('current-question-number'),
                    answeredCount: document.getElementById('answered-count'),
                    questionCategory: document.getElementById('question-category'),
                    questionText: document.getElementById('question-text'),
                    questionPoints: document.getElementById('question-points'),
                    questionOptions: document.getElementById('question-options'),
                    questionNav: document.getElementById('question-nav'),
                    prevQuestion: document.getElementById('prev-question'),
                    nextQuestion: document.getElementById('next-question'),
                    submitCurrentIndex: document.getElementById('submit-current-index'),
                    submitAutoSubmitted: document.getElementById('submit-auto-submitted'),
                    examSubmitForm: document.getElementById('exam-submit-form'),
                    submitExamButton: document.getElementById('submit-exam-button'),
                    violationCount: document.getElementById('violation-count'),
                    violationModal: document.getElementById('violation-modal'),
                    violationModalMessage: document.getElementById('violation-modal-message'),
                    closeViolationModal: document.getElementById('close-violation-modal'),
                };

                function currentQuestion() {
                    return examState.questions[examState.currentIndex] || { options: [] };
                }

                function answeredCount() {
                    return examState.questions.filter((question) => !!question.selected_option_id).length;
                }

                function setWarning(message) {
                    if (!message) {
                        els.warningBanner.classList.add('hidden');
                        els.warningBanner.textContent = '';
                        return;
                    }

                    els.warningBanner.textContent = message;
                    els.warningBanner.classList.remove('hidden');
                }

                function renderOptions() {
                    const question = currentQuestion();
                    els.questionOptions.innerHTML = '';

                    question.options.forEach((option, optionIndex) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'group flex w-full items-start gap-4 rounded-2xl border px-4 py-4 text-left transition duration-200';

                        const isSelected = question.selected_option_id === option.id;
                        if (isSelected) {
                            button.classList.add('border-teal-500', 'bg-teal-50', 'dark:border-teal-500', 'dark:bg-teal-500/10');
                        } else {
                            button.classList.add('border-slate-200', 'dark:border-slate-800', 'bg-slate-50/70', 'dark:bg-slate-950/40', 'hover:border-slate-300', 'dark:hover:border-slate-700');
                        }

                        const letter = document.createElement('span');
                        letter.className = 'mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold';
                        letter.textContent = String.fromCharCode(65 + optionIndex);
                        if (isSelected) {
                            letter.classList.add('border-teal-500', 'bg-teal-500', 'text-white');
                        } else {
                            letter.classList.add('border-slate-300', 'dark:border-slate-700', 'text-slate-500', 'dark:text-slate-400');
                        }

                        const text = document.createElement('span');
                        text.className = 'rich-render flex-1 text-sm md:text-base leading-7 text-slate-800 dark:text-slate-100';
                        text.innerHTML = option.option_text || '';

                        button.appendChild(letter);
                        button.appendChild(text);
                        button.addEventListener('click', () => {
                            question.selected_option_id = option.id;
                            render();
                            scheduleSave();
                        });

                        els.questionOptions.appendChild(button);
                    });
                }

                function navButtonClass(index) {
                    if (index === examState.currentIndex) {
                        return ['border-teal-500', 'bg-teal-500', 'text-white', 'shadow-[0_12px_30px_rgba(13,148,136,0.32)]'];
                    }

                    if (examState.questions[index] && examState.questions[index].selected_option_id) {
                        return ['border-teal-200', 'dark:border-teal-900', 'bg-teal-50', 'dark:bg-teal-500/10', 'text-teal-700', 'dark:text-teal-300'];
                    }

                    return ['border-slate-200', 'dark:border-slate-800', 'bg-slate-50', 'dark:bg-slate-950/40', 'text-slate-500', 'dark:text-slate-400', 'hover:border-slate-300', 'dark:hover:border-slate-700'];
                }

                function renderNav() {
                    els.questionNav.innerHTML = '';

                    examState.questions.forEach((question, index) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'flex h-11 items-center justify-center rounded-2xl border text-sm font-semibold transition';
                        button.classList.add(...navButtonClass(index));
                        button.textContent = index + 1;
                        button.addEventListener('click', () => goTo(index));
                        els.questionNav.appendChild(button);
                    });
                }

                function render() {
                    const question = currentQuestion();
                    els.currentQuestionNumber.textContent = examState.currentIndex + 1;
                    els.answeredCount.textContent = answeredCount();
                    els.questionCategory.textContent = question.category || 'Question';
                    els.questionText.innerHTML = question.question_text || '';
                    els.questionPoints.textContent = question.ponderation ?? '';
                    els.prevQuestion.disabled = examState.currentIndex === 0;
                    els.nextQuestion.disabled = examState.currentIndex === examState.questions.length - 1;
                    els.submitCurrentIndex.value = examState.currentIndex;
                    els.violationCount.textContent = examState.violationCount;
                    const allAnswered = answeredCount() === examState.questions.length && examState.questions.length > 0;
                    els.submitExamButton.classList.toggle('hidden', !allAnswered);
                    renderOptions();
                    renderNav();
                }

                function goTo(index) {
                    if (index < 0 || index >= examState.questions.length) {
                        return;
                    }

                    examState.currentIndex = index;
                    render();
                    persistCurrentIndex();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

                function updateTimer() {
                    const now = new Date();
                    const end = new Date(examState.endsAt);
                    const start = new Date(examState.startedAt);
                    const totalSeconds = Math.max(1, Math.floor((end.getTime() - start.getTime()) / 1000));
                    const remainingSeconds = Math.max(0, Math.floor((end.getTime() - now.getTime()) / 1000));
                    const minutes = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
                    const seconds = String(remainingSeconds % 60).padStart(2, '0');

                    els.timerLabel.textContent = `${minutes}:${seconds}`;
                    els.timerProgress.style.width = `${Math.min(100, Math.max(0, (remainingSeconds / totalSeconds) * 100))}%`;

                    if (remainingSeconds === 0 && !examState.submitting) {
                        autoSubmit('Le temps est écoulé. Les réponses sont soumises.');
                    }
                }

                async function saveProgress(silent = false) {
                    if (!currentQuestion().id || examState.submitting) {
                        return;
                    }

                    try {
                        const response = await fetch(examState.saveUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                question_phase_test_id: currentQuestion().id,
                                selected_option_id: currentQuestion().selected_option_id,
                                current_index: examState.currentIndex,
                            }),
                        });

                        if (!response.ok) {
                            throw new Error('save_failed');
                        }

                        if (!silent) {
                            setWarning('');
                        }
                    } catch (error) {
                        setWarning("La sauvegarde automatique a échoué. Vérifie ta connexion avant de continuer.");
                    }
                }

                function scheduleSave() {
                    window.clearTimeout(examState.saveTimeout);
                    examState.saveTimeout = window.setTimeout(() => saveProgress(), 180);
                }

                function persistCurrentIndex() {
                    saveProgress(true);
                }

                function showViolationModal(message) {
                    els.violationModalMessage.textContent = message;
                    els.violationModal.classList.remove('hidden');
                    els.violationModal.classList.add('flex');
                }

                function closeViolationModal() {
                    els.violationModal.classList.add('hidden');
                    els.violationModal.classList.remove('flex');
                }

                async function registerViolation() {
                    if (examState.submitting) {
                        return;
                    }

                    const now = Date.now();
                    if (now - examState.lastViolationAt < 1500) {
                        return;
                    }
                    examState.lastViolationAt = now;

                    try {
                        await saveProgress(true);

                        const response = await fetch(examState.violationUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            credentials: 'same-origin',
                            keepalive: true,
                            body: JSON.stringify({ current_index: examState.currentIndex }),
                        });

                        if (!response.ok) {
                            return;
                        }

                        const payload = await response.json();
                        examState.violationCount = payload.count ?? examState.violationCount;
                        render();

                        if (payload.auto_submitted) {
                            examState.submitting = true;
                            showViolationModal("Le nombre maximal de tentatives a été atteint. L'évaluation a été soumise automatiquement.");
                            els.submitAutoSubmitted.value = '1';
                            window.setTimeout(() => {
                                window.location.href = payload.redirect_url || examState.redirectUrl;
                            }, 1800);
                            return;
                        }

                        showViolationModal(`Tentative détectée. Il te reste ${payload.remaining} tentative(s) avant soumission automatique.`);
                    } catch (error) {
                        // anti-cheat tracking must not break the exam UI
                    }
                }

                async function autoSubmit(message) {
                    examState.submitting = true;
                    setWarning(message);
                    els.submitAutoSubmitted.value = '1';
                    await saveProgress(true);
                    els.examSubmitForm.submit();
                }

                function blockBackNavigation() {
                    history.pushState(null, '', window.location.href);
                    window.addEventListener('popstate', function () {
                        history.pushState(null, '', window.location.href);
                    });
                }

                els.prevQuestion.addEventListener('click', () => goTo(examState.currentIndex - 1));
                els.nextQuestion.addEventListener('click', () => goTo(examState.currentIndex + 1));
                els.closeViolationModal.addEventListener('click', closeViolationModal);
                els.examSubmitForm.addEventListener('submit', function () {
                    examState.submitting = true;
                });

                window.addEventListener('pageshow', function (event) {
                    if (event.persisted) {
                        window.location.reload();
                    }
                });

                document.addEventListener('visibilitychange', function () {
                    if (document.hidden) {
                        registerViolation();
                    }
                });

                window.addEventListener('blur', function () {
                    registerViolation();
                });

                examState.countdownInterval = window.setInterval(updateTimer, 1000);
                blockBackNavigation();
                updateTimer();
                render();
                persistCurrentIndex();
            });
        </script>
    @endif
@endsection
