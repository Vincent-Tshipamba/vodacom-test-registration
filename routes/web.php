<?php

use App\Models\Candidat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidatController;

Route::get('/', function () {
    return response()
        ->view('index')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
});
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

require __DIR__ . '/auth.php';
