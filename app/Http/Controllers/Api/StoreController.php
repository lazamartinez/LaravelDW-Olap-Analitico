<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DimensionStore;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function getMapData()
    {
        // Obtener datos de sucursales con métricas básicas
        $stores = DimensionStore::query()
            ->select([
                'dim_sucursal.sucursal_id',
                'dim_sucursal.codigo',
                'dim_sucursal.nombre',
                'dim_sucursal.provincia',
                'dim_sucursal.canton',
                'dim_sucursal.distrito',
                'dim_sucursal.direccion_exacta',
                'dim_sucursal.telefono',
                'dim_sucursal.horario',
                'dim_sucursal.fecha_apertura',
                'dim_sucursal.activa',
                'dim_sucursal.latitud',
                'dim_sucursal.longitud',
                DB::raw('COALESCE(SUM(fact_ventas.monto_total), 0) as ventas_totales'),
                DB::raw('COALESCE(SUM(fact_ventas.cantidad_vendida), 0) as unidades_vendidas'),
                DB::raw('COALESCE(COUNT(DISTINCT fact_ventas.cliente_id), 0) as clientes_unicos'),
                DB::raw('COALESCE(AVG(fact_ventas.margen_ganancia), 0) as margen_promedio')
            ])
            ->leftJoin('dw.fact_ventas', 'dim_sucursal.sucursal_id', '=', 'fact_ventas.sucursal_id')
            ->groupBy('dim_sucursal.sucursal_id')
            ->get();
            
        // Formatear datos para el mapa
        $formattedStores = $stores->map(function($store) {
            return [
                'sucursal_id' => $store->sucursal_id,
                'codigo' => $store->codigo,
                'nombre' => $store->nombre,
                'provincia' => $store->provincia,
                'canton' => $store->canton,
                'distrito' => $store->distrito,
                'direccion_exacta' => $store->direccion_exacta,
                'telefono' => $store->telefono,
                'horario' => $store->horario,
                'fecha_apertura' => $store->fecha_apertura,
                'activa' => (bool)$store->activa,
                'latitud' => $store->latitud ?? $this->getDefaultLatitude($store->provincia),
                'longitud' => $store->longitud ?? $this->getDefaultLongitude($store->provincia),
                'ventas_totales' => (float)$store->ventas_totales,
                'unidades_vendidas' => (int)$store->unidades_vendidas,
                'clientes_unicos' => (int)$store->clientes_unicos,
                'margen_promedio' => (float)$store->margen_promedio
            ];
        });
        
        return response()->json($formattedStores);
    }
    
    protected function getDefaultLatitude($provincia)
    {
        // Coordenadas aproximadas por provincia (Costa Rica como ejemplo)
        $coordinates = [
            'San José' => 9.9281,
            'Alajuela' => 10.0162,
            'Cartago' => 9.8644,
            'Heredia' => 10.0029,
            'Guanacaste' => 10.6260,
            'Puntarenas' => 9.9760,
            'Limón' => 9.9901
        ];
        
        return $coordinates[$provincia] ?? 9.9281;
    }
    
    protected function getDefaultLongitude($provincia)
    {
        // Coordenadas aproximadas por provincia (Costa Rica como ejemplo)
        $coordinates = [
            'San José' => -84.0907,
            'Alajuela' => -84.2114,
            'Cartago' => -83.9204,
            'Heredia' => -84.1165,
            'Guanacaste' => -85.4545,
            'Puntarenas' => -84.8384,
            'Limón' => -83.0359
        ];
        
        return $coordinates[$provincia] ?? -84.0907;
    }
}