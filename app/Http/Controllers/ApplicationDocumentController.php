<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreApplicationDocumentRequest;
use App\Http\Requests\UpdateApplicationDocumentRequest;

class ApplicationDocumentController extends Controller
{
    public function index()
    {
        $items = ApplicationDocument::with(['applicant', 'reviewer'])->paginate(20);
        return view('application-documents.index', compact('items'));
    }

    public function create()
    {
        return view('application-documents.create');
    }

    public function change_status(Request $request)
    {
        $is_valid = $request->boolean('is_valid');

        $user = User::find(Auth::id());

        $related_scholar_applicant = $user->applicant;
        $scholar_id = $related_scholar_applicant->scholar?->id;
        $agent_id = $user->staff_profile?->id;

        $application_document = ApplicationDocument::find($request->input('id'));

        if (!$application_document) {
            return response()->json([
                'message' => 'Aucun document correspondant a l\'identifiant envoye n\'a ete trouve',
            ]);
        }

        $application_document->update([
            'is_valid' => $is_valid,
            'reviewed_by_agent' => $agent_id ?? null,
            'reviewed_by_scholar' => $scholar_id ?? null,
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Document examiné avec succès !'
        ]);
    }

    public function store(StoreApplicationDocumentRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('application_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $doc = ApplicationDocument::create($data);
        return redirect()->route('application-documents.show', $doc)->with('success', __('messages.saved'));
    }

    public function show(ApplicationDocument $applicationDocument)
    {
        $applicationDocument->load(['applicant', 'reviewer']);
        return view('application-documents.show', compact('applicationDocument'));
    }

    public function edit(ApplicationDocument $applicationDocument)
    {
        return view('application-documents.edit', compact('applicationDocument'));
    }

    public function update(UpdateApplicationDocumentRequest $request, ApplicationDocument $applicationDocument)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('application_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $applicationDocument->update($data);
        return redirect()->route('application-documents.show', $applicationDocument)->with('success', __('messages.updated'));
    }

    public function destroy(ApplicationDocument $applicationDocument)
    {
        $applicationDocument->delete();
        return redirect()->route('application-documents.index')->with('success', __('messages.deleted'));
    }
}
