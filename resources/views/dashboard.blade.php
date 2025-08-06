@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Analítico</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Resumen ejecutivo</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <div class="dropdown me-2">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="timeRangeDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-calendar-alt me-2"></i>Últimos 30 días
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="timeRangeDropdown">
                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                        <li><a class="dropdown-item" href="#">Ayer</a></li>
                        <li><a class="dropdown-item" href="#">Últimos 7 días</a></li>
                        <li><a class="dropdown-item active" href="#">Últimos 30 días</a></li>
                        <li><a class="dropdown-item" href="#">Este mes</a></li>
                        <li><a class="dropdown-item" href="#">Mes pasado</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Personalizado</a></li>
                    </ul>
                </div>
                <button class="btn btn-primary" data-mdb-toggle="tooltip" title="Actualizar datos">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alertas y notificaciones -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info d-flex align-items-center">
            <i class="fas fa-info-circle me-3 fs-4"></i>
            <div>
                <strong>Última actualización:</strong> Los datos se actualizaron por última vez hoy a las 03:15 AM
            </div>
            <button type="button" class="btn-close ms-auto" data-mdb-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- KPI Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card primary">
            <div class="card-content">
                <h6>Ventas Totales</h6>
                <h2>$<span id="totalSales">0</span></h2>
                <div class="mt-3 d-flex align-items-center">
                    <span class="badge bg-white text-primary">
                        <i class="fas fa-arrow-up me-1"></i> 12.5%
                    </span>
                    <span class="ms-2 small">vs mes anterior</span>
                </div>
            </div>
            <div class="icon-wrapper">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card success">
            <div class="card-content">
                <h6>Productos Vendidos</h6>
                <h2><span id="totalProducts">0</span></h2>
                <div class="mt-3 d-flex align-items-center">
                    <span class="badge bg-white text-success">
                        <i class="fas fa-arrow-up me-1"></i> 8.3%
                    </span>
                    <span class="ms-2 small">vs mes anterior</span>
                </div>
            </div>
            <div class="icon-wrapper">
                <i class="fas fa-shopping-basket"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card warning">
            <div class="card-content">
                <h6>Clientes Activos</h6>
                <h2><span id="totalCustomers">0</span></h2>
                <div class="mt-3 d-flex align-items-center">
                    <span class="badge bg-white text-warning">
                        <i class="fas fa-arrow-up me-1"></i> 5.7%
                    </span>
                    <span class="ms-2 small">vs mes anterior</span>
                </div>
            </div>
            <div class="icon-wrapper">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card info">
            <div class="card-content">
                <h6>Margen Promedio</h6>
                <h2><span id="avgMargin">0</span>%</h2>
                <div class="mt-3 d-flex align-items-center">
                    <span class="badge bg-white text-info">
                        <i class="fas fa-arrow-down me-1"></i> 1.2%
                    </span>
                    <span class="ms-2 small">vs mes anterior</span>
                </div>
            </div>
            <div class="icon-wrapper">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Gráfico de Ventas por Mes -->
    <div class="col-lg-8">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Tendencia de Ventas</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="salesTrendDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                        Por Mes
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="salesTrendDropdown">
                        <li><a class="dropdown-item" href="#">Por Día</a></li>
                        <li><a class="dropdown-item active" href="#">Por Mes</a></li>
                        <li><a class="dropdown-item" href="#">Por Trimestre</a></li>
                        <li><a class="dropdown-item" href="#">Por Año</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribución por Categoría -->
    <div class="col-lg-4">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Ventas por Categoría</h5>
                <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Ver detalles">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Top Productos -->
    <div class="col-lg-6">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Top 5 Productos</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="topProductsDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                        Este Mes
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="topProductsDropdown">
                        <li><a class="dropdown-item" href="#">Esta Semana</a></li>
                        <li><a class="dropdown-item active" href="#">Este Mes</a></li>
                        <li><a class="dropdown-item" href="#">Este Trimestre</a></li>
                        <li><a class="dropdown-item" href="#">Este Año</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-end">Ventas</th>
                                <th class="text-end">Cantidad</th>
                                <th class="text-end">% Total</th>
                                <th style="width: 100px;">Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="topProductsTable">
                            <!-- Datos dinámicos desde API -->
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="/images/placeholder-product.png" alt="Producto" class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Leche Entera 1L</h6>
                                            <small class="text-muted">Alimentos</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">$12,500</td>
                                <td class="text-end">2,500</td>
                                <td class="text-end">12%</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="/images/placeholder-product.png" alt="Producto" class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Pan Integral</h6>
                                            <small class="text-muted">Alimentos</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">$9,800</td>
                                <td class="text-end">1,950</td>
                                <td class="text-end">9.5%</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="/images/placeholder-product.png" alt="Producto" class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Arroz 5kg</h6>
                                            <small class="text-muted">Alimentos</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">$8,700</td>
                                <td class="text-end">580</td>
                                <td class="text-end">8.4%</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="/images/placeholder-product.png" alt="Producto" class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Café 500g</h6>
                                            <small class="text-muted">Bebidas</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">$7,600</td>
                                <td class="text-end">380</td>
                                <td class="text-end">7.3%</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="/images/placeholder-product.png" alt="Producto" class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Jabón Líquido</h6>
                                            <small class="text-muted">Limpieza</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">$6,800</td>
                                <td class="text-end">850</td>
                                <td class="text-end">6.6%</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rendimiento por Sucursal -->
    <div class="col-lg-6">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-store me-2"></i>Rendimiento por Sucursal</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="storesDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                        Por Ventas
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="storesDropdown">
                        <li><a class="dropdown-item active" href="#">Por Ventas</a></li>
                        <li><a class="dropdown-item" href="#">Por Margen</a></li>
                        <li><a class="dropdown-item" href="#">Por Crecimiento</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="storesPerformanceChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-2 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted">Mejor desempeño</small>
                                    <h6 class="mb-0">Sucursal Norte</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success">+12.5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-2 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted">Menor desempeño</small>
                                    <h6 class="mb-0">Sucursal Sur</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-danger">-3.2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de Ventas por Hora (solo en pantallas grandes) -->
<div class="row mt-4 d-none d-lg-flex">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Patrón de Ventas por Hora</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="hourlySalesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dashboardData = {
            load: async function() {
                try {
                    fetch(`${window.location.origin}/api/dashboard-data`)
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.status !== 'success') {
                        throw new Error(data.message || 'Invalid response');
                    }
                    
                    this.updateUI(data.data);
                } catch (error) {
                    console.error('Error:', error);
                    this.showError(error.message);
                } finally {
                    this.hideLoader();
                }
            },
            
            updateUI: function(data) {
                // Actualizar KPIs
                if (data.total_sales) {
                    document.getElementById('totalSales').textContent = 
                        Number(data.total_sales).toLocaleString();
                }
                
                // Actualizar gráficos
                this.renderCharts(data);
            },
            
            renderCharts: function(data) {
                // Implementa tu lógica de gráficos aquí
                console.log('Render charts with:', data);
            },
            
            showError: function(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>
                    ${message || 'Error al cargar los datos'}
                `;
                
                document.getElementById('dashboard-container').prepend(alertDiv);
            },
            
            hideLoader: function() {
                const loader = document.getElementById('preloader');
                if (loader) loader.style.display = 'none';
            }
        };
        
        dashboardData.load();
    });
    </script>    
@endsection