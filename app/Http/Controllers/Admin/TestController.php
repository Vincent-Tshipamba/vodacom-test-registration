<?php

namespace App\Http\Controllers\Admin;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\ScholarshipEdition;
use App\Http\Controllers\Controller;
use App\Models\PhaseTest;

class TestController extends Controller
{
    public function index()
    {
        $currentEdition = ScholarshipEdition::getCurrentEdition();

        $candidats = Applicant::where('edition_id', $currentEdition->id)
            ->where('application_status', 'SHORTLISTED')
            ->get();

        $candidatsFemale = Applicant::where('edition_id', $currentEdition->id)
            ->where('application_status', 'SHORTLISTED')
            ->where('gender', 'female')
            ->get();

        $candidatsMale = Applicant::where('edition_id', $currentEdition->id)
            ->where('application_status', 'SHORTLISTED')
            ->where('gender', 'male')
            ->get();

        $phaseTest = PhaseTest::where('scholarship_edition_id', $currentEdition->id)
            ->first();

        return view('admin.tests.index', compact('currentEdition', 'candidats', 'candidatsFemale', 'candidatsMale', 'phaseTest'));
    }
}
