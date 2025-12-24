<?php

namespace App\Http\Controllers;

use App\Models\AnswerOption;
use Illuminate\Http\Request;

class AnswerOptionController extends Controller
{
    public function index()
    {
        $items = AnswerOption::with('question')->paginate(20);
        return view('answer-options.index', compact('items'));
    }

    public function create()
    {
        return view('answer-options.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => ['required', 'exists:questions,id'],
            'option_text' => ['required', 'string'],
            'is_correct' => ['nullable', 'boolean'],
        ]);
        $option = AnswerOption::create($data);
        return redirect()->route('answer-options.show', $option)->with('success', __('messages.saved'));
    }

    public function show(AnswerOption $answerOption)
    {
        $answerOption->load('question');
        return view('answer-options.show', compact('answerOption'));
    }

    public function edit(AnswerOption $answerOption)
    {
        return view('answer-options.edit', compact('answerOption'));
    }

    public function update(Request $request, AnswerOption $answerOption)
    {
        $data = $request->validate([
            'option_text' => ['sometimes', 'string'],
            'is_correct' => ['nullable', 'boolean'],
        ]);
        $answerOption->update($data);
        return redirect()->route('answer-options.show', $answerOption)->with('success', __('messages.updated'));
    }

    public function destroy(AnswerOption $answerOption)
    {
        $answerOption->delete();
        return redirect()->route('answer-options.index')->with('success', __('messages.deleted'));
    }
}
