@extends('layouts.app')

@section('title', 'Monitoreo ETL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Monitoreo de Procesos ETL
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Última Ejecución</h6>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h2 class="mb-0">{{ $lastRun->duration }}s</h2>
                                        <small class="text-muted">Duración</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $lastRun->success ? 'success' : 'danger' }}">
                                            {{ $lastRun->success ? 'Éxito' : 'Falló' }}
                                        </span>
                                        <div class="text-muted small">
                                            {{ $lastRun->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Historial de Ejecuciones</h6>
                                <canvas id="etlHistoryChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Registros de Ejecución</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Tipo</th>
                                                <th>Duración</th>
                                                <th>Registros</th>
                                                <th>Estado</th>
                                                <th>Error</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($executions as $exec)
                                            <tr>
                                                <td>{{ $exec->created_at->format('Y-m-d H:i') }}</td>
                                                <td>{{ $exec->type === 'full' ? 'Completo' : 'Incremental' }}</td>
                                                <td>{{ $exec->duration }}s</td>
                                                <td>{{ number_format($exec->records_processed) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $exec->success ? 'success' : 'danger' }}">
                                                        {{ $exec->success ? 'Éxito' : 'Falló' }}
                                                    </span>
                                                </td>
                                                <td class="text-truncate" style="max-width: 200px;" title="{{ $exec->error_message }}">
                                                    {{ $exec->error_message }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                {{ $executions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('etlHistoryChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($historyLabels),
                datasets: [{
                    label: 'Duración (segundos)',
                    data: @json($historyData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
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
</script>
@endpush