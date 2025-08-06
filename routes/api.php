<?php

use Illuminate\Support\Facades\Route;
use App\Models\FactSale;

// Ruta accesible sin autenticación
Route::get('/dashboard-data', function () {
    try {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_sales' => FactSale::sum('monto_total') ?? 0,
                'total_products' => FactSale::sum('cantidad_vendida') ?? 0,
                'total_customers' => 1254, // Valor de ejemplo
                'avg_margin' => 22.5, // Valor de ejemplo
                'sales_trend' => [
                    'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    'data' => [65000, 59000, 80000, 81000, 56000, 55000]
                ],
                'category_distribution' => [
                    'labels' => ['Alimentos', 'Bebidas', 'Limpieza'],
                    'data' => [35, 25, 20]
                ]
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard-data', [DashboardController::class, 'index']);
});