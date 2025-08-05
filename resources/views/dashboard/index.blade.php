@extends('layouts.app')

@section('title', 'Dashboard Analítico')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Seleccione el Tipo de Análisis</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Tarjeta de Análisis de Ventas -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('sales')">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-4x text-primary mb-3"></i>
                                <h5 class="card-title">Análisis de Ventas</h5>
                                <p class="card-text">Tendencias, comparativas y evolución temporal</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Análisis de Productos -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('products')">
                            <div class="card-body text-center">
                                <i class="fas fa-boxes fa-4x text-success mb-3"></i>
                                <h5 class="card-title">Análisis de Productos</h5>
                                <p class="card-text">Rendimiento por categoría, margen y rotación</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Análisis de Clientes -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('customers')">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-4x text-info mb-3"></i>
                                <h5 class="card-title">Análisis de Clientes</h5>
                                <p class="card-text">Segmentación, valor y comportamiento</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Análisis Geográfico -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('geo')">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt fa-4x text-warning mb-3"></i>
                                <h5 class="card-title">Análisis Geográfico</h5>
                                <p class="card-text">Ventas por ubicación y región</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Análisis de Sucursales -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('stores')">
                            <div class="card-body text-center">
                                <i class="fas fa-store fa-4x text-danger mb-3"></i>
                                <h5 class="card-title">Análisis de Sucursales</h5>
                                <p class="card-text">Comparativo de rendimiento entre tiendas</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Análisis Personalizado -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 hover-scale" onclick="loadAnalysis('custom')">
                            <div class="card-body text-center">
                                <i class="fas fa-sliders-h fa-4x text-secondary mb-3"></i>
                                <h5 class="card-title">Análisis Personalizado</h5>
                                <p class="card-text">Cree sus propias consultas OLAP</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contenedor dinámico para los análisis -->
                <div id="analysisContainer" class="mt-5">
                    <!-- Aquí se cargarán los análisis seleccionados -->
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-arrow-up fa-2x mb-3"></i>
                        <h4>Seleccione un tipo de análisis para comenzar</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .analysis-card {
        border-left: 4px solid var(--primary);
    }
    .dimension-selector {
        border-radius: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
    function loadAnalysis(type) {
        // Mostrar loader
        $('#analysisContainer').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Preparando análisis...</p>
            </div>
        `);
        
        // Cargar el análisis seleccionado
        $.ajax({
            url: `/api/olap/load-analysis`,
            method: 'POST',
            data: { analysis_type: type },
            success: function(response) {
                $('#analysisContainer').html(response.html);
                initializeOLAPTools(type);
            },
            error: function() {
                $('#analysisContainer').html(`
                    <div class="alert alert-danger">
                        Error al cargar el análisis. Intente nuevamente.
                    </div>
                `);
            }
        });
    }
    
    function initializeOLAPTools(type) {
        // Inicializar componentes específicos para cada tipo de análisis
        switch(type) {
            case 'sales':
                initSalesAnalysis();
                break;
            case 'products':
                initProductsAnalysis();
                break;
            // ... otros casos
        }
    }
    
    function initSalesAnalysis() {
        // Inicializar gráficos y controles para análisis de ventas
        console.log("Inicializando análisis de ventas...");
        // Aquí iría la lógica para cargar gráficos, etc.
    }
</script>
@endpush
