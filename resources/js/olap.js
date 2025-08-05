class OLAPManager {
    constructor() {
        this.currentAnalysis = null;
        this.currentDimensions = {};
        this.currentMetrics = {};
    }
    
    init(analysisType) {
        this.currentAnalysis = analysisType;
        this.setupDimensions(analysisType);
        this.setupMetrics(analysisType);
        this.loadInitialData();
    }
    
    setupDimensions(analysisType) {
        // Configurar dimensiones según el tipo de análisis
        switch(analysisType) {
            case 'sales':
                this.currentDimensions = {
                    time: ['day', 'week', 'month', 'quarter', 'year'],
                    product: ['category', 'subcategory', 'product'],
                    store: ['region', 'store'],
                    customer: ['segment', 'region']
                };
                break;
            case 'products':
                this.currentDimensions = {
                    time: ['month', 'quarter', 'year'],
                    product: ['category', 'subcategory'],
                    store: ['all', 'region'],
                    metrics: ['sales', 'quantity', 'margin']
                };
                break;
            // ... otros casos
        }
    }
    
    setupMetrics(analysisType) {
        // Configurar métricas disponibles
        switch(analysisType) {
            case 'sales':
                this.currentMetrics = {
                    primary: ['amount', 'quantity', 'transactions'],
                    secondary: ['avg_sale', 'max_sale', 'discount_percent']
                };
                break;
            // ... otros casos
        }
    }
    
    loadInitialData() {
        // Cargar datos iniciales para el análisis
        axios.post('/api/olap/load-analysis', {
            analysis_type: this.currentAnalysis
        }).then(response => {
            this.renderAnalysis(response.data);
        }).catch(error => {
            console.error("Error loading analysis:", error);
        });
    }
    
    renderAnalysis(data) {
        // Renderizar la vista del análisis
        $('#analysisContainer').html(data.html);
        
        // Inicializar gráficos y controles
        this.initCharts();
        this.initOLAPControls();
    }
    
    initCharts() {
        // Inicializar gráficos según el análisis actual
        switch(this.currentAnalysis) {
            case 'sales':
                this.initSalesCharts();
                break;
            case 'products':
                this.initProductsCharts();
                break;
            // ... otros casos
        }
    }
    
    initOLAPControls() {
        // Configurar eventos para controles OLAP
        $('.olap-slice-btn').click(this.handleSlice.bind(this));
        $('.olap-dice-btn').click(this.handleDice.bind(this));
        $('.olap-drilldown-btn').click(this.handleDrillDown.bind(this));
        $('.olap-rollup-btn').click(this.handleRollUp.bind(this));
        $('.olap-pivot-btn').click(this.handlePivot.bind(this));
    }
    
    // Manejadores de operaciones OLAP
    handleSlice(event) {
        const dimension = $(event.currentTarget).data('dimension');
        const value = $(`#${dimension}-filter`).val();
        
        axios.post('/api/olap/slice', {
            dimension: dimension,
            value: value
        }).then(response => {
            this.updateView(response.data);
        });
    }
    
    handleDice(event) {
        const filters = [];
        $('.dimension-filter').each(function() {
            const dimension = $(this).data('dimension');
            const value = $(this).val();
            if (value && value !== 'all') {
                filters.push({ dimension: dimension, value: value });
            }
        });
        
        axios.post('/api/olap/dice', {
            filters: filters
        }).then(response => {
            this.updateView(response.data);
        });
    }
    
    handleDrillDown(event) {
        const dimension = $(event.currentTarget).data('dimension');
        const parentValue = $(event.currentTarget).data('parent-value');
        
        axios.post('/api/olap/drill-down', {
            dimension: dimension,
            parent_value: parentValue,
            metric: this.currentMetric
        }).then(response => {
            this.updateView(response.data);
        });
    }
    
    handleRollUp(event) {
        const dimension = $(event.currentTarget).data('dimension');
        
        axios.post('/api/olap/roll-up', {
            dimension: dimension,
            metric: this.currentMetric
        }).then(response => {
            this.updateView(response.data);
        });
    }
    
    handlePivot(event) {
        const rows = $('#pivot-rows').val();
        const columns = $('#pivot-columns').val();
        
        axios.post('/api/olap/pivot', {
            rows: rows,
            columns: columns,
            metric: this.currentMetric
        }).then(response => {
            this.renderPivotTable(response.data);
        });
    }
    
    updateView(data) {
        // Actualizar la vista con nuevos datos
        switch(data.operation) {
            case 'slice':
                this.updateAfterSlice(data);
                break;
            case 'dice':
                this.updateAfterDice(data);
                break;
            // ... otros casos
        }
    }
    
    updateAfterSlice(data) {
        // Actualizar gráficos y tablas después de un slice
        console.log("Updating view after slice:", data);
        
        // Ejemplo: Actualizar gráfico de tendencias
        if (window.salesChart && data.dimension === 'time') {
            window.salesChart.data.labels = data.data.map(item => 
                `${item.time.mes}/${item.time.anio}`);
            window.salesChart.data.datasets[0].data = data.data.map(item => item.monto_total);
            window.salesChart.update();
        }
    }
    
    renderPivotTable(data) {
        // Crear tabla pivote dinámica
        let html = `
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>${this.getDimensionName(data.rows)}</th>
                        ${data.col_values.map(col => `<th>${col}</th>`).join('')}
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>`;
        
        // Filas de datos
        data.data.forEach(row => {
            const rowTotal = data.col_values.reduce((sum, col) => sum + (row[col] || 0), 0);
            
            html += `
                <tr>
                    <td>${row.row_value}</td>
                    ${data.col_values.map(col => `<td>${this.formatValue(row[col] || 0, data.metric)}</td>`).join('')}
                    <td><strong>${this.formatValue(rowTotal, data.metric)}</strong></td>
                </tr>`;
        });
        
        // Totales por columna
        const colTotals = {};
        data.col_values.forEach(col => {
            colTotals[col] = data.data.reduce((sum, row) => sum + (row[col] || 0), 0);
        });
        const grandTotal = Object.values(colTotals).reduce((sum, val) => sum + val, 0);
        
        html += `
                <tr>
                    <td><strong>Total</strong></td>
                    ${data.col_values.map(col => `<td><strong>${this.formatValue(colTotals[col], data.metric)}</strong></td>`).join('')}
                    <td><strong>${this.formatValue(grandTotal, data.metric)}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>`;
        
        $('#pivot-container').html(html);
    }
    
    getDimensionName(key) {
        // Mapear claves de dimensión a nombres legibles
        const names = {
            'time_year': 'Año',
            'time_quarter': 'Trimestre',
            'product_category': 'Categoría',
            'store_region': 'Región'
        };
        return names[key] || key;
    }
    
    formatValue(value, metric) {
        // Formatear valores según la métrica
        switch(metric) {
            case 'monto_total':
                return `$${value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            case 'cantidad_vendida':
                return value.toLocaleString('es-ES');
            case 'margen_ganancia':
                return `$${value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            default:
                return value;
        }
    }
    
    // Métodos específicos para cada tipo de análisis
    initSalesCharts() {
        // Inicializar gráficos para análisis de ventas
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Ventas',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tendencia de Ventas'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Ventas: $${context.raw.toLocaleString('es-ES')}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return `$${value.toLocaleString('es-ES')}`;
                            }
                        }
                    }
                }
            }
        });
        
        // Cargar datos iniciales
        this.loadSalesData();
    }
    
    loadSalesData() {
        axios.get('/api/olap/sales-trend').then(response => {
            const data = response.data;
            
            // Actualizar gráfico
            window.salesChart.data.labels = data.labels;
            window.salesChart.data.datasets[0].data = data.values;
            window.salesChart.update();
            
            // Actualizar tabla
            this.updateSalesTable(data.tableData);
        });
    }
    
    updateSalesTable(data) {
        let html = '';
        data.forEach(item => {
            html += `
            <tr>
                <td>${item.period}</td>
                <td>$${item.total_sales.toLocaleString('es-ES', {minimumFractionDigits: 2})}</td>
                <td>${item.total_quantity.toLocaleString('es-ES')}</td>
                <td>${item.margin_percent}%</td>
                <td class="${item.variance >= 0 ? 'text-success' : 'text-danger'}">
                    ${item.variance >= 0 ? '+' : ''}${item.variance}%
                </td>
            </tr>`;
        });
        
        $('#salesTableBody').html(html);
    }
}

// Inicializar OLAPManager global
window.olapManager = new OLAPManager();

// Función para cargar análisis desde el dashboard
function loadAnalysis(type) {
    olapManager.init(type);
}