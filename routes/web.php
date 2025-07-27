<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OlapController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::prefix('olap')->group(function () {
        Route::get('/sales', [OlapController::class, 'salesAnalysis']);
        Route::get('/sales/drill-down', [OlapController::class, 'salesDrillDown']);
        Route::get('/sales/roll-up', [OlapController::class, 'salesRollUp']);
        Route::get('/sales/pivot', [OlapController::class, 'salesPivot']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
