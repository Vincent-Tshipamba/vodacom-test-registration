<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhaseTest;
use Illuminate\Http\Request;

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
            'edition_id' => $request->edition_id,
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
    public function update(Request $request, PhaseTest $phaseTest)
    {
        $phaseTest->update(
            $request->only([
                'duration',
                'start_time',
                'end_time',
                'total_questions',
                'passing_score',
            ])
        );

        return response()->json();
    }
}
