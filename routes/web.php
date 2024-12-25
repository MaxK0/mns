<?php

use App\Http\Controllers\Admin\ApplicationController as ApplicationControllerAdmin;
use App\Http\Controllers\ApplicationController;
use App\Http\Middleware\IsAdminMiddleware as IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('applications.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('applications', ApplicationController::class)
        ->only(['index', 'show', 'create', 'store']);

    Route::middleware([IsAdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('applications', ApplicationControllerAdmin::class)
                ->except(['create', 'store']);

            Route::put('applications/{application}/status', [ApplicationControllerAdmin::class, 'updateStatus'])->name('applications.status.update');
            Route::delete('applications/{application}/destroyWithoutRedirect', [ApplicationControllerAdmin::class, 'destroyWithoutRedirect'])->name('applications.destroyWithoutRedirect');
        });
});

require __DIR__.'/auth.php';
