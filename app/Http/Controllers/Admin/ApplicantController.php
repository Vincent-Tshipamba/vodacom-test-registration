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
            return back()->with('error', 'Seuls les candidats en attente peuvent etre traites depuis cette page.');
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
            return back()->with('success', 'Le statut de ce candidat est deja a jour.');
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
            ? 'Le candidat a ete valide avec succes.'
            : 'Le candidat a ete marque comme non retenu.';

        return back()->with('success', $message);
    }
}
