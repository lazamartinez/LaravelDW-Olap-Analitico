<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OlapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OlapController extends Controller
{
    protected $olapService;

    public function __construct(OlapService $olapService)
    {
        $this->olapService = $olapService;
        $this->middleware('auth:sanctum')->except(['basicMetrics']);
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'dimension' => 'required|in:producto,tiempo,sucursal,cliente',
            'metric' => 'required|in:monto_total,cantidad_vendida,margen_ganancia',
            'timeLevel' => 'required_if:dimension,tiempo|in:dia,mes,trimestre,anio',
            'filters' => 'sometimes|array',
            'filters.*.field' => 'required_with:filters|string',
            'filters.*.operator' => 'required_with:filters|in:=,>,<,>=,<=,<>,LIKE',
            'filters.*.value' => 'required_with:filters',
        ]);

        $result = $this->olapService->executeQuery($validated);

        return response()->json([
            'success' => true,
            'data' => $result,
            'metadata' => [
                'dimension' => $validated['dimension'],
                'metric' => $validated['metric'],
                'record_count' => count($result),
                'generated_at' => now()->toDateTimeString()
            ]
        ]);
    }

    public function basicMetrics()
    {
        return response()->json([
            'total_sales' => DB::selectOne("SELECT SUM(monto_total) FROM dw.fact_ventas")->sum,
            'total_products' => DB::selectOne("SELECT COUNT(*) FROM dw.dim_producto")->count,
            'total_stores' => DB::selectOne("SELECT COUNT(*) FROM dw.dim_sucursal WHERE activa = true")->count,
            'avg_sale' => DB::selectOne("SELECT AVG(monto_total) FROM dw.fact_ventas")->avg
        ]);
    }
}
