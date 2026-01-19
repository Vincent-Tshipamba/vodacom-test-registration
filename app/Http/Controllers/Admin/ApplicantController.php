<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listApplicants = Applicant::latest()->get();

        $gridApplicants = Applicant::latest()->paginate(16);

        if (request()->has('ajax')) {
            return response()->json([
                'html' => view('admin.applicants.partials.applicants-grid', ['applicants' => $gridApplicants])->render(),
                'next_page_url' => $gridApplicants->nextPageUrl()
            ]);
        }

        return view('admin.applicants.index', compact('listApplicants', 'gridApplicants'));
    }

    /**
     * Search applicants by query
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $applicants = Applicant::when($query, function ($q) use ($query) {
            $q->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('diploma_city', 'like', "%$query%")
                ->orWhere('registration_code', 'like', "%$query%");
        })->with(['application_documents' => function ($query) {
            $query->whereIn('document_type', ['PHOTO', 'ID', 'DIPLOMA', 'RECO_LETTER']);
        }])->take(5)->get(['id', 'first_name', 'last_name', 'date_of_birth', 'phone_number', 'percentage', 'full_address', 'diploma_city', 'career_goals', 'registration_code']);

        return response()->json($applicants);
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
    public function show(String $locale, Applicant $applicant)
    {
        return view('admin.applicants.show', compact('applicant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
