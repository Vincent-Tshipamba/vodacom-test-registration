<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $items = University::paginate(20);
        return view('universities.index', compact('items'));
    }

    public function create()
    {
        return view('universities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'website_url' => ['nullable', 'string', 'max:255'],
            'contact_person_name' => ['nullable', 'string', 'max:150'],
            'contact_person_phone' => ['nullable', 'string', 'max:150'],
            'contact_person_grade' => ['nullable', 'string', 'max:150'],
            'contact_email' => ['nullable', 'string', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
        ]);
        $university = University::create($data);
        return redirect()->route('universities.show', $university)->with('success', __('messages.saved'));
    }

    public function show(University $university)
    {
        return view('universities.show', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $university->update($request->only([
            'name',
            'city',
            'website_url',
            'contact_person_name',
            'contact_person_phone',
            'contact_person_grade',
            'contact_email',
            'contact_phone'
        ]));
        return redirect()->route('universities.show', $university)->with('success', __('messages.updated'));
    }

    public function edit(University $university)
    {
        return view('universities.edit', compact('university'));
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('universities.index')->with('success', __('messages.deleted'));
    }
}
