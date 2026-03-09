<?php

namespace App\Http\Controllers\Admin;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\ScholarshipEdition;
use App\Http\Controllers\Controller;
use App\Models\PhaseTest;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $currentEdition = ScholarshipEdition::getCurrentEdition();

        $baseQuery = Applicant::query()
            ->where('edition_id', $currentEdition->id)
            ->where('application_status', 'SHORTLISTED');

        $candidatsTotal = (clone $baseQuery)->count();
        $candidatsFemale = (clone $baseQuery)->where('gender', 'female')->count();
        $candidatsMale = (clone $baseQuery)->where('gender', 'male')->count();

        $candidats = (clone $baseQuery)
            ->with('application_documents')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $phaseTest = PhaseTest::withCount('questions')
            ->where('scholarship_edition_id', $currentEdition->id)
            ->first();

        $phaseQuestionsCount = (int) ($phaseTest?->questions_count ?? 0);

        return view('admin.tests.index', compact(
            'currentEdition',
            'candidats',
            'candidatsTotal',
            'candidatsFemale',
            'candidatsMale',
            'phaseTest',
            'phaseQuestionsCount'
        ));
    }
}
