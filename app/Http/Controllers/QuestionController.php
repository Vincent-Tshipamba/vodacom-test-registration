<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $items = Question::with('options')->paginate(20);
        return view('questions.index', compact('items'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:50'],
            'question_text' => ['required', 'string'],
            'question_type' => ['nullable', 'string', 'in:MCQ,TEXT'],
            'ponderation' => ['nullable', 'integer', 'min:1'],
        ]);
        $q = Question::create($data);
        return redirect()->route('questions.show', $q)->with('success', __('messages.saved'));
    }

    public function show(Question $question)
    {
        $question->load('options');
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'category' => ['sometimes', 'string', 'max:50'],
            'question_text' => ['sometimes', 'string'],
            'question_type' => ['sometimes', 'string', 'in:MCQ,TEXT'],
            'ponderation' => ['sometimes', 'integer', 'min:1'],
        ]);
        $question->update($data);
        return redirect()->route('questions.show', $question)->with('success', __('messages.updated'));
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', __('messages.deleted'));
    }
}
