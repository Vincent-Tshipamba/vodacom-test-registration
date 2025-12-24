<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarController extends Controller
{
    public function index()
    {
        $items = Scholar::with(['applicant', 'university'])->paginate(20);
        return view('scholars.index', compact('items'));
    }

    public function create()
    {
        return view('scholars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'applicant_id' => ['required', 'exists:applicants,id'],
            'university_id' => ['required', 'exists:universities,id'],
            'matricule' => ['required', 'string', 'max:50', 'unique:scholars,matricule'],
            'chosen_field' => ['required', 'string', 'max:100'],
            'status' => ['nullable', 'string', Rule::in(['ACTIVE', 'SUSPENDED', 'ALUMNI'])],
        ]);
        $scholar = Scholar::create($data);
        return redirect()->route('scholars.show', $scholar)->with('success', __('messages.saved'));
    }

    public function show(Scholar $scholar)
    {
        $scholar->load(['applicant', 'university', 'academicYears']);
        return view('scholars.show', compact('scholar'));
    }

    public function update(Request $request, Scholar $scholar)
    {
        $data = $request->validate([
            'university_id' => ['sometimes', 'exists:universities,id'],
            'matricule' => ['sometimes', 'string', 'max:50', 'unique:scholars,matricule,' . $scholar->id],
            'chosen_field' => ['sometimes', 'string', 'max:100'],
            'status' => ['sometimes', 'string', Rule::in(['ACTIVE', 'SUSPENDED', 'ALUMNI'])],
        ]);
        $scholar->update($data);
        return redirect()->route('scholars.show', $scholar)->with('success', __('messages.updated'));
    }

    public function destroy(Scholar $scholar)
    {
        $scholar->delete();
        return redirect()->route('scholars.index')->with('success', __('messages.deleted'));
    }
}
