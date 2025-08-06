<div class="analysis-container">
    <div class="row g-4">
        <div class="col-12">
            <div class="card glass-card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-chart-line me-2"></i>
                        Tendencias de Ventas por {{ ucfirst($timeDimension) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card glass-card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-chart-pie me-2"></i>
                        Distribución por Categoría
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="categoryDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card glass-card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-star me-2"></i>
                        Top Productos
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="topProductsDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                            Por {{ ucfirst(str_replace('_', ' ', $metric)) }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="topProductsDropdown">
                            <li><a class="dropdown-item" href="#">Por Ventas Totales</a></li>
                            <li><a class="dropdown-item" href="#">Por Unidades Vendidas</a></li>
                            <li><a class="dropdown-item" href="#">Por Margen</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryDistribution->take(5) as $category)
                                <tr>
                                    <td>{{ $category->categoria }}</td>
                                    <td class="text-end">
                                        @if($metric === 'monto_total')
                                            ${{ number_format($category->total, 2) }}
                                        @else
                                            {{ number_format($category->total) }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Gráfico de tendencia de ventas
    const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
    new Chart(salesTrendCtx, {
        type: 'line',
        data: {
            labels: @json($salesTrend->pluck('period')),
            datasets: [{
                label: '{{ ucfirst(str_replace('_', ' ', $metric)) }}',
                data: @json($salesTrend->pluck('total')),
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
                            return '{{ $metric === 'monto_total' ? '$' : '' }}' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '{{ $metric === 'monto_total' ? '$' : '' }}' + value.toLocaleString();
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
            labels: @json($categoryDistribution->pluck('categoria')),
            datasets: [{
                data: @json($categoryDistribution->pluck('total')),
                backgroundColor: [
                    '#4361ee', '#3f37c9', '#4cc9f0', '#4895ef', '#f72585', '#b5179e'
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
                            return `${context.label}: ${context.raw.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
});
</script>