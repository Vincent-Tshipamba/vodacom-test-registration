<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipEdition;
use Illuminate\Http\Request;

class ScholarshipEditionController extends Controller
{
    public function index()
    {
        $items = ScholarshipEdition::paginate(20);
        return view('scholarship-editions.index', compact('items'));
    }

    public function create()
    {
        return view('scholarship-editions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer'],
            'scholar_quota' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:OPEN,CLOSED'],
        ]);
        $edition = ScholarshipEdition::create($data);
        return redirect()->route('scholarship-editions.show', $edition)->with('success', __('messages.saved'));
    }

    public function show(ScholarshipEdition $scholarshipEdition)
    {
        return view('scholarship-editions.show', compact('scholarshipEdition'));
    }

    public function update(Request $request, ScholarshipEdition $scholarshipEdition)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:100'],
            'year' => ['sometimes', 'integer'],
            'scholar_quota' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
            'status' => ['sometimes', 'string', 'in:OPEN,CLOSED'],
        ]);
        $scholarshipEdition->update($data);
        return redirect()->route('scholarship-editions.show', $scholarshipEdition)->with('success', __('messages.updated'));
    }

    public function destroy(ScholarshipEdition $scholarshipEdition)
    {
        $scholarshipEdition->delete();
        return redirect()->route('scholarship-editions.index')->with('success', __('messages.deleted'));
    }
}
