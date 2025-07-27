<template>
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title>Análisis de Ventas</template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6 lg:col-3">
                <MetricCard 
                  title="Ventas Totales" 
                  :value="metrics.total_sales" 
                  icon="pi pi-dollar"
                  color="bg-blue-500"
                  :loading="loading"
                />
              </div>
              <!-- Más métricas -->
            </div>
            
            <div class="grid mt-5">
              <div class="col-12 md:col-6">
                <SalesChart :data="salesData" />
              </div>
              <div class="col-12 md:col-6">
                <CategoryPieChart :data="categoryData" />
              </div>
            </div>
            
            <DataTable
              :value="sales"
              :loading="loading"
              paginator
              :rows="10"
              class="mt-5"
            >
              <Column field="product.name" header="Producto"></Column>
              <Column field="store.name" header="Sucursal"></Column>
              <Column field="quantity_sold" header="Cantidad"></Column>
              <Column field="net_amount" header="Total">
                <template #body="{ data }">
                  {{ formatCurrency(data.net_amount) }}
                </template>
              </Column>
            </DataTable>
          </template>
        </Card>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useOlapStore } from '../../stores/olap'
  import MetricCard from '../ui/MetricCard.vue'
  import SalesChart from '../charts/SalesChart.vue'
  import CategoryPieChart from '../charts/CategoryPieChart.vue'
  
  const olapStore = useOlapStore()
  const loading = ref(false)
  const sales = ref([])
  const metrics = ref({})
  const salesData = ref({})
  const categoryData = ref({})
  
  onMounted(async () => {
    loading.value = true
    await olapStore.fetchSalesData()
    sales.value = olapStore.sales
    metrics.value = olapStore.metrics
    salesData.value = processChartData(olapStore.sales)
    categoryData.value = processCategoryData(olapStore.sales)
    loading.value = false
  })
  
  function processChartData(rawData) {
    // Transformar datos para gráficos
    return {
      labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
      datasets: [
        {
          label: 'Ventas 2025',
          data: [65, 59, 80, 81, 56, 55],
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }
      ]
    }
  }
  
  function formatCurrency(value) {
    return new Intl.NumberFormat('es-ES', {
      style: 'currency',
      currency: 'EUR'
    }).format(value)
  }
  </script>