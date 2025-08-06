@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-chart-pie me-2"></i>Análisis OLAP</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Análisis Multidimensional</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Guardar análisis">
                    <i class="fas fa-save me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Guardar</span>
                </button>
                <button class="btn btn-primary" data-mdb-toggle="tooltip" title="Nuevo análisis">
                    <i class="fas fa-plus me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Nuevo</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Controles OLAP -->
    <div class="col-lg-3">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Controles OLAP</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">Tipo de Análisis</label>
                    <select class="form-select" id="analysisType">
                        <option value="sales">Ventas</option>
                        <option value="products">Productos</option>
                        <option value="customers">Clientes</option>
                        <option value="geo">Geográfico</option>
                        <option value="stores">Sucursales</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>

                <div id="dimensionControls">
                    <div class="mb-3">
                        <label class="form-label">Dimensión Tiempo</label>
                        <select class="form-select" id="timeDimension">
                            <option value="day">Día</option>
                            <option value="week">Semana</option>
                            <option value="month" selected>Mes</option>
                            <option value="quarter">Trimestre</option>
                            <option value="year">Año</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Métrica</label>
                        <select class="form-select" id="metric">
                            <option value="monto_total">Ventas Totales</option>
                            <option value="cantidad_vendida">Unidades Vendidas</option>
                            <option value="margen_ganancia">Margen de Ganancia</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mb-4" id="applyAnalysis">
                    <i class="fas fa-play me-2"></i>Ejecutar Análisis
                </button>

                <!-- Componente Vue de operaciones OLAP -->
                <olap-operations @operation-result="handleOperationResult" @operation-error="handleOperationError"></olap-operations>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div class="col-lg-9">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Resultados del Análisis</h5>
                <div class="d-flex">
                    <button class="btn btn-sm btn-outline-primary me-2" id="exportData" data-mdb-toggle="tooltip" title="Exportar datos">
                        <i class="fas fa-file-export"></i>
                        <span class="d-none d-lg-inline ms-1">Exportar</span>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="visualizationType" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar"></i>
                            <span class="d-none d-lg-inline ms-1">Gráfico</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="visualizationType">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar me-2"></i>Gráfico de Barras</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Gráfico de Líneas</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-pie me-2"></i>Gráfico Circular</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-table me-2"></i>Tabla de Datos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info d-flex align-items-center mb-4 d-none" id="analysisAlert">
                    <i class="fas fa-info-circle me-3 fs-4"></i>
                    <div id="alertMessage"></div>
                    <button type="button" class="btn-close ms-auto" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
                
                <div id="analysisResults">
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Seleccione parámetros y ejecute un análisis</h5>
                        <p class="text-muted small">Use los controles OLAP para explorar los datos multidimensionales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para exportación -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-export me-2"></i>Exportar Datos</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Formato</label>
                    <select class="form-select">
                        <option value="csv">CSV (Excel)</option>
                        <option value="excel">Excel (XLSX)</option>
                        <option value="json">JSON</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rango de datos</label>
                    <select class="form-select">
                        <option value="current">Vista actual</option>
                        <option value="all">Todos los datos</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Exportar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inicializar modales
    const exportModal = new mdb.Modal(document.getElementById('exportModal'));
    
    // Configurar evento de exportación
    document.getElementById('exportData').addEventListener('click', function() {
        exportModal.show();
    });

    // Ejecutar análisis al cambiar parámetros
    document.getElementById('applyAnalysis').addEventListener('click', function() {
        const analysisType = document.getElementById('analysisType').value;
        const timeDimension = document.getElementById('timeDimension').value;
        const metric = document.getElementById('metric').value;
        
        // Mostrar carga
        const resultsDiv = document.getElementById('analysisResults');
        resultsDiv.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h5 class="text-primary">Procesando análisis...</h5>
            </div>
        `;
        
        fetch('/api/olap/load-analysis', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                analysis_type: analysisType,
                time_dimension: timeDimension,
                metric: metric
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('analysisResults').innerHTML = data.html;
            
            // Ocultar alerta si existe
            const alert = document.getElementById('analysisAlert');
            alert.classList.add('d-none');
        })
        .catch(error => {
            console.error('Error:', error);
            const alert = document.getElementById('analysisAlert');
            alert.classList.remove('d-none');
            document.getElementById('alertMessage').textContent = 'Error al cargar el análisis. Intente nuevamente.';
            
            resultsDiv.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                    <h5 class="text-danger">Error en el análisis</h5>
                    <p class="text-muted small">No se pudo cargar el análisis solicitado</p>
                </div>
            `;
        });
    });
});

