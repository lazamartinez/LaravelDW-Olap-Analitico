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
    Route::post('/query', OlapController::class);
    Route::get('/metrics', [OlapController::class, 'basicMetrics']);
});

// API CRUD Sucursales
Route::apiResource('sucursales', SucursalController::class);

// Otras rutas API...