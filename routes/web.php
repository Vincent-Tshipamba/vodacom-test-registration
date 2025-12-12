<?php

use App\Models\Candidat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidatController;

Route::fallback(function () {
    $defaultLocale = config('app.locale');

    return redirect($defaultLocale);
});

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');
    
    Route::get('/scholarship/register', function () {
        return response()
            ->view('registration-form')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    })->name('scholarship.register');
    // ->middleware('checkSubmission');
    
    Route::get('success', function () {
        return view('success');
    })->name('success');
    
    Route::post('/check-code-exetat', [CandidatController::class, 'checkCodeExetat'])->name('check.code.exetat');
    
    Route::resource('candidats', CandidatController::class);
    Route::get('candidats-search', [CandidatController::class, 'search'])->name('candidats.search');
    Route::patch('update-status', [CandidatController::class, 'updateStatus'])->name('status.update');
    
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