// Manejar resultados de operaciones OLAP desde Vue
function handleOperationResult(data) {
    const resultsDiv = document.getElementById('analysisResults');
    let content = '';
    
    switch (data.operation) {
        case 'slice':
            content = `
                <div class="mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-cut me-2"></i>
                        Operación SLICE aplicada a ${data.dimension}
                    </h5>
                    <p class="text-muted">Mostrando ${data.count} registros con ${data.dimension} = ${JSON.stringify(data.value)}</p>
                </div>
                ${renderDataTable(data.data)}
            `;
            break;
            
        case 'dice':
            content = `
                <div class="mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-dice me-2"></i>
                        Operación DICE aplicada
                    </h5>
                    <p class="text-muted">Mostrando ${data.count} registros con los filtros aplicados</p>
                </div>
                ${renderDataTable(data.data)}
            `;
            break;
            
        case 'roll_up':
            content = `
                <div class="mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-angle-double-up me-2"></i>
                        Operación ROLL-UP por ${data.dimension}
                    </h5>
                    <p class="text-muted">Agregación por ${data.dimension} usando ${data.metric}</p>
                </div>
                ${renderChart(data.data, data.dimension, data.metric)}
            `;
            break;
            
        case 'drill_down':
            content = `
                <div class="mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-angle-double-down me-2"></i>
                        Operación DRILL-DOWN en ${data.dimension}
                    </h5>
                    <p class="text-muted">Detalle de ${data.parent_value} usando ${data.metric}</p>
                </div>
                ${renderChart(data.data, data.dimension, data.metric)}
            `;
            break;
            
        case 'pivot':
            content = `
                <div class="mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Operación PIVOT
                    </h5>
                    <p class="text-muted">Filas: ${data.rows}, Columnas: ${data.columns}, Métrica: ${data.metric}</p>
                </div>
                ${renderPivotTable(data.data, data.row_values, data.col_values)}
            `;
            break;
    }
    
    resultsDiv.innerHTML = content;
}

function handleOperationError(message) {
    const alert = document.getElementById('analysisAlert');
    alert.classList.remove('d-none');
    document.getElementById('alertMessage').textContent = message;
}

// Funciones auxiliares para renderizar resultados
function renderDataTable(data) {
    if (!data || data.length === 0) return '<p class="text-muted">No hay datos para mostrar</p>';
    
    // Tomar solo las primeras 5 propiedades del primer elemento para la tabla
    const sampleItem = data[0];
    const properties = Object.keys(sampleItem).slice(0, 5);
    
    let table = `
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        ${properties.map(prop => `<th>${prop}</th>`).join('')}
                    </tr>
                </thead>
                <tbody>
    `;
    
    data.slice(0, 100).forEach(item => {
        table += `
            <tr>
                ${properties.map(prop => `<td>${item[prop]}</td>`).join('')}
            </tr>
        `;
    });
    
    table += `
                </tbody>
            </table>
        </div>
        <p class="text-muted small mt-2">Mostrando ${Math.min(data.length, 100)} de ${data.length} registros</p>
    `;
    
    return table;
}

function renderChart(data, dimension, metric) {
    if (!data || data.length === 0) return '<p class="text-muted">No hay datos para graficar</p>';
    
    const labels = data.map(item => item[dimension] || item.row_value || item.category);
    const values = data.map(item => item.total || item[metric]);
    
    return `
        <div class="chart-container" style="height: 400px;">
            <canvas id="olapResultChart"></canvas>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('olapResultChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ${JSON.stringify(labels)},
                        datasets: [{
                            label: '${metric}',
                            data: ${JSON.stringify(values)},
                            backgroundColor: 'rgba(67, 97, 238, 0.7)',
                            borderColor: 'rgba(67, 97, 238, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        <\/script>
    `;
}

function renderPivotTable(data, rowValues, colValues) {
    if (!data || data.length === 0) return '<p class="text-muted">No hay datos para la tabla pivote</p>';
    
    let table = `
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>${data[0].row_value ? 'Categoría' : 'Periodo'}</th>
                        ${colValues.map(col => `<th class="text-center">${col}</th>`).join('')}
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    rowValues.forEach(row => {
        const rowData = data.filter(item => item.row_value === row);
        const rowTotal = rowData.reduce((sum, item) => sum + (item.total || 0), 0);
        
        table += `
            <tr>
                <td><strong>${row}</strong></td>
                ${colValues.map(col => {
                    const cell = rowData.find(item => item.col_value === col);
                    return `<td class="text-end">${cell ? cell.total.toLocaleString() : '0'}</td>`;
                }).join('')}
                <td class="text-end"><strong>${rowTotal.toLocaleString()}</strong></td>
            </tr>
        `;
    });
    
    // Totales por columna
    table += `
            <tr class="table-active">
                <td><strong>Total</strong></td>
                ${colValues.map(col => {
                    const colTotal = data.filter(item => item.col_value === col)
                                       .reduce((sum, item) => sum + (item.total || 0), 0);
                    return `<td class="text-end"><strong>${colTotal.toLocaleString()}</strong></td>`;
                }).join('')}
                <td class="text-end"><strong>${
                    data.reduce((sum, item) => sum + (item.total || 0), 0).toLocaleString()
                }</strong></td>
            </tr>
        </tbody>
            </table>
        </div>
    `;
    
    return table;
}
</script>
@endsection