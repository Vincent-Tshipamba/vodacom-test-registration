<?php

use App\Models\Candidat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationDocumentController;
use App\Http\Controllers\ScholarshipDocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InterviewEvaluatorController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\ScholarshipEditionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerOptionController;
use App\Http\Controllers\TestSessionController;
use App\Http\Controllers\CandidateResponseController;
use App\Http\Controllers\EvaluationCriteriaController;
use App\Http\Controllers\ScholarController;
use App\Http\Controllers\AcademicYearRecordController;
use App\Http\Controllers\InterviewSessionController;

Route::fallback(function () {
    $defaultLocale = config('app.locale');

    return redirect($defaultLocale);
});

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/', [ApplicantController::class, 'home'])->name('index');

    Route::get('/scholarship/register', [ApplicantController::class, 'register'])->name('scholarship.register');
    // ->middleware('checkSubmission');

    Route::post('/scholarship/register', [ApplicantController::class, 'store'])->name('scholarship.register.submit');

    Route::get('success', function () {
        return view('success');
    })->name('success');

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

    Route::get('/dashboard', function () {
        $candidats = Candidat::latest()->get();
        return view('dashboard', compact('candidats'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
