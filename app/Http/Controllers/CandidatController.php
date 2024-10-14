<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Support\Str;
use App\Imports\CodesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function checkCodeExetat(Request $request)
    {
        dd('ghghkjl');
        // Lire le fichier Excel
        $filePath = storage_path('codes/codes_exetat.xls'); // Le chemin du fichier Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        
        $codesList = [];
    
        foreach ($sheet->getRowIterator() as $row) {
            $cell = $sheet->getCell('B' . $row->getRowIndex()); // Remplace 'A' par la bonne lettre si nécessaire
            $codesList[] = $cell->getValue();
        }
    
        // Vérifier si le code d'exetat soumis est dans la liste
        $codeExetat = $request->input('code_exetat');
        if (in_array($codeExetat, $codesList)) {
            return response()->json(['success' => 'Le code d\'exetat est valide.']);
        } else {
            return response()->json(['error' => 'Le code d\'exetat n\'est pas valide.']);
        }
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
            // Vérifier si le code d'exetat existe déjà
            $existingCandidat = Candidat::where('code_exetat', $request->code_exetat)->first();
            if ($existingCandidat) {
                throw new \Exception('Désolé, nous ne pouvons pas accepter cet enregistrement car ce code d\'exetat a déjà été utilisé.');
            }

            // Valider les données du formulaire
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'code_exetat' => 'required|digits:14',
                'identity' => 'required|max:20480',
                'certificate' => 'required|max:20480',
                'photo' => 'required|max:20480',
            ], [
                'name.required' => 'Le nom est obligatoire',
                'name.string' => 'Le nom doit être une chaîne de caractères',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères',
                'phone.required' => 'Le téléphone est obligatoire',
                'phone.string' => 'Le téléphone doit être une chaîne de caractères',
                'phone.max' => 'Le téléphone ne peut pas dépasser 20 caractères',
                'code_exetat.required' => 'Le code d\'exetat est obligatoire',
                'code_exetat.digits' => 'Le code d\'exetat doit être un nombre de 14 chiffres',
                'identity.required' => 'L\'identité est obligatoire',
                'certificate.required' => 'Le certificat est obligatoire',
                'identity.max' => 'La taille de l\'identité ne peut pas dépasser 20 Mo',
                'certificate.max' => 'La taille du certificat ne peut pas dépasser 20 Mo',
                'photo.max' => 'La taille de la photo ne peut pas dépasser 20 Mo',
            ]);

            if ($request->file('identity')->getClientOriginalExtension() !== 'pdf' && !in_array($request->file('identity')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'avif'])) {
                return back()->withErrors(['identity' => 'Le fichier doit être un PDF ou une image.']);
            }

            if ($request->file('certificate')->getClientOriginalExtension() !== 'pdf' && !in_array($request->file('certificate')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'avif'])) {
                return back()->withErrors(['identity' => 'Le fichier doit être un PDF ou une image.']);
            }

            if ($request->file('photo')->getClientOriginalExtension() !== 'pdf' && !in_array($request->file('photo')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'avif'])) {
                return back()->withErrors(['identity' => 'Le fichier doit être un PDF ou une image.']);
            }


            // Stocker les fichiers
            $identityPath = $request->file('identity')->store('candidats/identity', 'public');
            $certificatePath = $request->file('certificate')->store('candidats/certificates', 'public');
            $photoPath = $request->file('photo')->store('candidats/photos', 'public');

            //dd($identityPath, $certificatePath, $photoPath);
            // Générer un coupon unique de 5 caractères
            do {
                $coupon = strtoupper(Str::random(5));
            } while (Candidat::where('coupon', $coupon)->exists());

            // Créer un nouveau candidat avec le coupon généré
            Candidat::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'code_exetat' => $request->code_exetat,
                'identity' => $identityPath,
                'certificate' => $certificatePath,
                'photo' => $photoPath,
                'coupon' => $coupon,
            ]);

            session(['code_exetat' => $request->code_exetat]);
            session(['success' => "Merci d'avoir rempli ce formulaire. Votre coupon est : $coupon.
                Prière de bien le garder et surtout de ne pas l'oublier, car il vous donnera l'accès
                à la salle de passation du test.
                En attendant, bonne préparation $request->name."]);

            return redirect()
                ->route('success');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
