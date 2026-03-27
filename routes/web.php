<?php

use App\Http\Controllers\InterviewEvaluatorController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    $defaultLocale = config('app.locale');

    return redirect($defaultLocale);
});

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    Route::get('/scholarship/evaluation', [InterviewEvaluatorController::class, 'authenticateEvaluator'])->name('evaluator.authenticate');
    Route::post('/scholarship/evaluation', [InterviewEvaluatorController::class, 'authenticateEvaluator'])->name('evaluator.postAuthenticate');
    Route::get('/scholarship/evaluation/panel', [InterviewEvaluatorController::class, 'panel'])->name('evaluator.panel');
    Route::get('/scholarship/evaluation/{interviewEvaluator}', [InterviewEvaluatorController::class, 'evaluate'])->name('evaluator.evaluate');
    Route::post('/scholarship/evaluation/{interviewEvaluator}', [InterviewEvaluatorController::class, 'submitEvaluation'])->name('evaluator.evaluate.submit');
    Route::post('/scholarship/evaluation/logout', [InterviewEvaluatorController::class, 'logout'])->name('evaluator.logout');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/web_applicant.php';
require __DIR__ . '/web_admin.php';
