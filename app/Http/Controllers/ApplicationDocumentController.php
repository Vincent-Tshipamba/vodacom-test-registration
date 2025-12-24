<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationDocumentRequest;
use App\Http\Requests\UpdateApplicationDocumentRequest;
use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Storage;

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
