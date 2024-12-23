<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('applications.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('applications', ApplicationController::class)
        ->only(['index', 'show', 'create', 'store']);
});

require __DIR__.'/auth.php';
