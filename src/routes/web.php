<?php
use Illuminate\Support\Facades\Route;
use Fieroo\Exhibitors\Controllers\ExhibitorController;

Route::group(['middleware' => ['web','auth']], function() {
    Route::get('/compile-data', [ExhibitorController::class, 'compileData'])->name('compile-data-after-login');
    Route::get('/pending-admission', [ExhibitorController::class, 'pendingAdmission'])->name('pending-admission');

    Route::group(['prefix' => 'admin'], function() {
        Route::resource('/exhibitors', ExhibitorController::class);
        Route::get('/exhibitors-incomplete', [ExhibitorController::class, 'incompleteData']);
        Route::delete('/exhibitors-incomplete/destroy/{id}', [ExhibitorController::class, 'destroyIncomplete'])->name('exhibitors-incomplete.destroy');
        Route::delete('/exhibitors-incomplete/send-remarketing/{id}', [ExhibitorController::class, 'sendRemarketing'])->name('exhibitors-incomplete.send-remarketing');
        Route::post('/exhibitors/getAjaxListIncompleted', [ExhibitorController::class, 'getAjaxListIncompleted']);
        Route::post('/exhibitors/getSelectList', [ExhibitorController::class, 'getSelectList']);
        Route::post('/exhibitors/getAjaxList', [ExhibitorController::class, 'getAjaxList']);
        Route::post('/exhibitors/compile-data', [ExhibitorController::class, 'sendFormCompileData'])->name('compile-data');
        Route::group(['prefix' => 'exhibitor'], function() {
            Route::get('/{id}/events', [ExhibitorController::class, 'indexEvents']);
            Route::get('/{id}/event/{event_id}/recap', [ExhibitorController::class, 'recapEvent']);
            Route::get('/{id}/admit', [ExhibitorController::class, 'admit']);
        });

        Route::group(['prefix' => 'export'], function() {
            Route::get('/exhibitors', [ExhibitorController::class, 'exportAll']);
            Route::get('/exhibitors-incomplete', [ExhibitorController::class, 'exportIncompleted']);
            Route::get('/exhibitor/{id}/orders', [ExhibitorController::class, 'exportOrders']);
        });
    });
});