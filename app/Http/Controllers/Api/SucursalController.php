<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DimensionStore;
use App\Models\FactSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    public function index(Request $request)
    {
        $query = DimensionStore::query();
        
        // Filtros
        if ($request->has('activa')) {
            $query->where('activa', $request->activa);
        }
        
        if ($request->has('provincia')) {
            $query->where('provincia', 'like', '%'.$request->provincia.'%');
        }
        
        // Ordenación
        $sortField = $request->get('sort_field', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
        
        // Paginación
        $perPage = $request->get('per_page', 15);
        $sucursales = $query->paginate($perPage);
        
        return response()->json([
            'data' => $sucursales->items(),
            'meta' => [
                'current_page' => $sucursales->currentPage(),
                'per_page' => $sucursales->perPage(),
                'total' => $sucursales->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:dw.dim_sucursal|max:20',
            'nombre' => 'required|max:100',
            'provincia' => 'required|max:50',
            'canton' => 'required|max:50',
            'distrito' => 'required|max:50',
            'fecha_apertura' => 'required|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $sucursal = DimensionStore::create($request->all());
            
            DB::commit();
            
            return response()->json([
                'message' => 'Sucursal creada exitosamente',
                'data' => $sucursal
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear sucursal',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $sucursal = DimensionStore::findOrFail($id);
        
        return response()->json([
            'data' => $sucursal
        ]);
    }

    public function update(Request $request, $id)
    {
        $sucursal = DimensionStore::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|unique:dw.dim_sucursal,codigo,'.$id.',sucursal_id|max:20',
            'nombre' => 'sometimes|required|max:100',
            'provincia' => 'sometimes|required|max:50',
            'canton' => 'sometimes|required|max:50',
            'distrito' => 'sometimes|required|max:50',
            'fecha_apertura' => 'sometimes|required|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $sucursal->update($request->all());
            
            DB::commit();
            
            return response()->json([
                'message' => 'Sucursal actualizada exitosamente',
                'data' => $sucursal
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar sucursal',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $sucursal = DimensionStore::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Verificar si hay ventas asociadas
            $ventas = FactSale::where('sucursal_id', $id)->count();
            if ($ventas > 0) {
                return response()->json([
                    'error' => 'No se puede eliminar',
                    'message' => 'La sucursal tiene ventas asociadas'
                ], 422);
            }
            
            $sucursal->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Sucursal eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al eliminar sucursal',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function metrics($id)
    {
        $sucursal = DimensionStore::findOrFail($id);
        
        $metrics = DB::table('dw.fact_ventas')
            ->select(
                DB::raw('SUM(monto_total) as ventas_totales'),
                DB::raw('SUM(cantidad_vendida) as unidades_vendidas'),
                DB::raw('AVG(margen_ganancia) as margen_promedio'),
                DB::raw('COUNT(DISTINCT cliente_id) as clientes_unicos')
            )
            ->where('sucursal_id', $id)
            ->first();
            
        return response()->json([
            'data' => [
                'sucursal' => $sucursal,
                'metrics' => $metrics
            ]
        ]);
    }
}
