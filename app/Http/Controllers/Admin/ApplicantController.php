<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\HistoriqueStatusChange;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    private const REQUIRED_DOCUMENT_TYPES_FOR_SHORTLISTING = ['DIPLOMA', 'ID'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listApplicants = Applicant::latest()->get();

        $gridApplicants = Applicant::latest()->paginate(16);

        if (request()->has('ajax')) {
            return response()->json([
                'html' => view('admin.applicants.partials.applicants-grid', ['applicants' => $gridApplicants])->render(),
                'next_page_url' => $gridApplicants->nextPageUrl()
            ]);
        }

        return view('admin.applicants.index', compact('listApplicants', 'gridApplicants'));
    }

    /**
     * Search applicants by query
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $applicants = Applicant::when($query, function ($q) use ($query) {
            $q->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('phone_number', 'like', "%$query%")
                ->orWhere('registration_code', 'like', "%$query%");
        })->take(5)->get(['id', 'first_name', 'last_name', 'date_of_birth', 'phone_number', 'percentage', 'full_address', 'career_goals', 'registration_code']);

        return response()->json($applicants);
    }


    /**
     * Display the specified resource.
     */
    public function show(String $locale, Applicant $applicant)
    {
        $applicant->load([
            'educational_city',
            'current_city',
            'application_documents.document_type',
            'historique_status_changes.changed_by_agent.user',
            'historique_status_changes.changed_by_scholar.user',
        ]);

        return view('admin.applicants.show', compact('applicant'));
    }

    public function updateStatus(Request $request, string $locale, Applicant $applicant)
    {
        $validated = $request->validate([
            'application_status' => ['required', 'string', Rule::in(['SHORTLISTED', 'REJECTED'])],
        ]);

        if ($applicant->application_status !== 'PENDING') {
            return back()->with('error', 'Seuls les candidats en attente peuvent etre traités depuis cette page.');
        }

        $user = Auth::user();
        $agentId = $user?->agent?->id;
        $scholarId = $user?->scholar?->id;

        if (!$agentId && !$scholarId) {
            return back()->with('error', 'Votre profil ne permet pas de modifier le statut des candidats.');
        }

        $newStatus = $validated['application_status'];
        $oldStatus = $applicant->application_status;

        if ($oldStatus === $newStatus) {
            return back()->with('success', 'Le statut de ce candidat est déjà à jour.');
        }

        if ($newStatus === 'SHORTLISTED') {
            $validationError = $this->validateDocumentsBeforeShortlisting($applicant);

            if ($validationError !== null) {
                return back()->with('error', $validationError);
            }
        }

        $applicant->update([
            'application_status' => $newStatus,
        ]);

        HistoriqueStatusChange::create([
            'applicant_id' => $applicant->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by_agent_id' => $agentId,
            'changed_by_scholar_id' => $scholarId,
        ]);

        $message = $newStatus === 'SHORTLISTED'
            ? 'Le candidat a été validé avec succès.'
            : 'Le candidat a été marqué comme non retenu.';

        return back()->with('success', $message);
    }

    private function validateDocumentsBeforeShortlisting(Applicant $applicant): ?string
    {
        $applicant->loadMissing('application_documents.document_type');

        $documents = $applicant->application_documents;

        if ($documents->isEmpty()) {
            return 'Impossible de valider ce candidat tant que ses documents n\'ont pas été éxamines.';
        }

        $firstUnreviewedDocument = $documents->first(function ($document) {
            return $document->reviewed_at === null;
        });

        if ($firstUnreviewedDocument !== null) {
            return sprintf(
                'Le document "%s" doit être examiné avant de valider ce candidat.',
                $this->getDocumentLabel($firstUnreviewedDocument->document_type->name ?? null)
            );
        }

        foreach (self::REQUIRED_DOCUMENT_TYPES_FOR_SHORTLISTING as $requiredDocumentType) {
            $document = $documents->first(function ($item) use ($requiredDocumentType) {
                return ($item->document_type->name ?? null) === $requiredDocumentType;
            });

            if ($document === null) {
                return sprintf(
                    'Le document obligatoire "%s" est introuvable. La validation du candidat est impossible.',
                    $this->getDocumentLabel($requiredDocumentType)
                );
            }

            if ($document->is_valid !== true) {
                return sprintf(
                    'Le document obligatoire "%s" est invalide. Corrigez-le ou validez-le avant de valider ce candidat.',
                    $this->getDocumentLabel($requiredDocumentType)
                );
            }
        }

        return null;
    }

    private function getDocumentLabel(?string $documentType): string
    {
        return match ($documentType) {
            'DIPLOMA' => 'Diplôme',
            'ID' => 'Pièce d\'identité',
            'PHOTO' => 'Photo',
            'RECO_LETTER' => 'Lettre de recommandation',
            default => $documentType ?? 'Document inconnu',
        };
    }
}
