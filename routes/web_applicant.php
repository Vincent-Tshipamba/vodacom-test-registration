<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/', [ApplicantController::class, 'home'])->name('index');

    Route::get('/scholarship/test', [ApplicantController::class, 'test'])->name('scholarship.test');
    Route::post('/scholarship/test', [ApplicantController::class, 'authenticateApplicants'])->name('scholarship.authenticate');
    Route::get('/scholarship/test/instructions', [ApplicantController::class, 'instructions'])->name('scholarship.instructions');

    Route::get('/scholarship/register', [ApplicantController::class, 'register'])->name('scholarship.register');
    // ->middleware('checkSubmission');

    Route::post('/scholarship/register', [ApplicantController::class, 'store'])->name('scholarship.register.submit');

    Route::get('success', function () {
        return view('success');
    })->name('success');
});
