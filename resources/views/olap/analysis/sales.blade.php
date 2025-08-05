<div class="analysis-card card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-chart-line text-primary me-2"></i>Análisis de Ventas
        </h5>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-mdb-toggle="dropdown">
                <i class="fas fa-cog"></i> Opciones
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="exportAnalysis('sales')">Exportar</a></li>
                <li><a class="dropdown-item" href="#" onclick="saveAnalysis('sales')">Guardar</a></li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <!-- Filtros OLAP -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">Dimensión Temporal</label>
                <select class="form-select dimension-selector" id="timeDimension">
                    @foreach($timeDimensions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Métrica</label>
                <select class="form-select dimension-selector" id="salesMetric">
                    @foreach($metrics as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sucursal</label>
                <select class="form-select dimension-selector" id="storeFilter">
                    <option value="all">Todas</option>
                    @foreach(DimensionStore::limit(10)->get() as $store)
                        <option value="{{ $store->sucursal_id }}">{{ $store->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="applySalesFilters()">
                    <i class="fas fa-filter me-1"></i> Aplicar
                </button>
            </div>
        </div>
        
        <!-- Gráficos OLAP -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Tendencia de Ventas</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salesTrendChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Método de Pago</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentMethodChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla de Detalle -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Detalle de Ventas</h6>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" onclick="drillDownSales()">
                                <i class="fas fa-search-plus me-1"></i> Drill Down
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="rollUpSales()">
                                <i class="fas fa-search-minus me-1"></i> Roll Up
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="salesDetailTable">
                                <thead>
                                    <tr>
                                        <th>Periodo</th>
                                        <th>Ventas Totales</th>
                                        <th>Unidades</th>
                                        <th>Margen</th>
                                        <th>% Var.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesTrend as $item)
                                    <tr>
                                        <td>{{ $item->year }}-{{ str_pad($item->month, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>${{ number_format($item->total_sales, 2) }}</td>
                                        <td>{{ number_format($item->total_quantity) }}</td>
                                        <td>15%</td>
                                        <td class="text-success">+5%</td>
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
</div>

<script>
    function applySalesFilters() {
        const timeDimension = $('#timeDimension').val();
        const metric = $('#salesMetric').val();
        const store = $('#storeFilter').val();
        
        // Aquí iría la llamada AJAX para actualizar los datos
        console.log("Aplicando filtros:", { timeDimension, metric, store });
        
        // Ejemplo de actualización de gráficos
        updateSalesCharts(timeDimension, metric, store);
    }
    
    function updateSalesCharts(timeDimension, metric, store) {
        // Simulación de actualización de datos
        console.log("Actualizando gráficos con nueva configuración OLAP");
        
        // En una implementación real, haríamos una llamada AJAX para obtener nuevos datos
        // y luego actualizaríamos los gráficos con Chart.js
    }
    
    function drillDownSales() {
        console.log("Ejecutando operación OLAP: Drill Down");
        // Lógica para mostrar mayor detalle
    }
    
    function rollUpSales() {
        console.log("Ejecutando operación OLAP: Roll Up");
        // Lógica para agregar datos a un nivel superior
    }
</script>