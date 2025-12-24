<?php

namespace App\Http\Controllers;

use App\Models\InterviewEvaluator;
use Illuminate\Http\Request;

class InterviewEvaluatorController extends Controller
{
    public function index()
    {
        $items = InterviewEvaluator::with(['interviewSession', 'evaluator'])->paginate(20);
        return view('interview-evaluators.index', compact('items'));
    }

    public function create()
    {
        return view('interview-evaluators.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'interview_session_id' => ['required', 'exists:interview_sessions,id'],
            'evaluator_id' => ['required', 'exists:staff_profiles,id'],
        ]);
        $row = InterviewEvaluator::create($data);
        return redirect()->route('interview-evaluators.show', $row)->with('success', 'Created successfully');
    }

    public function show(InterviewEvaluator $interviewEvaluator)
    {
        $interviewEvaluator->load(['interviewSession', 'evaluator', 'scores']);
        return view('interview-evaluators.show', compact('interviewEvaluator'));
    }

    public function edit(InterviewEvaluator $interviewEvaluator)
    {
        return view('interview-evaluators.edit', compact('interviewEvaluator'));
    }

    public function update(Request $request, InterviewEvaluator $interviewEvaluator)
    {
        $data = $request->validate([
            'evaluator_id' => ['sometimes', 'exists:staff_profiles,id'],
        ]);
        $interviewEvaluator->update($data);
        return redirect()->route('interview-evaluators.show', $interviewEvaluator)->with('success', 'Updated successfully');
    }

    public function destroy(InterviewEvaluator $interviewEvaluator)
    {
        $interviewEvaluator->delete();
        return redirect()->route('interview-evaluators.index')->with('success', 'Deleted successfully');
    }
}
