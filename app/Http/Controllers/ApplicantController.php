<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        ]);

        $nationalExamCode = $request->input('national_exam_code');


        $applicant = Applicant::where('national_exam_code', $nationalExamCode)
            ->where('registration_code', $request->input('coupon'))
            ->where('edition_id', ScholarshipEdition::getCurrentEdition()->id)
            ->where('application_status', 'SHORTLISTED')
            ->first();

        if ($applicant) {
            Log::info('Applicant authenticated for test : ' . $applicant->first_name . ' ' . $applicant->last_name);

            session(['authenticated_applicant_id' => $applicant->id]);
            return redirect()->route('scholarship.test', app()->getLocale())->with('success', __('messages.authenticated'));
        } else {
            return redirect()->back()
                ->with('error', 'Desolé, les informations fournies ne correspondent à aucun candidat éligible.');
        }
    }

    public function instructions()
    {
        return view('tests.instructions');
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
}
