<?php

namespace App\Http\Controllers;

use App\Models\InterviewSession;
use Illuminate\Http\Request;

class InterviewSessionController extends Controller
{
    public function index()
    {
        $items = InterviewSession::with(['applicant', 'evaluators'])->paginate(20);
        return view('interview-sessions.index', compact('items'));
    }

    public function create()
    {
        return view('interview-sessions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'applicant_id' => ['required', 'exists:applicants,id'],
            'scheduled_at' => ['required', 'date'],
            'final_average_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'decision_comment' => ['nullable', 'string'],
        ]);
        $session = InterviewSession::create($data);
        return redirect()->route('interview-sessions.show', $session)->with('success', __('messages.saved'));
    }

    public function show(InterviewSession $interviewSession)
    {
        $interviewSession->load(['applicant', 'evaluators.scores']);
        return view('interview-sessions.show', compact('interviewSession'));
    }

    public function update(Request $request, InterviewSession $interviewSession)
    {
        $data = $request->validate([
            'scheduled_at' => ['sometimes', 'date'],
            'final_average_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'decision_comment' => ['nullable', 'string'],
        ]);
        $interviewSession->update($data);
        return redirect()->route('interview-sessions.show', $interviewSession)->with('success', __('messages.updated'));
    }

    public function destroy(InterviewSession $interviewSession)
    {
        $interviewSession->delete();
        return redirect()->route('interview-sessions.index')->with('success', __('messages.deleted'));
    }
}
