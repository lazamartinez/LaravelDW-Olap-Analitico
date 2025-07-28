<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        return response()->json(Sucursal::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:dw.dim_sucursal,codigo|max:20',
            'nombre' => 'required|max:100',
            'provincia' => 'required|max:50',
            'canton' => 'required|max:50',
            'distrito' => 'required|max:50',
            'direccion_exacta' => 'nullable',
            'telefono' => 'nullable|max:20',
            'horario' => 'nullable',
            'fecha_apertura' => 'required|date',
            'activa' => 'boolean'
        ]);

        $sucursal = Sucursal::create($validated);
        return response()->json($sucursal, 201);
    }

    public function show($id)
    {
        return response()->json(Sucursal::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        
        $validated = $request->validate([
            'codigo' => 'sometimes|required|unique:dw.dim_sucursal,codigo,'.$id.',sucursal_id|max:20',
            'nombre' => 'sometimes|required|max:100',
            'provincia' => 'sometimes|required|max:50',
            'canton' => 'sometimes|required|max:50',
            'distrito' => 'sometimes|required|max:50',
            'direccion_exacta' => 'nullable',
            'telefono' => 'nullable|max:20',
            'horario' => 'nullable',
            'fecha_apertura' => 'sometimes|required|date',
            'activa' => 'boolean'
        ]);

        $sucursal->update($validated);
        return response()->json($sucursal);
    }

    public function destroy($id)
    {
        Sucursal::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}