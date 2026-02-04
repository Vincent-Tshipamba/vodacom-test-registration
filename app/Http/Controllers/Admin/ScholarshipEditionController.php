<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScholarshipEdition;
use Illuminate\Http\Request;

class ScholarshipEditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.editions.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ScholarshipEdition $scholarshipEdition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScholarshipEdition $scholarshipEdition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScholarshipEdition $scholarshipEdition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScholarshipEdition $scholarshipEdition)
    {
        //
    }
}
