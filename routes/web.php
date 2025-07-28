<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OlapController;
use App\Http\Controllers\Auth\LoginController;

// API Routes
Route::prefix('api')->middleware('api')->group(function () {
    Route::prefix('olap')->group(function () {
        Route::get('/sales', [OlapController::class, 'salesAnalysis']);
        Route::get('/sales/drill-down', [OlapController::class, 'salesDrillDown']);
        Route::get('/sales/roll-up', [OlapController::class, 'salesRollUp']);
        Route::get('/sales/pivot', [OlapController::class, 'salesPivot']);
    });
});

// Ruta de login (si necesitas autenticación)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Ruta de logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Frontend Routes
Route::get('/', function () {
    return view('app');
})->name('home'); // Removí el middleware('auth') temporalmente para pruebas

// Ruta catch-all para Vue Router
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');