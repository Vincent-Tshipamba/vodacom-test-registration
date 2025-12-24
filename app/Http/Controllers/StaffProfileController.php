<?php

namespace App\Http\Controllers;

use App\Models\StaffProfile;
use Illuminate\Http\Request;

class StaffProfileController extends Controller
{
    public function index()
    {
        $items = StaffProfile::with('user')->paginate(20);
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
        $profile = StaffProfile::create($data);
        return redirect()->route('staff-profiles.show', $profile)->with('success', __('messages.saved'));
    }

    public function show(StaffProfile $staffProfile)
    {
        $staffProfile->load('user');
        return view('staff-profiles.show', compact('staffProfile'));
    }

    public function update(Request $request, StaffProfile $staffProfile)
    {
        $data = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:100'],
        ]);
        $staffProfile->update($data);
        return redirect()->route('staff-profiles.show', $staffProfile)->with('success', __('messages.updated'));
    }

    public function destroy(StaffProfile $staffProfile)
    {
        $staffProfile->delete();
        return redirect()->route('staff-profiles.index')->with('success', __('messages.deleted'));
    }
}
