<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
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

    public function store(Request $request)
    {
        try {
            // Valider les données du formulaire avec des messages d'erreur personnalisés
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'code_exetat' => 'required|digits:14|unique:candidats',
                'pourcentage' => 'required|numeric|min:70|max:100',
                'identity' => 'required|file|max:20480|mimes:pdf,jpeg,png,jpg,avif',
                'certificate' => 'required|file|max:20480|mimes:pdf,jpeg,png,jpg,avif',
                'photo' => 'required|file|max:20480|mimes:jpeg,png,jpg,avif',
            ], [
                'code_exetat.required' => 'Le code d\'exetat est obligatoire.',
                'code_exetat.digits' => 'Le code d\'exetat doit comporter exactement 14 chiffres.',
                'code_exetat.unique' => 'Ce code d\'exetat est déjà utilisé. Impossible de l\'enregistrer à nouveau.',
                'pourcentage.required' => 'Le pourcentage est obligatoire.',
                'pourcentage.min' => 'Le pourcentage minimum requis est de 70.',
                'pourcentage.max' => 'Le pourcentage maximum autorisé est de 100.',
                'identity.required' => 'Le fichier d\'identité est obligatoire.',
                'certificate.required' => 'Le fichier du certificat est obligatoire.',
                'photo.required' => 'La photo est obligatoire.',
            ]);

            // Chemin du fichier Excel
            $filePath = public_path('codes/codes_exetat.xlsx');

            // Charger le fichier Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $codeExetat = $request->code_exetat;
            $pourcentageInput = $request->pourcentage;

            // Parcourir les lignes du fichier Excel
            $found = false;
            foreach ($worksheet->getRowIterator() as $row) {
                $cell = $worksheet->getCell('A' . $row->getRowIndex()); // Supposons que les codes sont dans la colonne A
                $codeInExcel = $cell->getValue();

                // Si le code est trouvé, on arrête la recherche
                if ($codeExetat == $codeInExcel) {
                    $found = true;

                    // Vérifier le pourcentage
                    if ($pourcentageInput < 70) {
                        throw new \Exception("Le pourcentage minimum requis est de 70. Vous avez soumis $pourcentageInput.");
                    }

                    break; // On arrête la boucle si on trouve le code
                }
            }

            if (!$found) {
                throw new \Exception("Le code d'exetat n'a pas été trouvé dans notre base de données.");
            }

            // Stocker les fichiers
            $identityPath = $request->file('identity')->store('candidats/identity', 'public');
            $certificatePath = $request->file('certificate')->store('candidats/certificates', 'public');
            $photoPath = $request->file('photo')->store('candidats/photos', 'public');

            // Générer un coupon unique de 5 caractères
            do {
                $coupon = strtoupper(Str::random(5));
            } while (Candidat::where('coupon', $coupon)->exists());

            // Créer un nouveau candidat avec le coupon généré
            Candidat::firstOrCreate([
                'name' => $request->name,
                'phone' => $request->phone,
                'code_exetat' => $request->code_exetat,
                'pourcentage' => $request->pourcentage,
                'identity' => $identityPath,
                'certificate' => $certificatePath,
                'photo' => $photoPath,
                'coupon' => $coupon,
            ]);

            // Sauvegarder les données de session et rediriger vers la page de succès
            session([
                'success' => "Merci d'avoir rempli ce formulaire. Votre coupon est : $coupon.
                          Prière de bien le garder et surtout de ne pas l'oublier, car il vous donnera l'accès
                          à la salle de passation du test. Bonne préparation $request->name.",
                'coupon' => $coupon,
                'name' => $request->name
            ]);

            return redirect()->route('success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
