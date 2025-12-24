<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/', [ApplicantController::class, 'home'])->name('index');

    Route::get('/scholarship/register', [ApplicantController::class, 'register'])->name('scholarship.register');
    // ->middleware('checkSubmission');

    Route::post('/scholarship/register', [ApplicantController::class, 'store'])->name('scholarship.register.submit');

    Route::get('success', function () {
        return view('success');
    })->name('success');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
