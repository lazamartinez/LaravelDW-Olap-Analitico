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
                <button class="btn btn-primary" id="refreshDashboard" data-mdb-toggle="tooltip" title="Actualizar datos">
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

<!-- En la sección del mapa (reemplazar el div existente) -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Mapa de Sucursales</h5>
                <div class="d-flex align-items-center">
                    <div class="input-group input-group-sm me-3" style="width: 250px;">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" id="storeSearch" class="form-control" placeholder="Buscar sucursal...">
                    </div>
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="mapFilterDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                            Todas las sucursales
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="mapFilterDropdown">
                            <li><a class="dropdown-item active" href="#" data-filter="all">Todas</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="active">Solo activas</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="inactive">Solo inactivas</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-filter="top">Top 5 por ventas</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="high">Alto rendimiento</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="low">Bajo rendimiento</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="mapLayersDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-layer-group"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="mapLayersDropdown">
                            <li>
                                <div class="form-check ms-2 me-4">
                                    <input class="form-check-input" type="checkbox" id="heatmapLayer" checked>
                                    <label class="form-check-label" for="heatmapLayer">Heatmap de ventas</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check ms-2 me-4">
                                    <input class="form-check-input" type="checkbox" id="coverageLayer">
                                    <label class="form-check-label" for="coverageLayer">Áreas de cobertura</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0" style="height: 600px;">
                <div id="storesMap" style="height: 100%; width: 100%; border-radius: 0.75rem;"></div>
            </div>
            <div class="card-footer bg-white border-0 py-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted"><span id="storesCount">0</span> sucursales mostradas</small>
                        <small class="text-muted ms-3">Ventas totales: $<span id="totalSalesMap">0</span></small>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-primary me-2" id="compareStoresBtn" disabled>
                            <i class="fas fa-balance-scale me-1"></i>Comparar (0)
                        </button>
                        <button class="btn btn-sm btn-outline-primary" id="locateMeBtn">
                            <i class="fas fa-location-arrow me-1"></i>Mi ubicación
                        </button>
                    </div>
                </div>
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

<!-- Modal para detalles de sucursal -->
<div class="modal fade" id="storeDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModalTitle">Detalles de Sucursal</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6><i class="fas fa-info-circle me-2"></i>Información Básica</h6>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Nombre:</th>
                                        <td id="storeName">-</td>
                                    </tr>
                                    <tr>
                                        <th>Código:</th>
                                        <td id="storeCode">-</td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td id="storeStatus">-</td>
                                    </tr>
                                    <tr>
                                        <th>Apertura:</th>
                                        <td id="storeOpening">-</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono:</th>
                                        <td id="storePhone">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h6>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Provincia:</th>
                                        <td id="storeProvince">-</td>
                                    </tr>
                                    <tr>
                                        <th>Cantón:</th>
                                        <td id="storeCanton">-</td>
                                    </tr>
                                    <tr>
                                        <th>Distrito:</th>
                                        <td id="storeDistrict">-</td>
                                    </tr>
                                    <tr>
                                        <th>Dirección:</th>
                                        <td id="storeAddress">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6><i class="fas fa-chart-bar me-2"></i>Métricas</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted">Ventas (30 días)</small>
                                        <h4 class="mb-0" id="storeSales">$0</h4>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted">Unidades</small>
                                        <h4 class="mb-0" id="storeUnits">0</h4>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted">Clientes únicos</small>
                                        <h4 class="mb-0" id="storeCustomers">0</h4>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted">Margen</small>
                                        <h4 class="mb-0" id="storeMargin">0%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-clock me-2"></i>Horario</h6>
                            <div class="p-3 bg-light rounded">
                                <div id="storeSchedule">-</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-map me-2"></i>Ubicación exacta</h6>
                            <div id="storeMiniMap" style="height: 150px; width: 100%; border-radius: 0.5rem;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-chart-line me-1"></i>Ver análisis
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Leaflet CSS y JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Incluir plugin de marcadores clusters -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<!-- Incluir Heatmap.js -->
<script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>

