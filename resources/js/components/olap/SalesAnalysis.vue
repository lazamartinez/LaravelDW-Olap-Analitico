<template>
    <div>
      <div class="grid">
        <div class="col-12 md:col-6">
          <SalesChart :data="salesData" />
        </div>
        <div class="col-12 md:col-6">
          <DataTable
            :value="sales"
            paginator
            :rows="10"
            :loading="loading"
          >
            <Column field="product.name" header="Producto" sortable></Column>
            <Column field="store.name" header="Sucursal" sortable></Column>
            <Column field="quantity_sold" header="Cantidad" sortable></Column>
            <Column field="net_amount" header="Total" sortable>
              <template #body="{ data }">
                {{ formatCurrency(data.net_amount) }}
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useOlapStore } from '../../stores/olap'
  import SalesChart from '../charts/SalesChart.vue'
  
  const olapStore = useOlapStore()
  const loading = ref(false)
  const sales = ref([])
  
  onMounted(async () => {
    loading.value = true
    await olapStore.fetchSalesData()
    sales.value = olapStore.sales
    loading.value = false
  })
  
  const salesData = computed(() => olapStore.processSalesChartData())
  </script>