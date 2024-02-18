<?php

use Illuminate\Support\Facades\Route;
use Susheelbhai\Laratrack\Http\Controllers\TrackingController;

Route::prefix('laratrack')->name('laratrack.')->middleware('web')->group(function(){
    Route::get('index', [TrackingController::class, 'index'])->name('index');
    Route::post('command', [TrackingController::class, 'command'])->name('command');
    Route::post('dumpAllModel', [TrackingController::class, 'dumpAllModel'])->name('dumpAllModel');
    Route::post('dumpModel', [TrackingController::class, 'dumpModel'])->name('dumpModel');
    Route::post('exportModel', [TrackingController::class, 'exportModel'])->name('exportModel');
    Route::post('getValue', [TrackingController::class, 'getValue'])->name('getValue');
    Route::post('setEnvironmentValue', [TrackingController::class, 'setEnvironmentValue'])->name('setEnvironmentValue');
    Route::post('setConfigValue', [TrackingController::class, 'setConfigValue'])->name('setConfigValue');
    Route::post('dumpDB', [TrackingController::class, 'dumpDB'])->name('dumpDB');
    
});
