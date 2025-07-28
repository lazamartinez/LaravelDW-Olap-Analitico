<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OlapController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

// API Routes
Route::prefix('api')->middleware('api')->group(function () {
    Route::prefix('olap')->group(function () {
        Route::get('/sales', [OlapController::class, 'salesAnalysis']);
        Route::get('/sales/drill-down', [OlapController::class, 'salesDrillDown']);
        Route::get('/sales/roll-up', [OlapController::class, 'salesRollUp']);
        Route::get('/sales/pivot', [OlapController::class, 'salesPivot']);
    });
});

// Auth Routes
// Auth::routes(['register' => false]); // Desactiva el registro si no lo necesitas

// Frontend Routes
Route::get('/', function () {
    return view('app');
})->middleware('auth')->name('home');

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*')->middleware('auth');