<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    $defaultLocale = config('app.locale');

    return redirect($defaultLocale);
});

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    //
});

require __DIR__ . '/auth.php';
require __DIR__ . '/web_applicant.php';
require __DIR__ . '/web_admin.php';
