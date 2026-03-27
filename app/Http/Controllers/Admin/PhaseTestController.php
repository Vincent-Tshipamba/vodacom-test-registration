<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhaseTest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PhaseTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $phaseTest = PhaseTest::create([
            'scholarship_edition_id' => $request->edition_id,
            ...$request->only([
                'duration',
                'start_time',
                'end_time',
                'total_questions',
                'passing_score',
            ])
        ]);

        return response()->json([
            'id' => $phaseTest->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $locale, Request $request, PhaseTest $phaseTest)
    {
        $payload = $request->only([
            'duration',
            'start_time',
            'end_time',
            'total_questions',
            'passing_score',
            'status',
        ]);

        if (($payload['status'] ?? null) === 'IN_PROGRESS' && $phaseTest->questions()->count() < 1) {
            $message = __('Impossible de lancer la phase sans question.');

            if ($request->expectsJson()) {
                throw ValidationException::withMessages(['status' => $message]);
            }

            return back()->withErrors(['status' => $message]);
        }

        $phaseTest->update(
            $payload
        );

        if ($request->expectsJson()) {
            return response()->json();
        }

        return back()->with('success', __('messages.updated'));
    }
}
