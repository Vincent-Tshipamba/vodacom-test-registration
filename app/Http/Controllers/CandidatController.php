<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Http\Requests\StoreCandidatRequest;
use Illuminate\Support\Str;
use App\Imports\CodesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Validation\Rule;

class CandidatController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function show(Candidat $Candidat)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $candidat = Candidat::find($request->id);
        $candidat->status = $request->status;
        $candidat->save();

        return response()->json(['status' => 'Candidat mentionné présent avec succès !']);
    }


    public function search(Request $request)
    {
        $candidats = Candidat::where('coupon', 'LIKE', "%{$request->coupon}%")
            ->take(5)
            ->latest()
            ->get();

        return response()->json($candidats);
    }

    public function store(StoreCandidatRequest $request)
    {
        try {
            $validatedData = $request->validated();

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

            // Stocker les fichiers
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('candidats/photos', 'public');
            }

            $idDocumentPath = null;
            if ($request->hasFile('id_document_path')) {
                $idDocumentPath = $request->file('id_document_path')->store('candidats/documents', 'public');
            }

            $diplomaPath = null;
            if ($request->hasFile('diploma_path')) {
                $diplomaPath = $request->file('diploma_path')->store('candidats/diplomas', 'public');
            }

            $recommendationPath = null;
            if ($request->hasFile('recommendation_path')) {
                $recommendationPath = $request->file('recommendation_path')->store('candidats/recommendations', 'public');
            }

            // Générer un coupon unique de 5 caractères
            do {
                $coupon = strtoupper(Str::random(5));
            } while (Candidat::where('coupon', $coupon)->exists());

            // Créer le candidat avec toutes les données validées
            $candidat = Candidat::create([
                // Informations personnelles
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'birthdate' => $validatedData['birthdate'],
                'identification_type' => $validatedData['identification_type'],
                'photo' => $photoPath,

                // Adresse
                'current_city' => $validatedData['current_city'],
                'diploma_city' => $validatedData['diploma_city'],
                'full_address' => $validatedData['full_address'],

                // Informations scolaires
                'school_name' => $validatedData['school_name'],
                'study_option' => $validatedData['study_option'],
                'diploma_score' => $validatedData['diploma_score'],
                'student_code' => $validatedData['student_code'],

                // Documents
                'id_document_path' => $idDocumentPath,
                'diploma_path' => $diplomaPath,
                'recommendation_path' => $recommendationPath,

                // Ambitions personnelles
                'university_field' => $validatedData['university_field'],
                'other_university_field' => $validatedData['other_university_field'] ?? null,
                'passion' => $validatedData['passion'],
                'passion_locale' => $validatedData['passion_locale'],
                'career_goals' => $validatedData['career_goals'],
                'career_goals_locale' => $validatedData['career_goals_locale'],
                'additional_infos' => $validatedData['additional_infos'] ?? null,
                'additional_infos_locale' => $validatedData['additional_infos_locale'] ?? null,

                // Champs système
                'coupon' => $coupon,
                'status' => 'pending',
            ]);

            // Sauvegarder les données de session et rediriger vers la page de succès
            session([
                'confirmation_message' => __('registration.confirmation_message'),
                'confirmation_name' => $validatedData['firstname'],
                'confirmation_coupon' => $coupon
            ]);
            return response()->json([
                'success' => true,
                'redirect' => route('registration.form') . '#confirmation'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating candidat: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
