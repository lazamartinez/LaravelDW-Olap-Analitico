@extends('layouts.app')

@section('title', 'Editar Sucursal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Editar Sucursal: {{ $sucursal->nombre }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sucursales.update', $sucursal->sucursal_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo', $sucursal->codigo) }}" required>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $sucursal->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="provincia" class="form-label">Provincia</label>
                            <select class="form-select @error('provincia') is-invalid @enderror" id="provincia" name="provincia" required>
                                <option value="">Seleccione...</option>
                                <option value="San José" {{ old('provincia', $sucursal->provincia) == 'San José' ? 'selected' : '' }}>San José</option>
                                <option value="Alajuela" {{ old('provincia', $sucursal->provincia) == 'Alajuela' ? 'selected' : '' }}>Alajuela</option>
                                <option value="Cartago" {{ old('provincia', $sucursal->provincia) == 'Cartago' ? 'selected' : '' }}>Cartago</option>
                                <option value="Heredia" {{ old('provincia', $sucursal->provincia) == 'Heredia' ? 'selected' : '' }}>Heredia</option>
                                <option value="Guanacaste" {{ old('provincia', $sucursal->provincia) == 'Guanacaste' ? 'selected' : '' }}>Guanacaste</option>
                                <option value="Puntarenas" {{ old('provincia', $sucursal->provincia) == 'Puntarenas' ? 'selected' : '' }}>Puntarenas</option>
                                <option value="Limón" {{ old('provincia', $sucursal->provincia) == 'Limón' ? 'selected' : '' }}>Limón</option>
                            </select>
                            @error('provincia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="canton" class="form-label">Cantón</label>
                            <input type="text" class="form-control @error('canton') is-invalid @enderror" id="canton" name="canton" value="{{ old('canton', $sucursal->canton) }}" required>
                            @error('canton')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="distrito" class="form-label">Distrito</label>
                            <input type="text" class="form-control @error('distrito') is-invalid @enderror" id="distrito" name="distrito" value="{{ old('distrito', $sucursal->distrito) }}" required>
                            @error('distrito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion_exacta" class="form-label">Dirección Exacta</label>
                        <textarea class="form-control @error('direccion_exacta') is-invalid @enderror" id="direccion_exacta" name="direccion_exacta" rows="2">{{ old('direccion_exacta', $sucursal->direccion_exacta) }}</textarea>
                        @error('direccion_exacta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $sucursal->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_apertura" class="form-label">Fecha de Apertura</label>
                            <input type="date" class="form-control @error('fecha_apertura') is-invalid @enderror" id="fecha_apertura" name="fecha_apertura" value="{{ old('fecha_apertura', $sucursal->fecha_apertura->format('Y-m-d')) }}" required>
                            @error('fecha_apertura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <textarea class="form-control @error('horario') is-invalid @enderror" id="horario" name="horario" rows="2">{{ old('horario', $sucursal->horario) }}</textarea>
                        @error('horario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activa" name="activa" {{ old('activa', $sucursal->activa) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activa">Sucursal activa</label>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
