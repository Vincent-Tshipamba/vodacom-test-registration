<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AnswerOptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ScholarController;
use App\Http\Controllers\Admin\PhaseTestController;
use App\Http\Controllers\ScholarDocumentController;
use App\Http\Controllers\CandidateResponseController;
use App\Http\Controllers\AcademicYearRecordController;
use App\Http\Controllers\EvaluationCriteriaController;
use App\Http\Controllers\InterviewEvaluatorController;
use App\Http\Controllers\ApplicationDocumentController;
use App\Http\Controllers\Admin\InterviewSessionController;
use App\Http\Controllers\Admin\ScholarshipEditionController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;

Route::group(['prefix' => '{locale}/admin', 'middleware' => ['setLocale', 'auth']], function () {
    Route::post('/check-code-exetat', [CandidatController::class, 'checkCodeExetat'])->name('check.code.exetat');

    Route::resource('candidats', CandidatController::class);
    Route::get('candidats-search', [CandidatController::class, 'search'])->name('candidats.search');
    Route::patch('update-status', [CandidatController::class, 'updateStatus'])->name('status.update');

    // Web resources for scholarship management
    Route::get('applicants', [AdminApplicantController::class, 'index'])->name('admin.applicants.index');
    Route::get('applicants/{applicant}', [AdminApplicantController::class, 'show'])->name('admin.applicants.show');
    Route::post('applicants/search', [AdminApplicantController::class, 'search'])->name('admin.applicants.search');

    Route::put('application-documents/change-status', [ApplicationDocumentController::class, 'change_status'])->name('application-documents.change-status');

    Route::resource('application-documents', ApplicationDocumentController::class);
    Route::resource('scholar-documents', ScholarDocumentController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('interview-evaluators', InterviewEvaluatorController::class);

    Route::get('tests', [TestController::class, 'index'])->name('admin.tests.index');
    Route::post('phase-test', [PhaseTestController::class, 'store'])->name('admin.phase-test.store');
    Route::patch('phase-test/{phaseTest}', [PhaseTestController::class, 'update'])->name('admin.phase-test.update');

    Route::get('scholars', [ScholarController::class, 'index'])->name('admin.scholars.index');
    Route::get('scholarship-editions', [ScholarshipEditionController::class, 'index'])->name('admin.editions.index');
    Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments.index');

    Route::get('events', function () {
        return view('admin.events.index');
    })->name('admin.events.index');

    Route::get('anouncements', function () {
        return view('admin.anouncements.index');
    })->name('admin.anouncements.index');

    Route::get('chats', function () {
        return view('admin.chats.index');
    })->name('admin.chats.index');

    Route::get('interview-sessions', [InterviewSessionController::class, 'index'])->name('admin.interview-sessions.index');

    // Other resources
    Route::resource('universities', UniversityController::class);
    Route::resource('agents', AgentController::class);
    Route::resource('answer-options', AnswerOptionController::class);
    Route::resource('candidate-responses', CandidateResponseController::class);
    Route::resource('evaluation-criteria', EvaluationCriteriaController::class);
    Route::resource('academic-year-records', AcademicYearRecordController::class);

    Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
