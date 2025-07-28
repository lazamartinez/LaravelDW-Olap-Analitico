<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SucursalController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('sucursales', SucursalController::class);

// Ruta para Vue (SPA)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$'); // Excluye rutas que empiecen con 'api'

// Ruta API separada
Route::prefix('api')->group(function () {
    Route::apiResource('sucursales', SucursalController::class);
});