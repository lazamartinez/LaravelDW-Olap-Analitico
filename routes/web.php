<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SucursalController;
use Illuminate\Support\Facades\Auth;

// Ruta principal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para Sucursales
Route::resource('sucursales', SucursalController::class);

// Rutas de autenticación (si las necesitas)
Auth::routes();