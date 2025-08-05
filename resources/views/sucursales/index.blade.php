@extends('layouts.app')

@section('title', 'Gestión de Sucursales')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Listado de Sucursales</h5>
                <a href="{{ route('sucursales.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Sucursal
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Fecha Apertura</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sucursales as $sucursal)
                            <tr>
                                <td>{{ $sucursal->codigo }}</td>
                                <td>{{ $sucursal->nombre }}</td>
                                <td>
                                    {{ $sucursal->provincia }}, {{ $sucursal->canton }}
                                    @if($sucursal->distrito)
                                        , {{ $sucursal->distrito }}
                                    @endif
                                </td>
                                <td>{{ $sucursal->fecha_apertura->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $sucursal->activa ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $sucursal->activa ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('sucursales.edit', $sucursal->sucursal_id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sucursales.destroy', $sucursal->sucursal_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay sucursales registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if($sucursales->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $sucursales->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection