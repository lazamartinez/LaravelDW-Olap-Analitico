@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-sync-alt me-2"></i>Procesos ETL</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Extracción, Transformación y Carga</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary me-2" id="runEtlBtn">
                    <i class="fas fa-play me-1"></i>Ejecutar ETL
                </button>
                <button class="btn btn-outline-secondary" data-mdb-toggle="tooltip" title="Configuración">
                    <i class="fas fa-cog"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Ejecuciones</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="historyFilter" data-mdb-toggle="dropdown" aria-expanded="false">
                        Últimos 30 días
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="historyFilter">
                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                        <li><a class="dropdown-item" href="#">Ayer</a></li>
                        <li><a class="dropdown-item active" href="#">Últimos 30 días</a></li>
                        <li><a class="dropdown-item" href="#">Este mes</a></li>
                        <li><a class="dropdown-item" href="#">Todos</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha Ejecución</th>
                                <th>Tipo</th>
                                <th>Registros</th>
                                <th>Duración</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="etlHistoryTable">
                            <!-- Datos dinámicos desde API -->
                            <tr>
                                <td>#1254</td>
                                <td>2023-11-15 03:15:00</td>
                                <td><span class="badge bg-primary">Completo</span></td>
                                <td>12,458</td>
                                <td>2m 45s</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-mdb-toggle="tooltip" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card glass-card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Estadísticas ETL</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-muted">Última ejecución</h6>
                            <h4 class="mb-0">Hoy 03:15 AM</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-muted">Próxima ejecución</h6>
                            <h4 class="mb-0">Hoy 04:15 AM</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-muted">Registros/día</h6>
                            <h4 class="mb-0">12,458</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-muted">Tiempo promedio</h6>
                            <h4 class="mb-0">2m 45s</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card glass-card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Tendencia de Carga</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 200px;">
                    <canvas id="etlTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Configurar gráfico de tendencia ETL
    const etlTrendCtx = document.getElementById('etlTrendChart').getContext('2d');
    new Chart(etlTrendCtx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Registros procesados',
                data: [8500, 10200, 9800, 11000, 12458, 9500, 8200],
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
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Manejar clic en Ejecutar ETL
    document.getElementById('runEtlBtn').addEventListener('click', function() {
        const btn = this;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Ejecutando...';
        btn.disabled = true;
        
        fetch('/api/etl/run', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success('Proceso ETL ejecutado correctamente');
                // Recargar tabla de historial
                loadEtlHistory();
            } else {
                toastr.error(data.message || 'Error en el proceso ETL');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error al ejecutar el proceso ETL');
        })
        .finally(() => {
            btn.innerHTML = '<i class="fas fa-play me-1"></i> Ejecutar ETL';
            btn.disabled = false;
        });
    });

    function loadEtlHistory() {
        // Implementar carga de historial ETL desde API
        console.log('Cargando historial ETL...');
    }
});
</script>
@endsection