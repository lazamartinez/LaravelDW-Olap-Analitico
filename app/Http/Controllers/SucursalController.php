<?php

namespace App\Http\Controllers;

use App\Models\DimensionStore;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = DimensionStore::paginate(10);
        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.create');
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

        $sucursal = DimensionStore::create($validated);

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal creada exitosamente');
    }

    public function show(DimensionStore $sucursal)
    {
        return view('sucursales.show', compact('sucursal'));
    }

    public function edit(DimensionStore $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, DimensionStore $sucursal)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:dw.dim_sucursal,codigo,'.$sucursal->sucursal_id.',sucursal_id|max:20',
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

        $sucursal->update($validated);

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal actualizada exitosamente');
    }

    public function destroy(DimensionStore $sucursal)
    {
        $sucursal->delete();
        
        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal eliminada exitosamente');
    }
}