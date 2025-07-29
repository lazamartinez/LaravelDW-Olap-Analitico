<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OlapService
{
    public function executeQuery(array $params)
    {
        $query = $this->buildQuery($params);
        return DB::select($query);
    }

    protected function buildQuery(array $params): string
    {
        $select = $this->buildSelect($params);
        $from = "FROM dw.fact_ventas f";
        $joins = $this->buildJoins($params);
        $where = $this->buildWhere($params);
        $groupBy = $this->buildGroupBy($params);
        
        return "$select $from $joins $where $groupBy LIMIT 1000";
    }

    protected function buildSelect(array $params): string
    {
        $dimensionMap = [
            'producto' => 'p.nombre as nombre_producto, p.categoria',
            'tiempo' => $this->getTimeSelect($params['timeLevel']),
            'sucursal' => 's.nombre as nombre_sucursal, s.provincia',
            'cliente' => 'c.nombre as nombre_cliente, c.segmento'
        ];
        
        $metricMap = [
            'monto_total' => 'SUM(f.monto_total) as monto_total',
            'cantidad_vendida' => 'SUM(f.cantidad_vendida) as cantidad_vendida',
            'margen_ganancia' => 'SUM(f.margen_ganancia) as margen_ganancia'
        ];
        
        $dimensionSelect = $dimensionMap[$params['dimension']];
        $metricSelect = $metricMap[$params['metric']];
        
        return "SELECT $dimensionSelect, $metricSelect";
    }

    protected function getTimeSelect(string $level): string
    {
        $selects = [
            'dia' => "t.fecha, t.nombre_dia",
            'mes' => "t.anio || '-' || t.mes as periodo, t.nombre_mes",
            'trimestre' => "t.anio || '-T' || t.trimestre as periodo",
            'anio' => "t.anio"
        ];
        
        return $selects[$level];
    }

    protected function buildJoins(array $params): string
    {
        $joins = [
            'producto' => "JOIN dw.dim_producto p ON f.producto_id = p.producto_id",
            'tiempo' => "JOIN dw.dim_tiempo t ON f.tiempo_id = t.tiempo_id",
            'sucursal' => "JOIN dw.dim_sucursal s ON f.sucursal_id = s.sucursal_id",
            'cliente' => "JOIN dw.dim_cliente c ON f.cliente_id = c.cliente_id"
        ];
        
        $requiredJoins = [$joins[$params['dimension']]];
        
        if ($params['dimension'] !== 'tiempo' && !str_contains($this->buildSelect($params), 't.')) {
            $requiredJoins[] = $joins['tiempo'];
        }
        
        return implode(' ', $requiredJoins);
    }

    protected function buildWhere(array $params): string
    {
        if (empty($params['filters'])) {
            return '';
        }
        
        $conditions = [];
        foreach ($params['filters'] as $filter) {
            $operator = $filter['operator'];
            $value = $operator === 'LIKE' ? "'%{$filter['value']}%'" : $filter['value'];
            $conditions[] = "{$filter['field']} $operator $value";
        }
        
        return 'WHERE ' . implode(' AND ', $conditions);
    }

    protected function buildGroupBy(array $params): string
    {
        $dimensionMap = [
            'producto' => 'p.nombre, p.categoria',
            'tiempo' => $this->getTimeGroupBy($params['timeLevel']),
            'sucursal' => 's.nombre, s.provincia',
            'cliente' => 'c.nombre, c.segmento'
        ];
        
        return 'GROUP BY ' . $dimensionMap[$params['dimension']];
    }

    protected function getTimeGroupBy(string $level): string
    {
        $groups = [
            'dia' => 't.fecha, t.nombre_dia',
            'mes' => 't.anio, t.mes, t.nombre_mes',
            'trimestre' => 't.anio, t.trimestre',
            'anio' => 't.anio'
        ];
        
        return $groups[$level];
    }

    public function getBasicMetrics()
    {
        return [
            'total_sales' => DB::selectOne("SELECT SUM(monto_total) as value FROM dw.fact_ventas")->value,
            'total_products' => DB::selectOne("SELECT COUNT(*) as value FROM dw.dim_producto")->value,
            'total_stores' => DB::selectOne("SELECT COUNT(*) as value FROM dw.dim_sucursal WHERE activa = true")->value,
            'avg_sale' => DB::selectOne("SELECT AVG(monto_total) as value FROM dw.fact_ventas")->value
        ];
    }
}