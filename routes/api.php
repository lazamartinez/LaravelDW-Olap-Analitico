<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SucursalController;
use App\Http\Controllers\Api\OlapController;
use App\Http\Controllers\EtlController;

// Rutas públicas
Route::get('/dashboard-data', [DashboardController::class, 'index']);

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Sucursales CRUD
    Route::apiResource('sucursales', SucursalController::class);
    Route::get('sucursales/{id}/metrics', [SucursalController::class, 'metrics']);
    
    // Operaciones OLAP
    Route::prefix('olap')->group(function () {
        Route::post('slice', [OlapController::class, 'slice']);
        Route::post('dice', [OlapController::class, 'dice']);
        Route::post('roll-up', [OlapController::class, 'rollUp']);
        Route::post('drill-down', [OlapController::class, 'drillDown']);
        Route::post('pivot', [OlapController::class, 'pivot']);
        Route::post('load-analysis', [OlapController::class, 'loadAnalysis']);
    });
    
    // ETL
    Route::post('etl/run', [EtlController::class, 'runEtlProcess']);
});