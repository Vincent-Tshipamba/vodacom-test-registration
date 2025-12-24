<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestSessionRequest;
use App\Models\TestSession;
use Illuminate\Http\Request;

class TestSessionController extends Controller
{
    public function index()
    {
        $items = TestSession::with('applicant')->paginate(20);
        return view('test-sessions.index', compact('items'));
    }

    public function create()
    {
        return view('test-sessions.create');
    }

    public function store(StoreTestSessionRequest $request)
    {
        $session = TestSession::create($request->validated());
        return redirect()->route('test-sessions.show', $session)->with('success', __('messages.saved'));
    }

    public function show(TestSession $testSession)
    {
        $testSession->load(['applicant', 'responses']);
        return view('test-sessions.show', compact('testSession'));
    }

    public function edit(TestSession $testSession)
    {
        return view('test-sessions.edit', compact('testSession'));
    }

    public function update(Request $request, TestSession $testSession)
    {
        $data = $request->validate([
            'finished_at' => ['sometimes', 'date', 'after_or_equal:started_at'],
            'total_score' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'is_passed' => ['sometimes', 'boolean'],
        ]);
        $testSession->update($data);
        return redirect()->route('test-sessions.show', $testSession)->with('success', __('messages.updated'));
    }

    public function destroy(TestSession $testSession)
    {
        $testSession->delete();
        return redirect()->route('test-sessions.index')->with('success', __('messages.deleted'));
    }
}
