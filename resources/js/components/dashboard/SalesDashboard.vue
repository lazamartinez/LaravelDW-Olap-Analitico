<template>
  <div class="sales-dashboard">
    <div class="dashboard-header mb-4">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h2 class="mb-0">
            <i class="bi bi-speedometer2 me-2"></i>
            Panel Analítico
          </h2>
        </div>
        <div class="col-md-4">
          <OLAPControls @query="executeOLAPQuery" />
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-3" v-for="(metric, key) in metrics" :key="key">
        <div class="card metric-card h-100">
          <div class="card-body text-center">
            <h6 class="text-uppercase text-muted mb-2">{{ metric.title }}</h6>
            <h3 class="mb-0">{{ formatNumber(metric.value) }}</h3>
            <p class="text-muted mb-0">
              <small>{{ metric.description }}</small>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0">
              <i class="bi bi-bar-chart-line me-2"></i>
              {{ chartTitle }}
            </h5>
          </div>
          <div class="card-body">
            <apexchart 
              :type="chartType" 
              height="350" 
              :options="chartOptions" 
              :series="chartSeries" 
            />
          </div>
        </div>
      </div>
      
      <div class="col-lg-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0">
              <i class="bi bi-pie-chart me-2"></i>
              Distribución
            </h5>
          </div>
          <div class="card-body">
            <apexchart 
              type="donut" 
              height="350" 
              :options="pieOptions" 
              :series="pieSeries" 
            />
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0">
              <i class="bi bi-table me-2"></i>
              Datos Detallados
            </h5>
            <div class="float-end">
              <button class="btn btn-sm btn-outline-primary" @click="exportToExcel">
                <i class="bi bi-download me-1"></i> Exportar
              </button>
            </div>
          </div>
          <div class="card-body">
            <div v-if="loadingData" class="text-center py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
              </div>
              <p class="mt-2">Procesando consulta...</p>
            </div>
            
            <div v-else>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th v-for="header in resultHeaders" :key="header">
                        {{ header }}
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(row, index) in resultData" :key="index">
                      <td v-for="(value, key) in row" :key="key">
                        {{ formatValue(value, key) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <nav v-if="resultData.length > 0">
                <ul class="pagination justify-content-center">
                  <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button class="page-link" @click="prevPage">Anterior</button>
                  </li>
                  <li class="page-item" v-for="page in pages" :key="page" 
                      :class="{ active: currentPage === page }">
                    <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                  </li>
                  <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <button class="page-link" @click="nextPage">Siguiente</button>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import moment from 'moment';

export default {
  setup() {
    const metrics = ref({
      total_sales: { value: 0, title: 'Ventas Totales', description: 'Acumulado histórico' },
      total_products: { value: 0, title: 'Productos', description: 'En catálogo' },
      total_stores: { value: 0, title: 'Sucursales', description: 'Activas' },
      avg_sale: { value: 0, title: 'Ticket Promedio', description: 'Por transacción' }
    });
    
    const resultData = ref([]);
    const resultHeaders = ref([]);
    const loadingData = ref(false);
    const currentQuery = ref(null);
    
    // Configuración de gráficos
    const chartType = ref('bar');
    const chartTitle = ref('Ventas por Producto');
    const chartOptions = ref({
      chart: { type: 'bar', toolbar: { show: true } },
      colors: ['#4e73df', '#1cc88a', '#36b9cc'],
      plotOptions: { bar: { borderRadius: 4, horizontal: false } },
      dataLabels: { enabled: false },
      xaxis: { type: 'category' },
      tooltip: { theme: 'light' }
    });
    const chartSeries = ref([{ name: 'Ventas', data: [] }]);
    
    const pieOptions = ref({
      chart: { type: 'donut' },
      labels: [],
      colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
      legend: { position: 'bottom' },
      tooltip: { theme: 'light' }
    });
    const pieSeries = ref([]);
    
    // Paginación
    const currentPage = ref(1);
    const itemsPerPage = 10;
    
    const totalPages = computed(() => 
      Math.ceil(resultData.value.length / itemsPerPage)
    );
    
    const pages = computed(() => {
      const range = [];
      const start = Math.max(1, currentPage.value - 2);
      const end = Math.min(totalPages.value, currentPage.value + 2);
      
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      
      return range;
    });
    
    const paginatedData = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return resultData.value.slice(start, end);
    });
    
    onMounted(async () => {
      await loadMetrics();
      await loadDefaultData();
    });
    
    const loadMetrics = async () => {
      try {
        const response = await axios.get('/api/olap/metrics');
        metrics.value.total_sales.value = response.data.total_sales;
        metrics.value.total_products.value = response.data.total_products;
        metrics.value.total_stores.value = response.data.total_stores;
        metrics.value.avg_sale.value = response.data.avg_sale;
      } catch (error) {
        console.error('Error loading metrics:', error);
      }
    };
    
    const loadDefaultData = async () => {
      try {
        loadingData.value = true;
        
        // Datos para gráfico principal
        const productsResponse = await axios.get('/api/olap/query', {
          params: {
            dimension: 'producto',
            metric: 'monto_total',
            limit: 10
          }
        });
        
        updateChart(
          productsResponse.data,
          'Ventas por Producto',
          'bar',
          productsResponse.data.map(item => item.nombre_producto),
          [{ 
            name: 'Ventas Totales', 
            data: productsResponse.data.map(item => item.monto_total) 
          }]
        );
        
        // Datos para gráfico de donut
        const categoryResponse = await axios.get('/api/olap/query', {
          params: {
            dimension: 'producto',
            metric: 'monto_total',
            group: 'categoria'
          }
        });
        
        updatePieChart(
          categoryResponse.data.map(item => item.categoria),
          categoryResponse.data.map(item => item.monto_total)
        );
        
        // Datos para tabla
        const salesResponse = await axios.get('/api/olap/query', {
          params: {
            dimension: 'producto',
            metric: 'monto_total',
            timeLevel: 'mes'
          }
        });
        
        resultData.value = salesResponse.data;
        resultHeaders.value = ['Producto', 'Categoría', 'Ventas Totales', 'Mes'];
        
      } catch (error) {
        console.error('Error loading dashboard data:', error);
      } finally {
        loadingData.value = false;
      }
    };
    
    const executeOLAPQuery = async (queryParams) => {
      try {
        loadingData.value = true;
        currentQuery.value = queryParams;
        currentPage.value = 1;
        
        const response = await axios.post('/api/olap/query', queryParams);
        
        // Actualizar gráficos según la dimensión
        if (queryParams.dimension === 'producto') {
          updateChart(
            response.data,
            'Ventas por Producto',
            'bar',
            response.data.map(item => item.nombre_producto),
            [{ 
              name: queryParams.metric === 'monto_total' ? 'Ventas Totales' : 
                    queryParams.metric === 'cantidad_vendida' ? 'Unidades Vendidas' : 'Margen de Ganancia',
              data: response.data.map(item => item[queryParams.metric])
            }]
          );
          
          resultHeaders.value = ['Producto', 'Categoría', 'Ventas Totales'];
        } 
        else if (queryParams.dimension === 'tiempo') {
          const labels = queryParams.timeLevel === 'dia' ? 
            response.data.map(item => moment(item.fecha).format('DD MMM YYYY')) :
            queryParams.timeLevel === 'mes' ?
            response.data.map(item => `${item.nombre_mes} ${item.anio}`) :
            response.data.map(item => `T${item.trimestre} ${item.anio}`);
          
          updateChart(
            response.data,
            `Ventas por ${queryParams.timeLevel === 'dia' ? 'Día' : 
              queryParams.timeLevel === 'mes' ? 'Mes' : 'Trimestre'}`,
            'line',
            labels,
            [{ 
              name: queryParams.metric === 'monto_total' ? 'Ventas Totales' : 
                    queryParams.metric === 'cantidad_vendida' ? 'Unidades Vendidas' : 'Margen de Ganancia',
              data: response.data.map(item => item[queryParams.metric])
            }]
          );
          
          resultHeaders.value = [
            queryParams.timeLevel === 'dia' ? 'Fecha' : 
            queryParams.timeLevel === 'mes' ? 'Mes' : 'Trimestre',
            'Ventas Totales'
          ];
        }
        
        resultData.value = response.data;
        
      } catch (error) {
        console.error('Error executing OLAP query:', error);
      } finally {
        loadingData.value = false;
      }
    };
    
    const updateChart = (data, title, type, categories, series) => {
      chartTitle.value = title;
      chartType.value = type;
      
      chartOptions.value = {
        ...chartOptions.value,
        xaxis: {
          ...chartOptions.value.xaxis,
          categories: categories
        }
      };
      
      chartSeries.value = series;
    };
    
    const updatePieChart = (labels, series) => {
      pieOptions.value = {
        ...pieOptions.value,
        labels: labels
      };
      
      pieSeries.value = series;
    };
    
    const formatValue = (value, key) => {
      if (typeof value === 'number') {
        return key === 'monto_total' || key === 'margen_ganancia' ?
          new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'USD' }).format(value) :
          new Intl.NumberFormat('es-ES').format(value);
      }
      return value;
    };
    
    const formatNumber = (value) => {
      return new Intl.NumberFormat('es-ES', { 
        style: 'currency', 
        currency: 'USD',
        maximumFractionDigits: 0
      }).format(value);
    };
    
    // Métodos de paginación
    const prevPage = () => {
      if (currentPage.value > 1) currentPage.value--;
    };
    
    const nextPage = () => {
      if (currentPage.value < totalPages.value) currentPage.value++;
    };
    
    const goToPage = (page) => {
      currentPage.value = page;
    };
    
    const exportToExcel = () => {
      // Implementar lógica de exportación
      console.log('Exporting data...', resultData.value);
    };
    
    return {
      metrics,
      resultData: paginatedData,
      resultHeaders,
      loadingData,
      chartType,
      chartTitle,
      chartOptions,
      chartSeries,
      pieOptions,
      pieSeries,
      currentPage,
      pages,
      totalPages,
      executeOLAPQuery,
      formatValue,
      formatNumber,
      prevPage,
      nextPage,
      goToPage,
      exportToExcel
    };
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:map';
@use 'sass:color';

