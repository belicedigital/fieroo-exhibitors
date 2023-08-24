<?php
use Illuminate\Support\Facades\Route;
use Fieroo\Exhibitors\Controllers\ExhibitorController;
use Fieroo\Exhibitors\Controllers\BrandsController;
use Fieroo\Exhibitors\Controllers\CollaboratorsController;

Route::get('/compile-data', [ExhibitorController::class, 'compileData'])->name('compile-data-after-login');
Route::get('/pending-admission', [ExhibitorController::class, 'pendingAdmission'])->name('pending-admission');

Route::group(['prefix' => 'admin', 'middleware' => ['web','auth']], function() {
    Route::resource('/exhibitors', ExhibitorController::class);
    Route::get('/exhibitors-incomplete', [ExhibitorController::class, 'incompleteData']);
    Route::delete('/exhibitors-incomplete/destroy/{id}', [ExhibitorController::class, 'destroyIncomplete'])->name('exhibitors-incomplete.destroy');
    Route::post('/exhibitors/getAjaxListIncompleted', [ExhibitorController::class, 'getAjaxListIncompleted']);
    Route::post('/exhibitors/getSelectList', [ExhibitorController::class, 'getSelectList']);
    Route::post('/exhibitors/getAjaxList', [ExhibitorController::class, 'getAjaxList']);
    Route::post('/exhibitors/compile-data', [ExhibitorController::class, 'sendFormCompileData'])->name('compile-data');
    Route::group(['prefix' => 'exhibitor'], function() {
        // Route::post('/{id}/change/{field}', [ExhibitorController::class, 'changeFieldBoolean']);
        Route::get('/{id}/events', [ExhibitorController::class, 'indexEvents']);
        Route::get('/{id}/event/{event_id}/recap', [ExhibitorController::class, 'recapEvent']);
        // Route::get('/{id}/brands', [ExhibitorController::class, 'indexBrands']);
        // Route::get('/{id}/stands', [ExhibitorController::class, 'indexStands']);
        // Route::get('/{id}/stands/{stand}/edit', [ExhibitorController::class, 'editStand']);
        // Route::get('/{id}/stands/{stand}/show', [ExhibitorController::class, 'showStand']);
        // Route::patch('/stands/{stand}/update', [ExhibitorController::class, 'updateStand'])->name('code-modules.update');
        // Route::get('/{id}/download-pdf', [ExhibitorController::class, 'downloadPDF']);
        Route::get('/{id}/admit', [ExhibitorController::class, 'admit']);
        // Route::get('/{id}/reset-order', [ExhibitorController::class, 'resetOrder']);
    });

    Route::group(['prefix' => 'export'], function() {
        Route::get('/exhibitors', [ExhibitorController::class, 'exportAll']);
        Route::get('/exhibitors-incomplete', [ExhibitorController::class, 'exportIncompleted']);
        // Route::get('/exhibitor/{id}/brands', [ExhibitorController::class, 'exportBrands']);
        Route::get('/exhibitor/{id}/orders', [ExhibitorController::class, 'exportOrders']);
        // Route::get('/brands', [BrandsController::class, 'exportAll']);
    });

    // Route::resource('/brands', BrandsController::class);
    // Route::group(['prefix' => 'brand'], function() {
    //     Route::post('/{id}/toggle-status/{field}', [BrandsController::class, 'changeStatusBrand']);
    // });

    
    // Route::resource('/collaborators', CollaboratorsController::class);
    // Route::get('/collaborator/{collaborator_id}/brands', [BrandsController::class, 'getCollabratorBrands']);
});