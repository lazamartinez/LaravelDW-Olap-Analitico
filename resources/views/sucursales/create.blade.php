@extends('layouts.app')

@section('title', 'Crear Sucursal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Nueva Sucursal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sucursales.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
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
                                <option value="San José" {{ old('provincia') == 'San José' ? 'selected' : '' }}>San José</option>
                                <option value="Alajuela" {{ old('provincia') == 'Alajuela' ? 'selected' : '' }}>Alajuela</option>
                                <option value="Cartago" {{ old('provincia') == 'Cartago' ? 'selected' : '' }}>Cartago</option>
                                <option value="Heredia" {{ old('provincia') == 'Heredia' ? 'selected' : '' }}>Heredia</option>
                                <option value="Guanacaste" {{ old('provincia') == 'Guanacaste' ? 'selected' : '' }}>Guanacaste</option>
                                <option value="Puntarenas" {{ old('provincia') == 'Puntarenas' ? 'selected' : '' }}>Puntarenas</option>
                                <option value="Limón" {{ old('provincia') == 'Limón' ? 'selected' : '' }}>Limón</option>
                            </select>
                            @error('provincia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="canton" class="form-label">Cantón</label>
                            <input type="text" class="form-control @error('canton') is-invalid @enderror" id="canton" name="canton" value="{{ old('canton') }}" required>
                            @error('canton')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="distrito" class="form-label">Distrito</label>
                            <input type="text" class="form-control @error('distrito') is-invalid @enderror" id="distrito" name="distrito" value="{{ old('distrito') }}" required>
                            @error('distrito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion_exacta" class="form-label">Dirección Exacta</label>
                        <textarea class="form-control @error('direccion_exacta') is-invalid @enderror" id="direccion_exacta" name="direccion_exacta" rows="2">{{ old('direccion_exacta') }}</textarea>
                        @error('direccion_exacta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_apertura" class="form-label">Fecha de Apertura</label>
                            <input type="date" class="form-control @error('fecha_apertura') is-invalid @enderror" id="fecha_apertura" name="fecha_apertura" value="{{ old('fecha_apertura') }}" required>
                            @error('fecha_apertura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <textarea class="form-control @error('horario') is-invalid @enderror" id="horario" name="horario" rows="2">{{ old('horario') }}</textarea>
                        @error('horario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activa" name="activa" {{ old('activa', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activa">Sucursal activa</label>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection