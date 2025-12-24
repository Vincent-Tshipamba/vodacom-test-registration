<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateResponseRequest;
use App\Models\CandidateResponse;
use Illuminate\Http\Request;

class CandidateResponseController extends Controller
{
    public function index()
    {
        $items = CandidateResponse::with(['session', 'question', 'selectedOption'])->paginate(20);
        return view('candidate-responses.index', compact('items'));
    }

    public function create()
    {
        return view('candidate-responses.create');
    }

    public function store(StoreCandidateResponseRequest $request)
    {
        $response = CandidateResponse::create($request->validated());
        return redirect()->route('candidate-responses.show', $response)->with('success', __('messages.saved'));
    }

    public function show(CandidateResponse $candidateResponse)
    {
        $candidateResponse->load(['session', 'question', 'selectedOption']);
        return view('candidate-responses.show', compact('candidateResponse'));
    }

    public function edit(CandidateResponse $candidateResponse)
    {
        return view('candidate-responses.edit', compact('candidateResponse'));
    }

    public function update(Request $request, CandidateResponse $candidateResponse)
    {
        $data = $request->validate([
            'selected_option_id' => ['nullable', 'exists:answer_options,id', 'required_without:text_answer'],
            'text_answer' => ['nullable', 'string', 'max:5000', 'required_without:selected_option_id'],
        ]);
        $candidateResponse->update($data);
        return redirect()->route('candidate-responses.show', $candidateResponse)->with('success', __('messages.updated'));
    }

    public function destroy(CandidateResponse $candidateResponse)
    {
        $candidateResponse->delete();
        return redirect()->route('candidate-responses.index')->with('success', __('messages.deleted'));
    }
}
