<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScholarController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\TestSessionController;
use App\Http\Controllers\AnswerOptionController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\InterviewSessionController;
use App\Http\Controllers\CandidateResponseController;
use App\Http\Controllers\AcademicYearRecordController;
use App\Http\Controllers\EvaluationCriteriaController;
use App\Http\Controllers\InterviewEvaluatorController;
use App\Http\Controllers\ScholarshipEditionController;
use App\Http\Controllers\ApplicationDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScholarshipDocumentController;
use App\Models\Applicant;

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::post('/check-code-exetat', [CandidatController::class, 'checkCodeExetat'])->name('check.code.exetat');

    Route::resource('candidats', CandidatController::class);
    Route::get('candidats-search', [CandidatController::class, 'search'])->name('candidats.search');
    Route::patch('update-status', [CandidatController::class, 'updateStatus'])->name('status.update');

    // Web resources for scholarship management
    Route::resource('applicants', ApplicantController::class);
    Route::resource('application-documents', ApplicationDocumentController::class);
    Route::resource('scholarship-documents', ScholarshipDocumentController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('interview-evaluators', InterviewEvaluatorController::class);

    // Other resources
    Route::resource('universities', UniversityController::class);
    Route::resource('staff-profiles', StaffProfileController::class);
    Route::resource('scholarship-editions', ScholarshipEditionController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('answer-options', AnswerOptionController::class);
    Route::resource('test-sessions', TestSessionController::class);
    Route::resource('candidate-responses', CandidateResponseController::class);
    Route::resource('evaluation-criteria', EvaluationCriteriaController::class);
    Route::resource('scholars', ScholarController::class);
    Route::resource('academic-year-records', AcademicYearRecordController::class);
    Route::resource('interview-sessions', InterviewSessionController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');
});
