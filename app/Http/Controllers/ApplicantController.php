<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\UpdateApplicantRequest;
use App\Models\ApplicationDocument;
use App\Models\ScholarshipEdition;
use App\Models\User;

class ApplicantController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function register()
    {
        return view('applicants.registration-form');
    }

    public function store(StoreApplicantRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $edition = ScholarshipEdition::getActiveEdition();

            if (!$edition) {
                throw new \Exception("Aucune édition en cours n'est disponible.");
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


            // Creation du user
            $password = $this->genererPassword();
            $user = User::create([
                'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => null,
                'password' => $password,
            ]);

            // Générer un coupon unique de 5 caractères
            do {
                $coupon = strtoupper(Str::random(5));
            } while (Applicant::where('registration_code', $coupon)->exists());

            // Remplacer les valeurs 'other' par les valeurs personnalisées saisies (depuis la requête brute)
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
                'current_city' => $validatedData['current_city'],
                'diploma_city' => $validatedData['diploma_city'],
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
                'edition_id' => optional($edition)->id,
                'user_id' => $user->id,
            ]);

            // Stocker les fichiers
            $this->storeApplicationDocument($request, $applicant, 'photo', 'applicants/' . $applicant->id . '/photos', 'photo');
            $this->storeApplicationDocument($request, $applicant, 'id_document', 'applicants/' . $applicant->id . '/ids', 'id');
            $this->storeApplicationDocument($request, $applicant, 'recommendation', 'applicants/' . $applicant->id . '/reco_letters', 'reco_letter');
            $this->storeApplicationDocument($request, $applicant, 'diploma', 'applicants/' . $applicant->id . '/diplomas', 'diploma');


            // Sauvegarder les données de session et rediriger vers la page de succès
            session([
                'confirmation_message' => __('registration.confirmation_message'),
                'confirmation_name' => $validatedData['first_name'],
                // 'confirmation_coupon' => $coupon
            ]);
            // return redirect()->route('applicants.show', $applicant)->with('success', __('messages.saved'));

            return response()->json([
                'success' => __('messages.saved'),
                'redirect' => route('scholarship.register', app()->getLocale()) . '#confirmation'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating candidat: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => ['general' => [$e->getMessage()]],
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    protected function storeApplicationDocument($request, $applicant, $fileId, $path, $docType)
    {
        if ($request->hasFile($fileId)) {
            $fileExt = $request->file($fileId)->getClientOriginalExtension();
            $fileName = $this->generateDocumentFileName(
                $applicant->first_name,
                $applicant->last_name,
                $docType,
                $fileExt
            );
            // Stocker le fichier avec le nom généré
            $storedPath = $request->file($fileId)->storeAs($path, $fileName, 'public');

            $applicantDoc = ApplicationDocument::create([
                'applicant_id' => $applicant->id,
                'document_type' => strtoupper($docType),
                'file_url' => $storedPath,
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
