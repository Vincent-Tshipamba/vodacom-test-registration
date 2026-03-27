<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/', [ApplicantController::class, 'home'])->name('index');

    Route::get('/scholarship/test', [ApplicantController::class, 'test'])->name('scholarship.test');
    Route::post('/scholarship/test', [ApplicantController::class, 'authenticateApplicants'])->name('scholarship.authenticate');
    Route::get('/scholarship/test/instructions', [ApplicantController::class, 'instructions'])->name('scholarship.instructions');
    Route::get('/scholarship/test/submitted', [ApplicantController::class, 'submitted'])->name('scholarship.exam.submitted');
    Route::post('/scholarship/test/start', [ApplicantController::class, 'startExam'])->name('scholarship.exam.start');
    Route::post('/scholarship/test/save', [ApplicantController::class, 'saveExamProgress'])->name('scholarship.exam.save');
    Route::post('/scholarship/test/violation', [ApplicantController::class, 'registerExamViolation'])->name('scholarship.exam.violation');
    Route::post('/scholarship/test/submit', [ApplicantController::class, 'submitExam'])->name('scholarship.exam.submit');

    Route::get('/scholarship/register', [ApplicantController::class, 'register'])->name('scholarship.register');
    // ->middleware('checkSubmission');

    Route::post('/scholarship/register', [ApplicantController::class, 'store'])->name('scholarship.register.submit');

    Route::get('success', function () {
        return view('success');
    })->name('success');
});
