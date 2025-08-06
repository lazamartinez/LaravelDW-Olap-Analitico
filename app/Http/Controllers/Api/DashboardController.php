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
            // Validar parámetros de fecha
            $validator = validator($request->all(), [
                'start_date' => 'sometimes|date',
                'end_date' => 'sometimes|date|after_or_equal:start_date',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }
            
            // Filtrar por fechas si vienen en el request
            $query = FactSale::query();
            
            if ($request->has('start_date')) {
                $query->whereHas('time', function($q) use ($request) {
                    $q->where('fecha', '>=', $request->start_date);
                });
            }
            
            if ($request->has('end_date')) {
                $query->whereHas('time', function($q) use ($request) {
                    $q->where('fecha', '<=', $request->end_date);
                });
            }
            
            // KPIs principales
            $kpis = [
                'total_sales' => $query->sum('monto_total'),
                'total_products' => $query->sum('cantidad_vendida'),
                'total_customers' => DB::table('dw.dim_cliente')->count(),
                'avg_margin' => $query->avg('margen_ganancia'),
            ];
            
            // Tendencias de ventas por mes
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
            
            // Distribución por categoría
            $categoryDistribution = DimensionProduct::query()
                ->join('dw.fact_ventas', 'dim_producto.producto_id', '=', 'fact_ventas.producto_id')
                ->select(
                    'categoria',
                    DB::raw("SUM(monto_total) as total")
                )
                ->groupBy('categoria')
                ->orderByDesc('total')
                ->get();
            
            // Top productos
            $topProducts = DimensionProduct::query()
                ->join('dw.fact_ventas', 'dim_producto.producto_id', '=', 'fact_ventas.producto_id')
                ->select(
                    'dim_producto.nombre',
                    'dim_producto.codigo',
                    'dim_producto.categoria',
                    DB::raw("SUM(fact_ventas.monto_total) as ventas_totales"),
                    DB::raw("SUM(fact_ventas.cantidad_vendida) as unidades_vendidas"),
                    DB::raw("AVG(fact_ventas.margen_ganancia) as margen_promedio")
                )
                ->groupBy('dim_producto.producto_id', 'dim_producto.nombre', 'dim_producto.codigo', 'dim_producto.categoria')
                ->orderByDesc('ventas_totales')
                ->limit(5)
                ->get();
            
            // Rendimiento por sucursal
            $storesPerformance = DimensionStore::query()
                ->join('dw.fact_ventas', 'dim_sucursal.sucursal_id', '=', 'fact_ventas.sucursal_id')
                ->select(
                    'dim_sucursal.nombre',
                    'dim_sucursal.provincia',
                    DB::raw("SUM(fact_ventas.monto_total) as ventas_totales"),
                    DB::raw("COUNT(DISTINCT fact_ventas.cliente_id) as clientes_unicos")
                )
                ->groupBy('dim_sucursal.sucursal_id', 'dim_sucursal.nombre', 'dim_sucursal.provincia')
                ->orderByDesc('ventas_totales')
                ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'kpis' => $kpis,
                    'sales_trend' => [
                        'labels' => $salesTrend->pluck('period'),
                        'data' => $salesTrend->pluck('total')
                    ],
                    'category_distribution' => [
                        'labels' => $categoryDistribution->pluck('categoria'),
                        'data' => $categoryDistribution->pluck('total')
                    ],
                    'top_products' => $topProducts,
                    'stores_performance' => [
                        'labels' => $storesPerformance->pluck('nombre'),
                        'data' => $storesPerformance->pluck('ventas_totales')
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
