<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PhaseTest;
use App\Models\Applicant;
use App\Models\TestSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\CandidateResponse;
use App\Models\QuestionPhaseTest;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\UpdateApplicantRequest;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\EducationalCity;
use App\Models\ScholarshipEdition;
use App\Models\User;

class ApplicantController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function test()
    {
        return view('applicants.authenticate');
    }

    public function authenticateApplicants(Request $request)
    {
        $request->validate([
            'national_exam_code' => 'required|string|max:14|regex:/^\d{14}$/',
            'coupon' => 'required|string|max:10',
        ]);

        $coupon = $request->input('coupon');
        $nationalExamCode = $request->input('national_exam_code');


        $applicant = Applicant::where('national_exam_code', $nationalExamCode)
            ->where('registration_code', $request->input('coupon'))
            ->where('edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->where('application_status', 'SHORTLISTED')
            ->first();

        if ($applicant) {
            Log::info('Applicant authenticated for test : ' . $applicant->first_name . ' ' . $applicant->last_name);

            session(['authenticated_applicant_id' => $applicant->id]);
            Cache::put("used_coupon_{$coupon}", true, 3600);

            $latestSession = $this->getLatestApplicantTestSession($applicant);
            if ($latestSession && $latestSession->finished_at) {
                session(['completed_test_session_id' => $latestSession->id]);
                return redirect()->route('scholarship.exam.submitted', app()->getLocale());
            }

            return redirect()->route('scholarship.instructions', app()->getLocale())
                ->with('success', __('messages.authenticated'));
        }

        return redirect()->back()
            ->with('error', 'Désolé, les informations fournies ne correspondent à aucun candidat éligible.');
    }

    public function instructions()
    {
        $applicant = $this->getAuthenticatedApplicant();

        if (!$applicant) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Votre session d'examen a expiré. Veuillez vous reconnecter.");
        }

        $phaseTest = $this->getCurrentPhaseTest();
        $latestSession = $this->getLatestApplicantTestSession($applicant);

        if (!$phaseTest) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Aucune phase d'evaluation n'est actuellement disponible.");
        }

        if ($phaseTest->status !== 'IN_PROGRESS') {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Cette phase n'est pas encore ouverte aux candidats.");
        }

        if ($windowMessage = $this->phaseWindowErrorMessage($phaseTest)) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', $windowMessage);
        }

        if ($latestSession && $latestSession->finished_at && !session('exam_started')) {
            session()->forget($this->examSessionKeys());
            session(['completed_test_session_id' => $latestSession->id]);

            return redirect()->route('scholarship.exam.submitted', app()->getLocale());
        }

        if (!session('exam_started')) {
            return view('tests.instructions', [
                'examStarted' => false,
                'phaseTest' => $phaseTest,
                'applicant' => $applicant,
            ]);
        }

        $state = $this->buildExamViewState($applicant, $phaseTest);

        if (!$state) {
            session()->forget($this->examSessionKeys());

            return view('tests.instructions', [
                'examStarted' => false,
                'phaseTest' => $phaseTest,
                'applicant' => $applicant,
            ])->with('error', "Impossible de reprendre l'epreuve. Veuillez relancer l'examen.");
        }

        return view('tests.instructions', $state + [
            'examStarted' => true,
            'phaseTest' => $phaseTest,
            'applicant' => $applicant,
            'maxViolations' => 3,
        ]);
    }

    public function submitted()
    {
        $applicant = $this->getAuthenticatedApplicant();

        if (!$applicant) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', 'Votre session a expire. Veuillez vous reconnecter.');
        }

        $testSession = $this->resolveCompletedTestSession($applicant);

        if (!$testSession || !$testSession->finished_at) {
            return redirect()->route('scholarship.instructions', app()->getLocale());
        }

        return view('tests.submitted', [
            'applicant' => $applicant,
            'summary' => $this->buildSubmissionSummary($testSession),
        ]);
    }

    public function startExam(Request $request)
    {
        $applicant = $this->getAuthenticatedApplicant();

        if (!$applicant) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Votre session d'examen a expire. Veuillez vous reconnecter.");
        }

        $phaseTest = $this->getCurrentPhaseTest();

        if (!$phaseTest) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Aucune phase d'evaluation n'est actuellement disponible.");
        }

        if ($phaseTest->status !== 'IN_PROGRESS') {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Cette phase n'est pas encore ouverte aux candidats.");
        }

        if ($windowMessage = $this->phaseWindowErrorMessage($phaseTest)) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', $windowMessage);
        }

        $latestSession = $this->getLatestApplicantTestSession($applicant);
        if ($latestSession && $latestSession->finished_at) {
            session()->forget($this->examSessionKeys());
            session(['completed_test_session_id' => $latestSession->id]);
            return redirect()->route('scholarship.exam.submitted', app()->getLocale());
        }

        $questionPhaseTests = $this->loadPhaseQuestionPhaseTests($phaseTest);
        if ($questionPhaseTests->isEmpty()) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Cette epreuve ne contient encore aucune question.");
        }

        $testSession = TestSession::query()
            ->where('applicant_id', $applicant->id)
            ->whereNull('finished_at')
            ->latest('id')
            ->first();

        if (!$testSession) {
            $testSession = TestSession::create([
                'applicant_id' => $applicant->id,
                'started_at' => now(),
            ]);
        } elseif (!$testSession->started_at) {
            $testSession->started_at = now();
            $testSession->save();
        }

        if (!$request->session()->has('exam_question_order')) {
            $questionOrder = $questionPhaseTests->pluck('id')->shuffle()->values()->all();
            $request->session()->put([
                'exam_started' => true,
                'exam_session_id' => $testSession->id,
                'exam_phase_test_id' => $phaseTest->id,
                'exam_question_order' => $questionOrder,
                'exam_current_index' => 0,
                'exam_started_at' => optional($testSession->started_at)->toIso8601String(),
                'exam_violation_count' => 0,
            ]);
        } else {
            $request->session()->put('exam_started', true);
            $request->session()->put('exam_session_id', $testSession->id);
            $request->session()->put('exam_phase_test_id', $phaseTest->id);
            $request->session()->put('exam_started_at', optional($testSession->started_at)->toIso8601String());
        }

        return redirect()->route('scholarship.instructions', app()->getLocale());
    }

    public function saveExamProgress(Request $request)
    {
        $applicant = $this->getAuthenticatedApplicant();
        $phaseTest = $this->getCurrentPhaseTest();
        $testSession = $this->getActiveExamSession($applicant);

        if (!$applicant || !$phaseTest || !$testSession) {
            return response()->json(['message' => 'Session invalide.'], 419);
        }

        if ($phaseTest->status !== 'IN_PROGRESS' || $this->isPhaseClosed($phaseTest)) {
            if (!$testSession->finished_at) {
                $this->finalizeExam($testSession, $phaseTest, true, (int) $request->session()->get('exam_violation_count', 0));
            }

            return response()->json(['message' => "Cette phase n'est plus accessible."], 422);
        }

        if ($testSession->finished_at) {
            return response()->json(['message' => "L'epreuve est deja terminee."], 422);
        }

        $data = $request->validate([
            'question_phase_test_id' => ['required', 'integer', 'exists:question_phase_tests,id'],
            'selected_option_id' => ['nullable', 'integer', 'exists:answer_options,id'],
            'current_index' => ['nullable', 'integer', 'min:0'],
        ]);

        $questionPhaseTest = QuestionPhaseTest::query()
            ->with('question.answer_options')
            ->where('phase_test_id', $phaseTest->id)
            ->findOrFail($data['question_phase_test_id']);

        $selectedOptionId = $data['selected_option_id'] ?? null;

        if ($selectedOptionId && !$questionPhaseTest->question->answer_options->contains('id', $selectedOptionId)) {
            return response()->json(['message' => 'Assertion invalide pour cette question.'], 422);
        }

        $this->persistExamResponse(
            $request,
            $testSession,
            $questionPhaseTest,
            $selectedOptionId,
            $data['current_index'] ?? null
        );

        $answeredCount = CandidateResponse::query()
            ->where('test_session_id', $testSession->id)
            ->whereNotNull('selected_option_id')
            ->count();

        return response()->json([
            'saved' => true,
            'answered_count' => $answeredCount,
        ]);
    }

    public function registerExamViolation(Request $request)
    {
        $applicant = $this->getAuthenticatedApplicant();
        $phaseTest = $this->getCurrentPhaseTest();
        $testSession = $this->getActiveExamSession($applicant);

        if (!$applicant || !$phaseTest || !$testSession) {
            return response()->json(['message' => 'Session invalide.'], 419);
        }

        if ($phaseTest->status !== 'IN_PROGRESS' || $this->isPhaseClosed($phaseTest)) {
            if (!$testSession->finished_at) {
                $this->finalizeExam($testSession, $phaseTest, true, (int) $request->session()->get('exam_violation_count', 0));
                $request->session()->forget($this->examSessionKeys());
                $request->session()->put('completed_test_session_id', $testSession->id);
            }

            return response()->json([
                'count' => (int) session('exam_violation_count', 0),
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => route('scholarship.exam.submitted', app()->getLocale()),
            ]);
        }

        if ($testSession->finished_at) {
            return response()->json([
                'count' => (int) session('exam_violation_count', 0),
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => route('scholarship.exam.submitted', app()->getLocale()),
            ]);
        }

        $maxViolations = 3;
        $count = ((int) $request->session()->get('exam_violation_count', 0)) + 1;
        $request->session()->put('exam_violation_count', $count);

        if ($count >= $maxViolations) {
            $this->finalizeExam($testSession, $phaseTest, true, $count);
            $request->session()->forget($this->examSessionKeys());
            $request->session()->put('completed_test_session_id', $testSession->id);

            return response()->json([
                'count' => $count,
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => route('scholarship.exam.submitted', app()->getLocale()),
            ]);
        }

        return response()->json([
            'count' => $count,
            'remaining' => max(0, $maxViolations - $count),
            'auto_submitted' => false,
        ]);
    }

    public function submitExam(Request $request)
    {
        $applicant = $this->getAuthenticatedApplicant();
        $phaseTest = $this->getCurrentPhaseTest();
        $testSession = $this->getActiveExamSession($applicant);

        if (!$applicant || !$phaseTest || !$testSession) {
            return redirect()->route('scholarship.test', app()->getLocale())
                ->with('error', "Votre session d'examen a expire. Veuillez vous reconnecter.");
        }

        if ($phaseTest->status !== 'IN_PROGRESS' || $this->isPhaseClosed($phaseTest)) {
            if (!$testSession->finished_at) {
                $this->finalizeExam($testSession, $phaseTest, true, (int) $request->session()->get('exam_violation_count', 0));
            }

            $request->session()->forget($this->examSessionKeys());
            $request->session()->put('completed_test_session_id', $testSession->id);

            return redirect()->route('scholarship.exam.submitted', app()->getLocale());
        }

        if (!$testSession->finished_at) {
            $requestData = $request->validate([
                'question_phase_test_id' => ['nullable', 'integer', 'exists:question_phase_tests,id'],
                'selected_option_id' => ['nullable', 'integer', 'exists:answer_options,id'],
                'current_index' => ['nullable', 'integer', 'min:0'],
                'auto_submitted' => ['nullable', 'boolean'],
            ]);

            if (!empty($requestData['question_phase_test_id'])) {
                $questionPhaseTest = QuestionPhaseTest::query()
                    ->with('question.answer_options')
                    ->where('phase_test_id', $phaseTest->id)
                    ->find($requestData['question_phase_test_id']);

                if ($questionPhaseTest) {
                    $selectedOptionId = $requestData['selected_option_id'] ?? null;

                    if (!$selectedOptionId || $questionPhaseTest->question->answer_options->contains('id', $selectedOptionId)) {
                        $this->persistExamResponse(
                            $request,
                            $testSession,
                            $questionPhaseTest,
                            $selectedOptionId,
                            $requestData['current_index'] ?? null
                        );
                    }
                }
            }

            $this->finalizeExam(
                $testSession,
                $phaseTest,
                (bool) ($requestData['auto_submitted'] ?? false),
                (int) $request->session()->get('exam_violation_count', 0)
            );
        }

        $request->session()->forget($this->examSessionKeys());
        $request->session()->put('completed_test_session_id', $testSession->id);

        return redirect()->route('scholarship.exam.submitted', app()->getLocale());
    }

    public function register()
    {
        $educational_cities = EducationalCity::orderBy('name')->get();
        $document_types = DocumentType::where('is_for_candidats', true)
            ->where('name', '!=', 'PHOTO')
            ->get();

        // pass document_types to the view (was using wrong variable name)
        return view('applicants.registration-form', compact('educational_cities', 'document_types'));
    }

    public function store(StoreApplicantRequest $request)
    {
        try {
            // Validate input first so we can perform idempotency checks that depend on form values
            $validatedData = $request->validated();

            // Idempotency: use a client-supplied token to prevent duplicate processing.
            // Reserve the token immediately so a second concurrent request will be short-circuited.
            $submissionToken = $request->input('submission_token');
            $cacheKey = null;
            if ($submissionToken) {
                $cacheKey = 'app_submission_' . $submissionToken;

                // Use Cache::add to atomically reserve the token only if it doesn't exist.
                // Cache::add returns true if the key was successfully set, false if it already exists.
                $reserved = Cache::add($cacheKey, 'processing', now()->addMinutes(15));
                if (!$reserved) {
                    // Another request is already processing this submission token (or a token collision).
                    // Try polling briefly to see if the applicant record has been created by the other
                    // process (helps avoid duplicate inserts when the first transaction hasn't committed yet).
                    $existingApplicant = null;
                    if (!empty($validatedData['national_exam_code'])) {
                        $editionId = optional(ScholarshipEdition::getCurrentEdition())->id;
                        // Poll up to ~2 seconds (10 * 200ms)
                        for ($i = 0; $i < 10; $i++) {
                            $existingApplicant = Applicant::where('national_exam_code', $validatedData['national_exam_code'])
                                ->where('edition_id', $editionId)
                                ->first();
                            if ($existingApplicant) break;
                            // If the other process marked the cache as processed, stop waiting
                            if (Cache::has($cacheKey) && Cache::get($cacheKey) === true) break;
                            usleep(200000);
                        }
                    }

                    if ($existingApplicant) {
                        return response()->json([
                            'success' => true,
                            'confirmation_message' => __('registration.confirmation_message'),
                            'confirmation_details' => __('registration.confirmation_details', ['firstname' => $existingApplicant->first_name ?? '']),
                            'confirmation_coupon' => $existingApplicant->registration_code,
                        ]);
                    }

                    // If still nothing after polling, return a processing response so the client can
                    // either wait or show a friendly message. We choose to respond with success=true
                    // so the UI flows to the confirmation, but without personalized details.
                    return response()->json([
                        'success' => true,
                        'confirmation_message' => __('registration.confirmation_message'),
                        'confirmation_details' => __('registration.confirmation_details'),
                        'confirmation_coupon' => null,
                        'status' => 'processing'
                    ]);
                }
            }

            $edition = ScholarshipEdition::getCurrentEdition();

            if (!$edition) {
                throw new \Exception("Aucune édition en cours n'est disponible.");
            }

            // Defensive: if an applicant for this national_exam_code already exists for this edition,
            // return a success response pointing to the confirmation so we never create a duplicate.
            if (!empty($validatedData['national_exam_code'])) {
                $existingApplicant = Applicant::where('national_exam_code', $validatedData['national_exam_code'])
                    ->where('edition_id', optional($edition)->id)
                    ->first();

                if ($existingApplicant) {
                    // If the client provided a submission token, mark it processed to avoid reprocessing
                    if (!empty($submissionToken)) {
                        Cache::put('app_submission_' . $submissionToken, true, now()->addMinutes(15));
                    }

                    return response()->json([
                        'success' => true,
                        'confirmation_message' => __('registration.confirmation_message'),
                        'confirmation_details' => __('registration.confirmation_details', ['firstname' => $existingApplicant->first_name ?? '']),
                        'confirmation_coupon' => $existingApplicant->registration_code,
                    ]);
                }
            }

            // Vérifier le code exétat dans le fichier Excel
            // $filePath = public_path('codes/codes_exetat.xlsx');
            // $spreadsheet = IOFactory::load($filePath);
            // $worksheet = $spreadsheet->getActiveSheet();

            // $codeExetat = $validatedData['student_code'];
            // $found = false;

            // foreach ($worksheet->getRowIterator() as $row) {
            //     $cell = $worksheet->getCell('A' . $row->getRowIndex());
            //     $codeInExcel = $cell->getValue();

            //     if ($codeExetat == $codeInExcel) {
            //         $found = true;
            //         break;
            //     }
            // }

            // if (!$found) {
            //     throw new \Exception("Le code d'exetat n'a pas été trouvé dans notre base de données.");
            // }

            // Begin transaction for atomic create + file storage
            DB::beginTransaction();

            // Générer un coupon unique de 5 caractères
            do {
                $coupon = strtoupper(Str::random(5));
            } while (Applicant::where('registration_code', $coupon)->exists());

            if (($validatedData['option_studied'] ?? null) === 'other') {
                $otherStudy = trim((string) $request->input('other_study_option', ''));
                if ($otherStudy !== '') {
                    $validatedData['option_studied'] = $otherStudy;
                }
            }
            if (($validatedData['intended_field'] ?? null) === 'other') {
                $otherUni = trim((string) $request->input('other_university_field', ''));
                if ($otherUni !== '') {
                    $validatedData['intended_field'] = $otherUni;
                }
            }

            // Let's ensure that cities exist
            $diplomaCity = EducationalCity::find($validatedData['educational_city_id']);
            if (!$diplomaCity) {
                Log::error('Invalid diploma city ID: ' . $validatedData['educational_city_id']);
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Validation error',
                        'errors' => ['educational_city_id' => [__("La ville d'obtention du diplôme n'existe pas.")]],
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors(['educational_city_id' => __("La ville d'obtention du diplôme n'existe pas.")])
                    ->withInput();
            }

            $currentCity = EducationalCity::find($validatedData['current_city_id']);
            if (!$diplomaCity || !$currentCity) {
                Log::error('Invalid city IDs: diploma_city_id=' . $validatedData['educational_city_id'] . ', current_city_id=' . $validatedData['current_city_id']);
                throw new \Exception("La ville d'obtention du diplôme ou la ville actuelle n'existe pas.");
            }

            // Créer le candidat avec toutes les données validées
            $applicant = Applicant::create([
                // Informations personnelles
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone_number' => $validatedData['phone_number'],
                'gender' => $validatedData['gender'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'vulnerability_type' => $validatedData['vulnerability_type'],

                // Adresse
                'current_city_id' => $currentCity->id,
                'educational_city_id' => $diplomaCity->id,
                'full_address' => $validatedData['full_address'],

                // Informations scolaires
                'school_name' => $validatedData['school_name'],
                'option_studied' => $validatedData['option_studied'],
                'percentage' => $validatedData['percentage'],
                'national_exam_code' => $validatedData['national_exam_code'],

                // Ambitions personnelles
                'intended_field' => $validatedData['intended_field'],
                'other_university_field' => $validatedData['other_university_field'] ?? null,
                'intended_field_motivation' => $validatedData['intended_field_motivation'],
                'intended_field_motivation_locale' => $validatedData['intended_field_motivation_locale'],
                'career_goals' => $validatedData['career_goals'],
                'career_goals_locale' => $validatedData['career_goals_locale'],
                'additional_infos' => $validatedData['additional_infos'] ?? null,
                'additional_infos_locale' => $validatedData['additional_infos_locale'] ?? null,

                'registration_code' => $coupon,
                'edition_id' => $edition->id,
            ]);

            // Stocker les fichiers dynamiquement selon les types de documents demandés aux candidats
            $documentTypes = DocumentType::where('is_for_candidats', true)->get();
            foreach ($documentTypes as $docType) {
                // Stocker les fichiers
                $fileId = strtolower($docType->name);
                $fileTypeName = strtolower($docType->name);
                $fileTypeNameInPlural = strtolower($docType->name) . 's';

                $path = "applicants/$applicant->id/$fileTypeNameInPlural/";

                try {
                    $this->storeApplicationDocument($request, $applicant, $fileId, $path, $docType->id, $fileTypeName);
                } catch (\Exception $e) {
                    Log::error("Erreur lors du stockage du document {$docType->name}: " . $e->getMessage());

                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => 'Validation error',
                            'errors' => ['general' => [__('errors.server_error')]],
                        ], 422);
                    }

                    return redirect()->back()
                        ->withErrors(['error' => __('errors.server_error')])
                        ->withInput();
                }
            }

            // Sauvegarder les données de session et rediriger vers la page de succès
            session([
                'confirmation_message' => __('registration.confirmation_message'),
                'confirmation_name' => $validatedData['first_name'],
            ]);

            // mark this submission token as processed (short TTL)
            if (!empty($submissionToken)) {
                $cacheKey = 'app_submission_' . $submissionToken;
                Cache::put($cacheKey, true, now()->addMinutes(15));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'confirmation_message' => __('registration.confirmation_message'),
                'confirmation_details' => __('registration.confirmation_details', ['firstname' => $validatedData['first_name'] ?? '']),
                'confirmation_coupon' => $coupon,
            ]);
        } catch (\Exception $e) {
            // Ensure transaction rollback if started
            try { DB::rollBack(); } catch (\Exception $_) {}

            // If this is a duplicate-key error (another concurrent request inserted the same
            // national_exam_code), respond idempotently by returning the existing applicant's
            // confirmation details instead of an error.
            if ($e instanceof \Illuminate\Database\QueryException) {
                $errorInfo = $e->errorInfo ?? null;
                $isDuplicate = false;
                if (is_array($errorInfo) && isset($errorInfo[1]) && in_array($errorInfo[1], [1062, 23505])) {
                    // 1062 = MySQL duplicate entry, 23505 = Postgres unique_violation
                    $isDuplicate = true;
                }

                if ($isDuplicate && !empty($validatedData['national_exam_code'])) {
                    $existingApplicant = Applicant::where('national_exam_code', $validatedData['national_exam_code'])
                        ->where('edition_id', optional(ScholarshipEdition::getCurrentEdition())->id)
                        ->first();

                    if ($existingApplicant) {
                        // mark token processed to avoid future re-processing
                        if (!empty($submissionToken)) {
                            Cache::put('app_submission_' . $submissionToken, true, now()->addMinutes(15));
                        }

                        return response()->json([
                            'success' => true,
                            'confirmation_message' => __('registration.confirmation_message'),
                            'confirmation_details' => __('registration.confirmation_details', ['firstname' => $existingApplicant->first_name ?? '']),
                            'confirmation_coupon' => $existingApplicant->registration_code,
                        ]);
                    }
                }
            }

            Log::error('Error creating candidat: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => ['general' => [__('errors.server_error')]],
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => __('errors.server_error')])
                ->withInput();
        }
    }

    protected function storeApplicationDocument($request, $applicant, $fileId, $path, $docTypeId, $docTypeName)
    {
        if ($request->hasFile($fileId)) {
            $file = $request->file($fileId);
            $fileExt = $file->getClientOriginalExtension();
            ;
            $fileName = $this->generateDocumentFileName(
                $applicant->first_name,
                $applicant->last_name,
                $docTypeName,
                $fileExt
            );

            // Stocker le fichier avec le nom généré
            $storedPath = $file->storeAs($path, $fileName, 'public');

            // Créer l'enregistrement et lier au type de document (document_type_id)
            $applicantDoc = ApplicationDocument::create([
                'applicant_id' => $applicant->id,
                'document_type_id' => $docTypeId,
                'file_url' => $storedPath,
                'file_type' => $fileExt,
                'file_name' => $fileName,
            ]);
        }
    }

    protected function generateDocumentFileName(string $firstName, string $lastName, string $type, ?string $extension = null): string
    {
        $date = now()->format('Ymd_His');
        $base = strtolower(Str::slug($firstName)) . '_' .
            strtolower(Str::slug($lastName)) . '_' .
            strtolower(Str::slug($type)) . '_' . $date;

        return $extension ? $base . '.' . strtolower($extension) : $base;
    }

    public function genererPassword($length = 12)
    {
        // Assurez-vous que la longueur minimale est respectée
        if ($length < 8) {
            $length = 8;
        }

        // Définir les ensembles de caractères
        $lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        $uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digitChars = '0123456789';
        $specialChars = '!@#$%^&*';

        // Assurer qu'on inclut au moins un caractère de chaque ensemble
        $password = [
            $lowercaseChars[random_int(0, strlen($lowercaseChars) - 1)],
            $uppercaseChars[random_int(0, strlen($uppercaseChars) - 1)],
            $digitChars[random_int(0, strlen($digitChars) - 1)],
            $specialChars[random_int(0, strlen($specialChars) - 1)],
        ];

        // Compléter le mot de passe avec des caractères aléatoires
        $allChars = $lowercaseChars . $uppercaseChars . $digitChars . $specialChars;
        for ($i = 4; $i < $length; $i++) {
            $password[] = $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Mélanger les caractères pour éviter un ordre prévisible
        shuffle($password);

        // Convertir le tableau en chaîne de caractères
        return implode('', $password);
    }

    public function show(Applicant $applicant)
    {
        return view('applicants.show', compact('applicant'));
    }

    public function edit(Applicant $applicant)
    {
        return view('applicants.edit', compact('applicant'));
    }

    public function update(UpdateApplicantRequest $request, Applicant $applicant)
    {
        $applicant->update($request->validated());
        return redirect()->route('applicants.show', $applicant)->with('success', __('messages.updated'));
    }

    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return redirect()->route('applicants.index')->with('success', __('messages.deleted'));
    }

    protected function getAuthenticatedApplicant(): ?Applicant
    {
        $applicantId = session('authenticated_applicant_id');

        if (!$applicantId) {
            return null;
        }

        return Applicant::query()->find($applicantId);
    }

    protected function getCurrentPhaseTest(): ?PhaseTest
    {
        $edition = ScholarshipEdition::getCurrentEdition();

        if (!$edition) {
            return null;
        }

        return PhaseTest::query()
            ->where('scholarship_edition_id', $edition->id)
            ->first();
    }

    protected function getActiveExamSession(?Applicant $applicant): ?TestSession
    {
        if (!$applicant) {
            return null;
        }

        $sessionId = session('exam_session_id');

        if ($sessionId) {
            $testSession = TestSession::query()
                ->where('applicant_id', $applicant->id)
                ->find($sessionId);

            if ($testSession) {
                return $testSession;
            }
        }

        return TestSession::query()
            ->where('applicant_id', $applicant->id)
            ->whereNull('finished_at')
            ->latest('id')
            ->first();
    }

    protected function getLatestApplicantTestSession(?Applicant $applicant): ?TestSession
    {
        if (!$applicant) {
            return null;
        }

        return TestSession::query()
            ->where('applicant_id', $applicant->id)
            ->latest('id')
            ->first();
    }

    protected function loadPhaseQuestionPhaseTests(PhaseTest $phaseTest)
    {
        return QuestionPhaseTest::query()
            ->with([
                'question.category_question',
                'question.answer_options',
            ])
            ->where('phase_test_id', $phaseTest->id)
            ->get();
    }

    protected function buildExamViewState(Applicant $applicant, PhaseTest $phaseTest): ?array
    {
        $testSession = $this->getActiveExamSession($applicant);

        if (!$testSession) {
            return null;
        }

        $questionPhaseTests = $this->loadPhaseQuestionPhaseTests($phaseTest)->keyBy('id');
        $questionOrder = collect(session('exam_question_order', []))
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $questionPhaseTests->has($id))
            ->values();

        if ($questionOrder->isEmpty()) {
            $questionOrder = $questionPhaseTests->keys()->shuffle()->values();
            session(['exam_question_order' => $questionOrder->all()]);
        }

        $responses = CandidateResponse::query()
            ->where('test_session_id', $testSession->id)
            ->get()
            ->keyBy('question_phase_test_id');

        $questions = $questionOrder->map(function (int $questionPhaseTestId) use ($questionPhaseTests, $responses) {
            $item = $questionPhaseTests->get($questionPhaseTestId);
            $response = $responses->get($questionPhaseTestId);

            return [
                'id' => $item->id,
                'question_id' => $item->question_id,
                'category' => optional($item->question->category_question)->name,
                'question_text' => $item->question->question_text,
                'ponderation' => $item->ponderation,
                'selected_option_id' => $response?->selected_option_id,
                'options' => $item->question->answer_options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->option_text,
                    ];
                })->values()->all(),
            ];
        })->values();

        $startedAt = session('exam_started_at')
            ? Carbon::parse(session('exam_started_at'))
            : ($testSession->started_at ?? now());
        $endsAt = (clone $startedAt)->addMinutes((int) $phaseTest->duration);
        if ($phaseTest->end_time && $phaseTest->end_time->lt($endsAt)) {
            $endsAt = $phaseTest->end_time->copy();
        }

        $currentIndex = (int) session('exam_current_index', 0);
        $currentIndex = max(0, min($currentIndex, max($questions->count() - 1, 0)));
        session(['exam_current_index' => $currentIndex]);

        return [
            'testSession' => $testSession,
            'examQuestions' => $questions->all(),
            'currentQuestionIndex' => $currentIndex,
            'violationCount' => (int) session('exam_violation_count', 0),
            'examMeta' => [
                'started_at' => $startedAt->toIso8601String(),
                'ends_at' => $endsAt->toIso8601String(),
                'duration_minutes' => (int) $phaseTest->duration,
                'max_violations' => 3,
            ],
        ];
    }

    protected function finalizeExam(
        TestSession $testSession,
        PhaseTest $phaseTest,
        bool $autoSubmitted = false,
        ?int $cheatingAttempts = null
    ): void {
        $responses = CandidateResponse::query()
            ->with(['question_phase_test.question.answer_options'])
            ->where('test_session_id', $testSession->id)
            ->get();

        $score = $responses->sum(function (CandidateResponse $response) {
            $questionPhaseTest = $response->question_phase_test;

            if (!$questionPhaseTest || !$response->selected_option_id) {
                return 0;
            }

            $isCorrect = $questionPhaseTest->question->answer_options
                ->firstWhere('id', $response->selected_option_id)?->pivot?->is_correct;

            return $isCorrect ? (float) $questionPhaseTest->ponderation : 0;
        });

        $totalPossibleScore = (float) QuestionPhaseTest::query()
            ->where('phase_test_id', $phaseTest->id)
            ->sum('ponderation');
        $percentageScore = $totalPossibleScore > 0 ? ($score / $totalPossibleScore) * 100 : 0;

        $testSession->update([
            'finished_at' => $testSession->finished_at ?? now(),
            'total_score' => $score,
            'is_passed' => $percentageScore >= (float) $phaseTest->passing_score,
            'cheating_attempts' => $cheatingAttempts ?? (int) $testSession->cheating_attempts,
            'auto_submitted' => $autoSubmitted,
        ]);
    }

    protected function persistExamResponse(
        Request $request,
        TestSession $testSession,
        QuestionPhaseTest $questionPhaseTest,
        ?int $selectedOptionId,
        ?int $currentIndex = null
    ): void {
        CandidateResponse::query()->updateOrCreate(
            [
                'test_session_id' => $testSession->id,
                'question_phase_test_id' => $questionPhaseTest->id,
            ],
            [
                'selected_option_id' => $selectedOptionId,
                'text_answer' => null,
            ]
        );

        if ($currentIndex !== null) {
            $request->session()->put('exam_current_index', $currentIndex);
        }
    }

    protected function resolveCompletedTestSession(Applicant $applicant): ?TestSession
    {
        $completedSessionId = session('completed_test_session_id');

        if ($completedSessionId) {
            $testSession = TestSession::query()
                ->where('applicant_id', $applicant->id)
                ->find($completedSessionId);

            if ($testSession && $testSession->finished_at) {
                return $testSession;
            }
        }

        return TestSession::query()
            ->where('applicant_id', $applicant->id)
            ->whereNotNull('finished_at')
            ->latest('finished_at')
            ->first();
    }

    protected function buildSubmissionSummary(TestSession $testSession): array
    {
        $phaseTest = $this->getCurrentPhaseTest();
        $answeredCount = CandidateResponse::query()
            ->where('test_session_id', $testSession->id)
            ->whereNotNull('selected_option_id')
            ->count();

        $totalQuestions = $phaseTest
            ? QuestionPhaseTest::query()->where('phase_test_id', $phaseTest->id)->count()
            : 0;

        $secondsUsed = $testSession->started_at && $testSession->finished_at
            ? max(0, $testSession->started_at->diffInSeconds($testSession->finished_at))
            : 0;

        $hours = intdiv($secondsUsed, 3600);
        $minutes = intdiv($secondsUsed % 3600, 60);
        $seconds = $secondsUsed % 60;

        return [
            'answered_count' => $answeredCount,
            'total_questions' => $totalQuestions,
            'cheating_attempts' => (int) $testSession->cheating_attempts,
            'auto_submitted' => (bool) $testSession->auto_submitted,
            'time_used_label' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds),
            'submitted_at' => optional($testSession->finished_at)?->format('d/m/Y H:i'),
        ];
    }

    protected function examSessionKeys(): array
    {
        return [
            'exam_started',
            'exam_session_id',
            'exam_phase_test_id',
            'exam_question_order',
            'exam_current_index',
            'exam_started_at',
            'exam_violation_count',
        ];
    }

    protected function phaseWindowErrorMessage(PhaseTest $phaseTest): ?string
    {
        $now = now();

        if ($phaseTest->start_time && $now->lt($phaseTest->start_time)) {
            return "Cette phase n'a pas encore commence.";
        }

        if ($phaseTest->end_time && $now->gt($phaseTest->end_time)) {
            return "Cette phase est deja terminee.";
        }

        return null;
    }

    protected function isPhaseClosed(PhaseTest $phaseTest): bool
    {
        return !is_null($phaseTest->end_time) && now()->gt($phaseTest->end_time);
    }
}
