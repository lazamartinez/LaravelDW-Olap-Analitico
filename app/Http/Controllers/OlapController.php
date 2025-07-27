<?php

namespace App\Http\Controllers;

use App\Models\DimensionProduct;
use App\Models\DimensionStore;
use App\Models\DimensionTime;
use App\Models\FactSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OlapController extends Controller
{
    // Método para consultas OLAP básicas
    public function salesAnalysis(Request $request)
    {
        // Ejemplo de consulta OLAP (slice and dice)
        $query = FactSale::with(['product', 'store', 'time'])
            ->select(
                'product_id',
                'store_id',
                DB::raw('SUM(quantity_sold) as total_quantity'),
                DB::raw('SUM(net_amount) as total_sales')
            )
            ->groupBy('product_id', 'store_id');
            
        // Filtros (dicing)
        if ($request->has('product_category')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('category', $request->product_category);
            });
        }
        
        if ($request->has('year')) {
            $query->whereHas('time', function($q) use ($request) {
                $q->where('year', $request->year);
            });
        }
        
        $results = $query->get();
        
        return response()->json($results);
    }
    
    // Método para drill-down
    public function salesDrillDown(Request $request)
    {
        $groupBy = $request->get('group_by', 'month'); // month, quarter, year
        
        $query = FactSale::join('dw.dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
            ->select(
                DB::raw("CASE 
                    WHEN '$groupBy' = 'year' THEN dim_time.year
                    WHEN '$groupBy' = 'quarter' THEN CONCAT(dim_time.year, '-Q', dim_time.quarter)
                    ELSE CONCAT(dim_time.year, '-', LPAD(dim_time.month::text, 2, '0'))
                END as period"),
                DB::raw('SUM(fact_sales.net_amount) as total_sales'),
                DB::raw('COUNT(*) as transactions')
            )
            ->groupBy('period')
            ->orderBy('period');
            
        $results = $query->get();
        
        return response()->json($results);
    }
    
    // Método para roll-up
    public function salesRollUp(Request $request)
    {
        $level = $request->get('level', 'product'); // product, category, store, province
        
        $query = FactSale::query();
        
        switch ($level) {
            case 'category':
                $query->join('dw.dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
                    ->select(
                        'dim_product.category',
                        DB::raw('SUM(fact_sales.net_amount) as total_sales')
                    )
                    ->groupBy('dim_product.category');
                break;
                
            case 'province':
                $query->join('dw.dim_store', 'fact_sales.store_id', '=', 'dim_store.store_id')
                    ->select(
                        'dim_store.province',
                        DB::raw('SUM(fact_sales.net_amount) as total_sales')
                    )
                    ->groupBy('dim_store.province');
                break;
                
            default:
                $query->join('dw.dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
                    ->select(
                        'dim_product.product_id',
                        'dim_product.name',
                        DB::raw('SUM(fact_sales.net_amount) as total_sales')
                    )
                    ->groupBy('dim_product.product_id', 'dim_product.name');
        }
        
        $results = $query->get();
        
        return response()->json($results);
    }
    
    // Método para pivot
    public function salesPivot(Request $request)
    {
        $rows = $request->get('rows', 'category'); // category, province
        $cols = $request->get('cols', 'year');     // year, quarter, month
        
        $query = FactSale::query();
        
        // Configurar las columnas para el pivot
        if ($cols === 'year') {
            $query->join('dw.dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
                ->select('dim_time.year as col_value');
        } elseif ($cols === 'quarter') {
            $query->join('dw.dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
                ->select(DB::raw("CONCAT(dim_time.year, '-Q', dim_time.quarter) as col_value"));
        } else {
            $query->join('dw.dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
                ->select(DB::raw("CONCAT(dim_time.year, '-', LPAD(dim_time.month::text, 2, '0')) as col_value"));
        }
        
        // Configurar las filas para el pivot
        if ($rows === 'category') {
            $query->join('dw.dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
                ->addSelect('dim_product.category as row_value');
        } else {
            $query->join('dw.dim_store', 'fact_sales.store_id', '=', 'dim_store.store_id')
                ->addSelect('dim_store.province as row_value');
        }
        
        $query->addSelect(DB::raw('SUM(fact_sales.net_amount) as total_sales'))
            ->groupBy('row_value', 'col_value');
            
        $rawResults = $query->get();
        
        // Formatear resultados como tabla pivot
        $results = [];
        $columns = [];
        
        foreach ($rawResults as $item) {
            if (!in_array($item->col_value, $columns)) {
                $columns[] = $item->col_value;
            }
            
            if (!isset($results[$item->row_value])) {
                $results[$item->row_value] = ['row_value' => $item->row_value];
            }
            
            $results[$item->row_value][$item->col_value] = $item->total_sales;
        }
        
        // Rellenar con 0 donde no hay datos
        foreach ($results as &$row) {
            foreach ($columns as $col) {
                if (!isset($row[$col])) {
                    $row[$col] = 0;
                }
            }
        }
        
        return response()->json([
            'rows' => array_values($results),
            'columns' => $columns
        ]);
    }
}