// Variables de tema
$theme-colors: (
  primary: #4e73df,
  secondary: #6c757d,
  success: #1cc88a,
  info: #36b9cc,
  warning: #f6c23e,
  danger: #e74a3b,
  light: #f8f9fa,
  dark: #5a5c69
);

$spacing: (
  xs: 0.5rem,
  sm: 1rem,
  md: 1.5rem,
  lg: 2rem,
  xl: 3rem
);

$border-radius: (
  sm: 0.25rem,
  md: 0.5rem,
  lg: 0.75rem,
  pill: 50rem
);

// Mixins útiles
@mixin card-shadow {
  box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  
  &:hover {
    box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    transform: translateY(-3px);
  }
}

@mixin gradient-bg($color) {
  background: linear-gradient(
    to right,
    $color,
    color.adjust($color, $lightness: 5%)
  );
}

.sales-dashboard {
  padding: map.get($spacing, md);
  background-color: #f8f9fc;
  min-height: 100vh;

  .dashboard-header {
    background: white;
    padding: map.get($spacing, lg);
    border-radius: map.get($border-radius, lg);
    margin-bottom: map.get($spacing, lg);
    @include card-shadow;
    
    h2 {
      color: map.get($theme-colors, dark);
      font-weight: 700;
      display: flex;
      align-items: center;
      
      i {
        color: map.get($theme-colors, primary);
        font-size: 1.5rem;
      }
    }
  }

  .metric-card {
    border: none;
    border-radius: map.get($border-radius, lg);
    overflow: hidden;
    @include card-shadow;
    
    .card-body {
      padding: map.get($spacing, md);
      position: relative;
      z-index: 1;
      
      &::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        @include gradient-bg(map.get($theme-colors, primary));
        opacity: 0.1;
        z-index: -1;
      }
    }
    
    h6 {
      font-size: 0.75rem;
      letter-spacing: 0.05em;
      color: map.get($theme-colors, secondary);
      margin-bottom: map.get($spacing, sm);
      font-weight: 600;
    }
    
    h3 {
      font-weight: 700;
      color: map.get($theme-colors, dark);
      margin-bottom: map.get($spacing, xs);
      font-size: 1.75rem;
    }
    
    p {
      font-size: 0.8rem;
      color: map.get($theme-colors, secondary);
      margin-bottom: 0;
    }
    
    // Colores diferentes para cada tarjeta
    &:nth-child(1) .card-body::before {
      @include gradient-bg(map.get($theme-colors, primary));
    }
    &:nth-child(2) .card-body::before {
      @include gradient-bg(map.get($theme-colors, success));
    }
    &:nth-child(3) .card-body::before {
      @include gradient-bg(map.get($theme-colors, info));
    }
    &:nth-child(4) .card-body::before {
      @include gradient-bg(map.get($theme-colors, warning));
    }
  }

  .card {
    border: none;
    border-radius: map.get($border-radius, lg);
    overflow: hidden;
    @include card-shadow;
    
    .card-header {
      background: white;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      padding: map.get($spacing, md);
      
      h5 {
        font-weight: 600;
        color: map.get($theme-colors, dark);
        display: flex;
        align-items: center;
        
        i {
          margin-right: map.get($spacing, sm);
          color: map.get($theme-colors, primary);
        }
      }
    }
    
    .card-body {
      padding: map.get($spacing, md);
    }
  }

  .table-responsive {
    border-radius: map.get($border-radius, md);
    overflow: hidden;
  }
  
  .table {
    margin-bottom: 0;
    
    thead {
      th {
        background-color: map.get($theme-colors, primary);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        padding: map.get($spacing, sm);
        border-bottom: none;
        
        &:first-child {
          border-top-left-radius: map.get($border-radius, sm);
        }
        
        &:last-child {
          border-top-right-radius: map.get($border-radius, sm);
        }
      }
    }
    
    tbody {
      tr {
        transition: background-color 0.2s;
        
        &:hover {
          background-color: rgba(map.get($theme-colors, primary), 0.05);
        }
        
        td {
          padding: map.get($spacing, sm);
          vertical-align: middle;
          border-top: 1px solid rgba(0, 0, 0, 0.03);
        }
      }
    }
  }

  .pagination {
    margin-top: map.get($spacing, md);
    
    .page-item {
      margin: 0 map.get($spacing, xs);
      
      .page-link {
        border: none;
        border-radius: map.get($border-radius, sm);
        color: map.get($theme-colors, dark);
        font-weight: 600;
        min-width: 2.5rem;
        text-align: center;
        transition: all 0.3s;
        
        &:hover {
          background-color: rgba(map.get($theme-colors, primary), 0.1);
          color: map.get($theme-colors, primary);
        }
      }
      
      &.active .page-link {
        background-color: map.get($theme-colors, primary);
        color: white;
      }
      
      &.disabled .page-link {
        color: map.get($theme-colors, secondary);
        opacity: 0.5;
      }
    }
  }

  .btn-outline-primary {
    border-width: 2px;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    
    &:hover {
      background-color: map.get($theme-colors, primary);
      color: white;
    }
  }

  // Estilo para el estado de carga
  .loading-state {
    padding: map.get($spacing, xl) 0;
    
    .spinner-border {
      width: 3rem;
      height: 3rem;
      border-width: 0.25em;
    }
    
    p {
      margin-top: map.get($spacing, md);
      color: map.get($theme-colors, secondary);
      font-weight: 500;
    }
  }
}
</style>