<!-- En la sección de estilos -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Variables globales
        let map, markersCluster, heatmapLayer, coverageLayer, userLocationMarker;
        let storesData = [], selectedStores = [];
        let coverageLayerAdded = false;
        const storeDetailModal = new mdb.Modal(document.getElementById('storeDetailModal'));
        
        // Inicializar mapa con mejoras
        function initMap() {
            // Coordenadas iniciales (centro del país)
            const initialCoords = [9.9281, -84.0907];
            
            // Crear mapa con mejor estilo
            map = L.map('storesMap', {
                zoomControl: false,
                preferCanvas: true
            }).setView(initialCoords, 8);
            
            // Añadir capa base mejorada (CartoDB Positron)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);
            
            // Añadir control de zoom personalizado
            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            
            // Añadir escala
            L.control.scale({
                position: 'bottomleft',
                imperial: false
            }).addTo(map);
            
            // Inicializar capa de heatmap
            heatmapLayer = L.layerGroup().addTo(map);
            
            // Inicializar capa de cobertura
            coverageLayer = L.layerGroup();
            
            // Inicializar cluster de marcadores mejorado
            markersCluster = L.markerClusterGroup({
                maxClusterRadius: 40,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                iconCreateFunction: function(cluster) {
                    const childCount = cluster.getChildCount();
                    let size = 'small';
                    if (childCount > 50) {
                        size = 'large';
                    } else if (childCount > 10) {
                        size = 'medium';
                    }
                    
                    return L.divIcon({
                        html: `<div><span>${childCount}</span></div>`,
                        className: `marker-cluster marker-cluster-${size}`,
                        iconSize: new L.Point(40, 40)
                    });
                }
            });
            map.addLayer(markersCluster);
            
            // Cargar datos de sucursales
            loadStoresData();
        }
        
        // Cargar datos de sucursales desde API
        function loadStoresData() {
            // Simular datos mientras no tengas la API
            const mockData = [
                {
                    sucursal_id: 1,
                    nombre: "Sucursal Central",
                    codigo: "SC-001",
                    activa: true,
                    latitud: 9.9281,
                    longitud: -84.0907,
                    ventas_totales: 1500000,
                    clientes_unicos: 1250,
                    unidades_vendidas: 8500,
                    margen_promedio: 22.5,
                    fecha_apertura: "2020-01-15",
                    telefono: "2222-2222",
                    provincia: "San José",
                    canton: "San José",
                    distrito: "Carmen",
                    direccion_exacta: "Avenida Central, Calle 5",
                    horario: "Lunes a Viernes: 8:00 AM - 8:00 PM"
                },
                {
                    sucursal_id: 2,
                    nombre: "Sucursal Este",
                    codigo: "SE-002",
                    activa: true,
                    latitud: 9.9350,
                    longitud: -84.0780,
                    ventas_totales: 1200000,
                    clientes_unicos: 980,
                    unidades_vendidas: 7200,
                    margen_promedio: 18.2,
                    fecha_apertura: "2020-03-10",
                    telefono: "2222-3333",
                    provincia: "San José",
                    canton: "San José",
                    distrito: "Merced",
                    direccion_exacta: "Avenida 2, Calle 10",
                    horario: "Lunes a Sábado: 8:00 AM - 8:00 PM"
                }
            ];
            
            storesData = mockData;
            updateStoresMap();
            updateHeatmap();
            
            // En producción usarías esto:
            /*
            fetch('/api/stores/map-data')
                .then(response => response.json())
                .then(data => {
                    storesData = data;
                    updateStoresMap();
                    updateHeatmap();
                })
                .catch(error => {
                    console.error('Error al cargar datos de sucursales:', error);
                });
            */
        }
        
        // Actualizar mapa con datos de sucursales
        function updateStoresMap(filter = 'all') {
            // Limpiar marcadores existentes
            markersCluster.clearLayers();
            selectedStores = [];
            document.getElementById('compareStoresBtn').disabled = true;
            document.getElementById('compareStoresBtn').innerHTML = '<i class="fas fa-balance-scale me-1"></i>Comparar (0)';
            
            // Filtrar sucursales según criterio
            let filteredStores = storesData;
            let totalSales = 0;
            
            if (filter === 'active') {
                filteredStores = storesData.filter(store => store.activa);
            } else if (filter === 'inactive') {
                filteredStores = storesData.filter(store => !store.activa);
            } else if (filter === 'top') {
                filteredStores = [...storesData]
                    .sort((a, b) => b.ventas_totales - a.ventas_totales)
                    .slice(0, 5);
            } else if (filter === 'high') {
                filteredStores = storesData.filter(store => store.margen_promedio > 20);
            } else if (filter === 'low') {
                filteredStores = storesData.filter(store => store.margen_promedio < 10);
            }
            
            // Calcular ventas totales para las sucursales filtradas
            totalSales = filteredStores.reduce((sum, store) => sum + store.ventas_totales, 0);
            
            // Actualizar contadores
            document.getElementById('storesCount').textContent = filteredStores.length;
            document.getElementById('totalSalesMap').textContent = totalSales.toLocaleString('es-CR');
            
            // Añadir marcadores para cada sucursal
            filteredStores.forEach(store => {
                // Determinar clase CSS según rendimiento
                let markerClass = store.activa ? 'active' : 'inactive';
                if (store.activa) {
                    if (store.margen_promedio > 20) markerClass = 'high-performance';
                    else if (store.margen_promedio < 10) markerClass = 'low-performance';
                    else if (store.margen_promedio >= 10 && store.margen_promedio <= 20) markerClass = 'medium-performance';
                }
                
                const marker = L.marker([store.latitud, store.longitud], {
                    storeId: store.sucursal_id,
                    riseOnHover: true
                });
                
                // Personalizar icono según estado y rendimiento
                const icon = L.divIcon({
                    html: `<div class="store-marker ${markerClass}">
                              <i class="fas fa-store"></i>
                              <span class="marker-tooltip">${store.nombre}<br>Ventas: $${store.ventas_totales.toLocaleString('es-CR')}</span>
                           </div>`,
                    className: '',
                    iconSize: [36, 36],
                    popupAnchor: [0, -18]
                });
                marker.setIcon(icon);
                
                // Añadir popup con información mejorada
                marker.bindPopup(`
                    <div class="store-popup">
                        <h5><i class="fas fa-store me-2"></i>${store.nombre}</h5>
                        <div class="popup-metrics">
                            <div class="metric-item">
                                <div class="metric-value">$${store.ventas_totales.toLocaleString('es-CR')}</div>
                                <div class="metric-label">Ventas</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-value">${store.clientes_unicos}</div>
                                <div class="metric-label">Clientes</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-value">${store.margen_promedio.toFixed(1)}%</div>
                                <div class="metric-label">Margen</div>
                            </div>
                        </div>
                        <div class="popup-actions">
                            <button class="btn btn-sm btn-outline-primary w-100 view-details" 
                                    data-store-id="${store.sucursal_id}">
                                <i class="fas fa-eye me-1"></i>Detalles
                            </button>
                            <button class="btn btn-sm btn-outline-secondary compare-store" 
                                    data-store-id="${store.sucursal_id}">
                                <i class="fas fa-balance-scale me-1"></i>Comparar
                            </button>
                        </div>
                    </div>
                `);
                
                // Añadir marcador al cluster
                markersCluster.addLayer(marker);
            });
            
            // Ajustar vista del mapa para mostrar todos los marcadores
            if (filteredStores.length > 0) {
                const group = new L.featureGroup(markersCluster.getLayers());
                map.fitBounds(group.getBounds().pad(0.2));
            }
        }
        
        // Actualizar heatmap basado en ventas
        function updateHeatmap() {
            heatmapLayer.clearLayers();
            
            // Solo si el checkbox está marcado
            if (document.getElementById('heatmapLayer').checked) {
                const heatData = storesData.map(store => ({
                    lat: store.latitud,
                    lng: store.longitud,
                    value: store.ventas_totales / 1000 // Normalizar valores
                }));
                
                // Configurar heatmap
                const cfg = {
                    radius: 25,
                    maxOpacity: 0.8,
                    scaleRadius: true,
                    useLocalExtrema: false,
                    latField: 'lat',
                    lngField: 'lng',
                    valueField: 'value',
                    gradient: {
                        0.1: '#89B7E1',
                        0.25: '#6A9FD1',
                        0.5: '#4B87C1',
                        0.75: '#2D6FB1',
                        1.0: '#0E57A1'
                    }
                };
                
                // Crear capa de heatmap
                const heatmap = new HeatmapOverlay(cfg);
                heatmap.setData({
                    data: heatData
                });
                
                heatmapLayer.addLayer(heatmap);
            }
        }
        
        // Mostrar detalles de sucursal (mejorado)
        function showStoreDetails(storeId) {
            const store = storesData.find(s => s.sucursal_id == storeId);
            if (!store) return;
            
            // Actualizar modal con datos de la sucursal
            document.getElementById('storeModalTitle').textContent = store.nombre;
            document.getElementById('storeName').textContent = store.nombre;
            document.getElementById('storeCode').textContent = store.codigo;
            document.getElementById('storeStatus').innerHTML = store.activa ? 
                '<span class="badge bg-success">Activa</span>' : 
                '<span class="badge bg-secondary">Inactiva</span>';
            document.getElementById('storeOpening').textContent = store.fecha_apertura;
            document.getElementById('storePhone').textContent = store.telefono || 'N/A';
            document.getElementById('storeProvince').textContent = store.provincia;
            document.getElementById('storeCanton').textContent = store.canton;
            document.getElementById('storeDistrict').textContent = store.distrito;
            document.getElementById('storeAddress').textContent = store.direccion_exacta || 'N/A';
            document.getElementById('storeSales').textContent = `$${store.ventas_totales.toLocaleString('es-CR')}`;
            document.getElementById('storeUnits').textContent = store.unidades_vendidas.toLocaleString('es-CR');
            document.getElementById('storeCustomers').textContent = store.clientes_unicos.toLocaleString('es-CR');
            document.getElementById('storeMargin').textContent = `${store.margen_promedio.toFixed(1)}%`;
            document.getElementById('storeSchedule').textContent = store.horario || 'Lunes a Viernes: 8:00 AM - 8:00 PM';
            
            // Mostrar mini mapa con mejoras
            setTimeout(() => {
                const miniMap = L.map('storeMiniMap', {
                    zoomControl: false,
                    dragging: false,
                    touchZoom: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: false,
                    keyboard: false
                }).setView([store.latitud, store.longitud], 15);
                
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 19
                }).addTo(miniMap);
                
                // Marcador con tooltip
                const marker = L.marker([store.latitud, store.longitud], {
                    icon: L.divIcon({
                        html: `<div class="store-marker active">
                                  <i class="fas fa-store"></i>
                                  <span class="marker-tooltip">${store.nombre}</span>
                               </div>`,
                        className: '',
                        iconSize: [32, 32]
                    })
                }).addTo(miniMap);
                
                // Añadir círculo de radio
                L.circle([store.latitud, store.longitud], {
                    color: '#4361ee',
                    fillColor: '#4361ee',
                    fillOpacity: 0.2,
                    radius: 500
                }).addTo(miniMap);
                
                // Guardar referencia para limpiar al cerrar modal
                document.getElementById('storeDetailModal').addEventListener('hidden.bs.modal', function() {
                    miniMap.remove();
                }, {once: true});
            }, 100);
            
            // Mostrar modal
            storeDetailModal.show();
        }
        
        // Localizar al usuario con mejoras
        function locateUser() {
            if (!navigator.geolocation) {
                alert('Geolocalización no soportada por tu navegador');
                return;
            }
            
            const btn = document.getElementById('locateMeBtn');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Localizando...';
            btn.disabled = true;
            
            navigator.geolocation.getCurrentPosition(
                position => {
                    const userCoords = [position.coords.latitude, position.coords.longitude];
                    const accuracy = position.coords.accuracy;
                    
                    // Eliminar marcador anterior si existe
                    if (userLocationMarker) {
                        map.removeLayer(userLocationMarker);
                    }
                    
                    // Añadir nuevo marcador
                    userLocationMarker = L.marker(userCoords, {
                        icon: L.divIcon({
                            html: '<div class="user-location-marker"><i class="fas fa-user"></i></div>',
                            className: '',
                            iconSize: [32, 32]
                        })
                    }).addTo(map);
                    
                    // Añadir círculo de precisión
                    L.circle(userCoords, {
                        color: '#28a745',
                        fillColor: '#28a745',
                        fillOpacity: 0.2,
                        radius: accuracy
                    }).addTo(map);
                    
                    // Centrar mapa en la ubicación del usuario
                    map.setView(userCoords, 13);
                    
                    btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Mi ubicación';
                    btn.disabled = false;
                },
                error => {
                    console.error('Error al obtener ubicación:', error);
                    alert('No se pudo obtener tu ubicación. Asegúrate de haber concedido los permisos necesarios.');
                    btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Mi ubicación';
                    btn.disabled = false;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
        
        // Toggle capa de cobertura
        function toggleCoverageLayer() {
            if (document.getElementById('coverageLayer').checked) {
                if (!coverageLayerAdded) {
                    // Simular datos de cobertura (en producción esto vendría de una API)
                    storesData.forEach(store => {
                        if (store.activa) {
                            L.circle([store.latitud, store.longitud], {
                                color: '#4361ee',
                                fillColor: '#4361ee',
                                fillOpacity: 0.1,
                                radius: 2000
                            }).addTo(coverageLayer);
                        }
                    });
                    coverageLayerAdded = true;
                }
                map.addLayer(coverageLayer);
            } else {
                map.removeLayer(coverageLayer);
            }
        }
        
        // Event listeners mejorados
        document.getElementById('refreshDashboard').addEventListener('click', function() {
            loadStoresData();
        });
        
        document.getElementById('locateMeBtn').addEventListener('click', locateUser);
        
        // Filtrar sucursales en el mapa
        document.querySelectorAll('[data-filter]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.getAttribute('data-filter');
                
                // Actualizar dropdown
                document.getElementById('mapFilterDropdown').textContent = this.textContent;
                
                // Actualizar mapa
                updateStoresMap(filter);
            });
        });
        
        // Búsqueda de sucursales
        document.getElementById('storeSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            if (searchTerm.length > 2) {
                const filtered = storesData.filter(store => 
                    store.nombre.toLowerCase().includes(searchTerm) || 
                    store.codigo.toLowerCase().includes(searchTerm) ||
                    store.provincia.toLowerCase().includes(searchTerm)
                );
                
                // Resaltar resultados
                markersCluster.eachLayer(marker => {
                    const storeId = marker.options.storeId;
                    const store = storesData.find(s => s.sucursal_id == storeId);
                    if (store && (store.nombre.toLowerCase().includes(searchTerm) || 
                        store.codigo.toLowerCase().includes(searchTerm))) {
                        marker.setZIndexOffset(1000);
                        marker.openPopup();
                    } else {
                        marker.setZIndexOffset(0);
                    }
                });
            }
        });
        
        // Toggle capas
        document.getElementById('heatmapLayer').addEventListener('change', updateHeatmap);
        document.getElementById('coverageLayer').addEventListener('change', toggleCoverageLayer);
        
        // Delegación de eventos para los botones en los popups
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-details')) {
                const storeId = e.target.getAttribute('data-store-id');
                showStoreDetails(storeId);
            }
            
            if (e.target.classList.contains('compare-store')) {
                const storeId = e.target.getAttribute('data-store-id');
                const store = storesData.find(s => s.sucursal_id == storeId);
                
                if (store) {
                    const index = selectedStores.findIndex(s => s.sucursal_id == storeId);
                    if (index === -1) {
                        if (selectedStores.length < 3) {
                            selectedStores.push(store);
                            e.target.classList.add('btn-primary');
                            e.target.classList.remove('btn-outline-secondary');
                        } else {
                            alert('Máximo 3 sucursales para comparar');
                        }
                    } else {
                        selectedStores.splice(index, 1);
                        e.target.classList.remove('btn-primary');
                        e.target.classList.add('btn-outline-secondary');
                    }
                    
                    // Actualizar botón de comparar
                    const compareBtn = document.getElementById('compareStoresBtn');
                    compareBtn.disabled = selectedStores.length === 0;
                    compareBtn.innerHTML = `<i class="fas fa-balance-scale me-1"></i>Comparar (${selectedStores.length})`;
                }
            }
        });
        
        // Botón de comparar
        document.getElementById('compareStoresBtn').addEventListener('click', function() {
            if (selectedStores.length > 0) {
                // Aquí iría la lógica para mostrar la comparación
                alert(`Comparando ${selectedStores.length} sucursales`);
                
                // Podrías abrir un modal con gráficos comparativos
                // o ajustar el mapa para mostrar todas las seleccionadas
                const storeLayers = selectedStores.map(store => {
                    return L.marker([store.latitud, store.longitud], {
                        icon: L.divIcon({
                            html: `<div class="store-marker high-performance">
                                      <i class="fas fa-store"></i>
                                   </div>`,
                            className: '',
                            iconSize: [36, 36]
                        })
                    });
                });
                
                const compareGroup = L.featureGroup(storeLayers);
                map.fitBounds(compareGroup.getBounds().pad(0.2));
            }
        });
        
        // Inicializar mapa al cargar la página
        initMap();
        
        // Inicializar otros gráficos del dashboard
        initCharts();
    });
    
    // Función para inicializar gráficos del dashboard
    function initCharts() {
        // Gráfico de tendencia de ventas
        const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas Totales',
                    data: [125000, 135000, 142000, 138000, 156000, 162000, 158000, 172000, 168000, 182000, 195000, 210000],
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderColor: 'rgba(67, 97, 238, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        // Gráfico de distribución por categoría
        const categoryDistCtx = document.getElementById('categoryDistributionChart').getContext('2d');
        new Chart(categoryDistCtx, {
            type: 'doughnut',
            data: {
                labels: ['Alimentos', 'Bebidas', 'Limpieza', 'Electrónica', 'Otros'],
                datasets: [{
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: [
                        '#4361ee', '#3f37c9', '#4cc9f0', '#4895ef', '#f72585'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw}% (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }
</script>    

<style>
/* Estilos mejorados para el mapa */
#storesMap {
    z-index: 1;
    border-radius: 0.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

/* Marcadores personalizados */
.store-marker {
    width: 36px;
    height: 36px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    position: relative;
    color: white;
    transition: all 0.3s ease;
    transform: translate(-50%, -50%);
    border: 2px solid white;
}

.store-marker:hover {
    transform: translate(-50%, -50%) scale(1.1);
    z-index: 1000;
}

.store-marker.active {
    background: #4361ee;
}

.store-marker.inactive {
    background: #6c757d;
}

.store-marker.high-performance {
    background: #28a745;
}

.store-marker.medium-performance {
    background: #ffc107;
    color: #212529;
}

.store-marker.low-performance {
    background: #dc3545;
}

/* Tooltip mejorado */
.store-marker .marker-tooltip {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    margin-bottom: 8px;
    pointer-events: none;
    min-width: 120px;
    text-align: center;
}

.store-marker:hover .marker-tooltip {
    opacity: 1;
    visibility: visible;
}

/* Popup mejorado */
.leaflet-popup-content {
    min-width: 250px;
}

.store-popup {
    padding: 0.5rem;
}

.store-popup h5 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    color: #4361ee;
    display: flex;
    align-items: center;
}

.store-popup .popup-metrics {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.store-popup .metric-item {
    text-align: center;
    padding: 0.25rem;
    flex: 1;
}

.store-popup .metric-value {
    font-weight: 600;
    font-size: 1rem;
}

.store-popup .metric-label {
    font-size: 0.7rem;
    color: #6c757d;
}

.store-popup .popup-actions {
    margin-top: 0.5rem;
    display: flex;
    gap: 0.5rem;
}

/* Cluster personalizado */
.marker-cluster {
    background-clip: padding-box;
    border-radius: 50%;
    background-color: rgba(67, 97, 238, 0.6);
}

.marker-cluster div {
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    background-color: rgba(67, 97, 238, 0.9);
    color: white;
    border-radius: 50%;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* Controles del mapa */
.leaflet-control-layers {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
}

.leaflet-bar {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
}

/* Heatmap */
.heatmap-layer {
    opacity: 0.7;
}
</style>

<!-- Incluir Heatmap.js -->
<script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>

@endsection