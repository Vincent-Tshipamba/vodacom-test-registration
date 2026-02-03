<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $items = Agent::with('user')->paginate(20);
        return view('staff-profiles.index', compact('items'));
    }

    public function create()
    {
        return view('staff-profiles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:100'],
        ]);
        $profile = Agent::create($data);
        return redirect()->route('staff-profiles.show', $profile)->with('success', __('messages.saved'));
    }

    public function show(Agent $agent)
    {
        $agent->load('user');
        return view('staff-profiles.show', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:100'],
        ]);
        $agent->update($data);
        return redirect()->route('staff-profiles.show', $agent)->with('success', __('messages.updated'));
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('staff-profiles.index')->with('success', __('messages.deleted'));
    }
}
