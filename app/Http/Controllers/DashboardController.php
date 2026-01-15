<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Scholar;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\ScholarshipEdition;

class DashboardController extends Controller
{
    public function index()
    {
        $applicants = Applicant::latest()->get();
        $current_edition = ScholarshipEdition::getCurrentEdition();
        $count_applicants_this_year = Applicant::where('edition_id', $current_edition->id)->count();
        $count_accepted_applicants = Applicant::where('application_status', 'ADMITTED')->where('edition_id', $current_edition->id)->count();
        $count_rejected_applicants = Applicant::where('application_status', 'REJECTED')->where('edition_id', $current_edition->id)->count();
        $count_boursiers = Scholar::count();
        $count_editions = ScholarshipEdition::count();

        $currentYear = now()->year;
        $years = range(2018, $currentYear);

        $applicantsByYear = array_fill_keys($years, 0);

        // $payments = Payment::with('academic_year_records', 'scholars')->get();

        $editions = ScholarshipEdition::withCount('applicants')
            ->whereIn('year', $years)
            ->get()
            ->groupBy(function ($edition) {
                return Carbon::parse($edition->start_date)->year;
            });

        foreach ($editions as $year => $editionsForYear) {
            if (isset($applicantsByYear[$year])) {
                $applicantsByYear[$year] = $editionsForYear->sum('applicants_count');
            }
        }
        return response()->view('admin.dashboard', compact(
            'applicants',
            'current_edition',
            'count_applicants_this_year',
            'count_accepted_applicants',
            'count_rejected_applicants',
            'count_boursiers',
            'count_editions',
            'applicantsByYear',
            'years'
        ));
    }
}
