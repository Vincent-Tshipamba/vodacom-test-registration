<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarDocument;
use Illuminate\Support\Facades\Storage;

class ScholarDocumentController extends Controller
{
    public function index()
    {
        $items = ScholarDocument::with(['record', 'reviewer'])->paginate(20);
        return view('scholarship-documents.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('scholarship_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $doc = ScholarDocument::create($data);
        return redirect()->route('scholarship-documents.show', $doc)->with('success', __('messages.saved'));
    }

    public function show(ScholarDocument $scholarDocument)
    {
        $scholarDocument->load(['record', 'reviewer']);
        return view('scholarship-documents.show', compact('scholarDocument'));
    }

    public function create()
    {
        return view('scholar-documents.create');
    }

    public function edit(ScholarDocument $scholarDocument)
    {
        return view('scholarship-documents.edit', compact('scholarDocument'));
    }

    public function update(Request $request, ScholarDocument $scholarDocument)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('scholarship_documents', 'public');
            $data['file_url'] = Storage::url($path);
            $data['file_name'] = $data['file_name'] ?? $request->file('file')->getClientOriginalName();
        }
        $scholarDocument->update($data);
        return redirect()->route('scholarship-documents.show', $scholarDocument)->with('success', __('messages.updated'));
    }

    public function destroy(ScholarDocument $scholarDocument)
    {
        $scholarDocument->delete();
        return redirect()->route('scholarship-documents.index')->with('success', __('messages.deleted'));
    }
}
