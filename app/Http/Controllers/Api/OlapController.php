<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FactSale;
use App\Models\DimensionTime;
use App\Models\DimensionProduct;
use App\Models\DimensionStore;
use Illuminate\Support\Facades\DB;

class OlapController extends Controller
{
    public function loadAnalysis(Request $request)
    {
        $type = $request->input('analysis_type');
        $html = '';

        switch ($type) {
            case 'sales':
                $html = $this->salesAnalysisView();
                break;
            case 'products':
                $html = $this->productsAnalysisView();
                break;
            case 'customers':
                $html = $this->customersAnalysisView();
                break;
            case 'geo':
                $html = $this->geoAnalysisView();
                break;
            case 'stores':
                $html = $this->storesAnalysisView();
                break;
            case 'custom':
                $html = $this->customAnalysisView();
                break;
            default:
                $html = '<div class="alert alert-warning">Tipo de análisis no reconocido</div>';
        }

        return response()->json(['html' => $html]);
    }

    protected function salesAnalysisView()
    {
        // Datos para dropdowns
        $timeDimensions = [
            'day' => 'Día',
            'week' => 'Semana',
            'month' => 'Mes',
            'quarter' => 'Trimestre',
            'year' => 'Año'
        ];

        $metrics = [
            'monto_total' => 'Ventas Totales',
            'cantidad_vendida' => 'Unidades Vendidas',
            'margen_ganancia' => 'Margen de Ganancia'
        ];

        // Consulta OLAP de ejemplo: Ventas por mes
        $salesTrend = FactSale::query()
            ->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id')
            ->select(
                DB::raw('dim_tiempo.anio as year'),
                DB::raw('dim_tiempo.mes as month'),
                DB::raw('SUM(monto_total) as total_sales'),
                DB::raw('SUM(cantidad_vendida) as total_quantity')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->limit(12)
            ->get();

        return view('olap.analysis.sales', compact('timeDimensions', 'metrics', 'salesTrend'))->render();
    }

    protected function productsAnalysisView()
    {
        // Lógica similar para productos
        return view('olap.analysis.products')->render();
    }

    public function slice(Request $request)
    {
        // Operación SLICE: Seleccionar un subconjunto del cubo con una dimensión fija
        $dimension = $request->input('dimension');
        $value = $request->input('value');

        $query = FactSale::query()
            ->with(['time', 'product', 'store', 'customer']);

        switch ($dimension) {
            case 'time':
                $query->whereHas('time', function ($q) use ($value) {
                    $q->where('mes', $value['month'])->where('anio', $value['year']);
                });
                break;
            case 'product':
                $query->whereHas('product', function ($q) use ($value) {
                    $q->where('categoria', $value['category']);
                });
                break;
            case 'store':
                $query->whereHas('store', function ($q) use ($value) {
                    $q->where('sucursal_id', $value['store_id']);
                });
                break;
        }

        $data = $query->take(1000)->get();

        return response()->json([
            'operation' => 'slice',
            'dimension' => $dimension,
            'value' => $value,
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    public function dice(Request $request)
    {
        // Operación DICE: Seleccionar subconjunto en múltiples dimensiones
        $filters = $request->input('filters');

        $query = FactSale::query()->with(['time', 'product', 'store', 'customer']);

        foreach ($filters as $filter) {
            switch ($filter['dimension']) {
                case 'time':
                    $query->whereHas('time', function ($q) use ($filter) {
                        if (isset($filter['year'])) {
                            $q->where('anio', $filter['year']);
                        }
                        if (isset($filter['quarter'])) {
                            $q->where('trimestre', $filter['quarter']);
                        }
                    });
                    break;
                case 'product':
                    $query->whereHas('product', function ($q) use ($filter) {
                        if (isset($filter['category'])) {
                            $q->where('categoria', $filter['category']);
                        }
                    });
                    break;
                case 'store':
                    $query->whereHas('store', function ($q) use ($filter) {
                        if (isset($filter['region'])) {
                            $q->where('provincia', $filter['region']);
                        }
                    });
                    break;
            }
        }

        $data = $query->take(1000)->get();

        return response()->json([
            'operation' => 'dice',
            'filters' => $filters,
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    public function rollUp(Request $request)
    {
        // Operación ROLL-UP: Agregación a nivel superior
        $dimension = $request->input('dimension');
        $metric = $request->input('metric', 'monto_total');

        $query = FactSale::query()
            ->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id');

        switch ($dimension) {
            case 'time':
                $query->select(
                    'dim_tiempo.anio as year',
                    DB::raw("SUM({$metric}) as total")
                )->groupBy('dim_tiempo.anio')
                    ->orderBy('dim_tiempo.anio');
                break;

            case 'product':
                $query->join('dw.dim_producto', 'fact_ventas.producto_id', '=', 'dim_producto.producto_id')
                    ->select(
                        'dim_producto.categoria as category',
                        DB::raw("SUM({$metric}) as total")
                    )->groupBy('dim_producto.categoria')
                    ->orderBy('total', 'desc');
                break;

            case 'store':
                $query->join('dw.dim_sucursal', 'fact_ventas.sucursal_id', '=', 'dim_sucursal.sucursal_id')
                    ->select(
                        'dim_sucursal.provincia as region',
                        DB::raw("SUM({$metric}) as total")
                    )->groupBy('dim_sucursal.provincia')
                    ->orderBy('total', 'desc');
                break;
        }

        $data = $query->get();

        return response()->json([
            'operation' => 'roll_up',
            'dimension' => $dimension,
            'metric' => $metric,
            'data' => $data
        ]);
    }

    public function drillDown(Request $request)
    {
        // Operación DRILL-DOWN: Mostrar mayor detalle
        $dimension = $request->input('dimension');
        $parentValue = $request->input('parent_value');
        $metric = $request->input('metric', 'monto_total');

        $query = FactSale::query()
            ->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id');

        switch ($dimension) {
            case 'time':
                // De año a trimestres
                $query->where('dim_tiempo.anio', $parentValue['year'])
                    ->select(
                        'dim_tiempo.trimestre as quarter',
                        DB::raw("SUM({$metric}) as total")
                    )->groupBy('dim_tiempo.trimestre')
                    ->orderBy('dim_tiempo.trimestre');
                break;

            case 'product':
                // De categoría a productos
                $query->join('dw.dim_producto', 'fact_ventas.producto_id', '=', 'dim_producto.producto_id')
                    ->where('dim_producto.categoria', $parentValue['category'])
                    ->select(
                        'dim_producto.nombre as product_name',
                        'dim_producto.codigo as product_code',
                        DB::raw("SUM({$metric}) as total")
                    )->groupBy('dim_producto.nombre', 'dim_producto.codigo')
                    ->orderBy('total', 'desc')
                    ->limit(20);
                break;
        }

        $data = $query->get();

        return response()->json([
            'operation' => 'drill_down',
            'dimension' => $dimension,
            'parent_value' => $parentValue,
            'data' => $data
        ]);
    }

    public function pivot(Request $request)
    {
        // Operación PIVOT: Rotar las dimensiones para ver diferentes perspectivas
        $rows = $request->input('rows');    // Dimensión para filas
        $columns = $request->input('columns'); // Dimensión para columnas
        $metric = $request->input('metric', 'monto_total');

        // Construir consulta base
        $query = FactSale::query()
            ->select(DB::raw("SUM({$metric}) as total"));

        // Agregar joins y condiciones según las dimensiones seleccionadas
        $rowValues = [];
        $colValues = [];

        // Dimensión para filas
        switch ($rows) {
            case 'time_year':
                $query->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id')
                    ->addSelect('dim_tiempo.anio as row_value')
                    ->groupBy('dim_tiempo.anio');
                $rowValues = DimensionTime::select('anio as value')->distinct()->orderBy('anio')->pluck('value');
                break;

            case 'product_category':
                $query->join('dw.dim_producto', 'fact_ventas.producto_id', '=', 'dim_producto.producto_id')
                    ->addSelect('dim_producto.categoria as row_value')
                    ->groupBy('dim_producto.categoria');
                $rowValues = DimensionProduct::select('categoria as value')->distinct()->orderBy('categoria')->pluck('value');
                break;
        }

        // Dimensión para columnas
        switch ($columns) {
            case 'time_quarter':
                $query->join('dw.dim_tiempo', 'fact_ventas.tiempo_id', '=', 'dim_tiempo.tiempo_id')
                    ->addSelect('dim_tiempo.trimestre as col_value')
                    ->groupBy('dim_tiempo.trimestre');
                $colValues = [1, 2, 3, 4];
                break;

            case 'store_region':
                $query->join('dw.dim_sucursal', 'fact_ventas.sucursal_id', '=', 'dim_sucursal.sucursal_id')
                    ->addSelect('dim_sucursal.provincia as col_value')
                    ->groupBy('dim_sucursal.provincia');
                $colValues = DimensionStore::select('provincia as value')->distinct()->orderBy('provincia')->pluck('value');
                break;
        }

        // Obtener datos
        $results = $query->get();

        // Formatear datos para tabla pivote
        $pivotData = [];
        foreach ($rowValues as $row) {
            $rowData = ['row_value' => $row];
            foreach ($colValues as $col) {
                $match = $results->firstWhere(fn($item) => $item->row_value == $row && $item->col_value == $col);
                $rowData[$col] = $match ? $match->total : 0;
            }
            $pivotData[] = $rowData;
        }

        return response()->json([
            'operation' => 'pivot',
            'rows' => $rows,
            'columns' => $columns,
            'metric' => $metric,
            'row_values' => $rowValues,
            'col_values' => $colValues,
            'data' => $pivotData
        ]);
    }
}
