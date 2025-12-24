<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearRecord;
use Illuminate\Http\Request;

class AcademicYearRecordController extends Controller
{
    public function index()
    {
        $items = AcademicYearRecord::with(['scholar'])->paginate(20);
        return view('academic-year-records.index', compact('items'));
    }

    public function create()
    {
        return view('academic-year-records.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'scholar_id' => ['required', 'exists:scholars,id'],
            'academic_year_label' => ['required', 'string', 'max:20'],
            'academic_level' => ['required', 'string', 'max:20'],
            'registration_proof_submitted' => ['nullable', 'boolean'],
            'scholarship_paid' => ['nullable', 'boolean'],
            'payment_proof_submitted' => ['nullable', 'boolean'],
            'final_result' => ['nullable', 'string', 'in:PENDING,PASS,FAIL'],
        ]);
        $record = AcademicYearRecord::create($data);
        return redirect()->route('academic-year-records.show', $record)->with('success', __('messages.saved'));
    }

    public function show(AcademicYearRecord $academicYearRecord)
    {
        $academicYearRecord->load(['scholar', 'documents', 'payments']);
        return view('academic-year-records.show', compact('academicYearRecord'));
    }

    public function edit(AcademicYearRecord $academicYearRecord)
    {
        return view('academic-year-records.edit', compact('academicYearRecord'));
    }

    public function update(Request $request, AcademicYearRecord $academicYearRecord)
    {
        $data = $request->validate([
            'academic_year_label' => ['sometimes', 'string', 'max:20'],
            'academic_level' => ['sometimes', 'string', 'max:20'],
            'registration_proof_submitted' => ['nullable', 'boolean'],
            'scholarship_paid' => ['nullable', 'boolean'],
            'payment_proof_submitted' => ['nullable', 'boolean'],
            'final_result' => ['sometimes', 'string', 'in:PENDING,PASS,FAIL'],
        ]);
        $academicYearRecord->update($data);
        return redirect()->route('academic-year-records.show', $academicYearRecord)->with('success', __('messages.updated'));
    }

    public function destroy(AcademicYearRecord $academicYearRecord)
    {
        $academicYearRecord->delete();
        return redirect()->route('academic-year-records.index')->with('success', __('messages.deleted'));
    }
}
