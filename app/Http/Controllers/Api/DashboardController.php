<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FactSale;
use App\Models\DimensionTime;
use App\Models\DimensionProduct;
use App\Models\DimensionStore;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Datos simulados - reemplaza con tus consultas reales
            $salesTrend = FactSale::query()
                ->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id')
                ->select(
                    DB::raw("CONCAT(dim_tiempo.nombre_mes, ' ', dim_tiempo.anio) as period"),
                    DB::raw("SUM(monto_total) as total")
                )
                ->groupBy('dim_tiempo.anio', 'dim_tiempo.mes', 'dim_tiempo.nombre_mes')
                ->orderBy('dim_tiempo.anio')
                ->orderBy('dim_tiempo.mes')
                ->limit(12)
                ->get();

            $categoryDistribution = DimensionProduct::query()
                ->join('dw.fact_ventas', 'dim_producto.producto_id', '=', 'fact_ventas.producto_id')
                ->select(
                    'categoria',
                    DB::raw("SUM(monto_total) as total")
                )
                ->groupBy('categoria')
                ->orderByDesc('total')
                ->get();

            return response()->json([
                'total_sales' => FactSale::sum('monto_total'),
                'total_products' => FactSale::sum('cantidad_vendida'),
                'total_customers' => 1254, // Valor de ejemplo
                'avg_margin' => 22.5, // Valor de ejemplo
                'sales_trend' => [
                    'labels' => $salesTrend->pluck('period'),
                    'data' => $salesTrend->pluck('total')
                ],
                'category_distribution' => [
                    'labels' => $categoryDistribution->pluck('categoria'),
                    'data' => $categoryDistribution->pluck('total')
                ],
                'top_products' => [
                    ['name' => 'Leche Entera 1L', 'sales' => 12500, 'quantity' => 2500, 'percentage' => 12],
                    ['name' => 'Pan Integral', 'sales' => 9800, 'quantity' => 1950, 'percentage' => 9.5]
                ],
                'stores_performance' => [
                    'labels' => ['Sucursal A', 'Sucursal B', 'Sucursal C'],
                    'data' => [320000, 280000, 250000]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cargar datos del dashboard',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}