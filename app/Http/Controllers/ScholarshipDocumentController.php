<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScholarshipDocumentRequest;
use App\Http\Requests\UpdateScholarshipDocumentRequest;
use App\Models\ScholarshipDocument;
use Illuminate\Support\Facades\Storage;

class ScholarshipDocumentController extends Controller
{
    public function index()
    {
        $items = ScholarshipDocument::with(['record', 'reviewer'])->paginate(20);
        return view('scholarship-documents.index', compact('items'));
    }

    public function store(StoreScholarshipDocumentRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('scholarship_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $doc = ScholarshipDocument::create($data);
        return redirect()->route('scholarship-documents.show', $doc)->with('success', __('messages.saved'));
    }

    public function show(ScholarshipDocument $scholarshipDocument)
    {
        $scholarshipDocument->load(['record', 'reviewer']);
        return view('scholarship-documents.show', compact('scholarshipDocument'));
    }

    public function create()
    {
        return view('scholarship-documents.create');
    }

    public function edit(ScholarshipDocument $scholarshipDocument)
    {
        return view('scholarship-documents.edit', compact('scholarshipDocument'));
    }

    public function update(UpdateScholarshipDocumentRequest $request, ScholarshipDocument $scholarshipDocument)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('scholarship_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $scholarshipDocument->update($data);
        return redirect()->route('scholarship-documents.show', $scholarshipDocument)->with('success', __('messages.updated'));
    }

    public function destroy(ScholarshipDocument $scholarshipDocument)
    {
        $scholarshipDocument->delete();
        return redirect()->route('scholarship-documents.index')->with('success', __('messages.deleted'));
    }
}
