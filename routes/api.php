<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SucursalController;
use App\Http\Controllers\Api\OlapController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API OLAP
Route::prefix('olap')->group(function () {
    // Carga de análisis
    Route::post('/load-analysis', [OlapController::class, 'loadAnalysis']);
    
    // Operaciones OLAP básicas
    Route::post('/slice', [OlapController::class, 'slice']);
    Route::post('/dice', [OlapController::class, 'dice']);
    Route::post('/roll-up', [OlapController::class, 'rollUp']);
    Route::post('/drill-down', [OlapController::class, 'drillDown']);
    Route::post('/pivot', [OlapController::class, 'pivot']);
    
    // Métricas predefinidas
    Route::get('/metrics', [OlapController::class, 'basicMetrics']);
    Route::get('/sales-trend', [OlapController::class, 'salesTrend']);
    Route::get('/product-performance', [OlapController::class, 'productPerformance']);
});

// API CRUD Sucursales
Route::apiResource('sucursales', SucursalController::class);
