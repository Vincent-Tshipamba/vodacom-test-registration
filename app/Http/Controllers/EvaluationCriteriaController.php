<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    public function index()
    {
        $items = EvaluationCriteria::paginate(20);
        return view('evaluation-criteria.index', compact('items'));
    }

    public function create()
    {
        return view('evaluation-criteria.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'edition_id' => ['required', 'exists:scholarship_editions,id'],
            'criteria_name' => ['required', 'string', 'max:100'],
            'max_points' => ['nullable', 'integer', 'min:1'],
        ]);
        $criteria = EvaluationCriteria::create($data);
        return redirect()->route('evaluation-criteria.show', $criteria)->with('success', __('messages.saved'));
    }

    public function show(EvaluationCriteria $evaluationCriteria)
    {
        return view('evaluation-criteria.show', compact('evaluationCriteria'));
    }

    public function edit(EvaluationCriteria $evaluationCriteria)
    {
        return view('evaluation-criteria.edit', compact('evaluationCriteria'));
    }

    public function update(Request $request, EvaluationCriteria $evaluationCriteria)
    {
        $data = $request->validate([
            'criteria_name' => ['sometimes', 'string', 'max:100'],
            'max_points' => ['sometimes', 'integer', 'min:1'],
        ]);
        $evaluationCriteria->update($data);
        return redirect()->route('evaluation-criteria.show', $evaluationCriteria)->with('success', __('messages.updated'));
    }

    public function destroy(EvaluationCriteria $evaluationCriteria)
    {
        $evaluationCriteria->delete();
        return redirect()->route('evaluation-criteria.index')->with('success', __('messages.deleted'));
    }
}
