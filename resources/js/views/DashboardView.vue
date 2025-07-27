<template>
    <div class="grid">
      <div class="col-12">
        <div class="grid">
          <div class="col-12 md:col-6 lg:col-3">
            <MetricCard 
              title="Ventas Totales" 
              :value="totalSales" 
              icon="pi pi-dollar"
              color="bg-blue-500"
            />
          </div>
          <!-- Más métricas -->
        </div>
  
        <TabView class="mt-5">
          <TabPanel header="Análisis General">
            <SalesAnalysis />
          </TabPanel>
          <TabPanel header="Drill-Down">
            <DrillDownAnalysis />
          </TabPanel>
          <TabPanel header="Tabla Pivot">
            <PivotAnalysis />
          </TabPanel>
          <TabPanel header="Roll-Up">
            <RollUpAnalysis />
          </TabPanel>
        </TabView>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useOlapStore } from '../stores/olap'
  import SalesAnalysis from '../components/olap/SalesAnalysis.vue'
  import DrillDownAnalysis from '../components/olap/DrillDownAnalysis.vue'
  import PivotAnalysis from '../components/olap/PivotAnalysis.vue'
  import RollUpAnalysis from '../components/olap/RollUpAnalysis.vue'
  import MetricCard from '../components/ui/MetricCard.vue'
  
  const olapStore = useOlapStore()
  const totalSales = ref(0)
  
  onMounted(async () => {
    await olapStore.fetchSalesData()
    totalSales.value = olapStore.metrics.total_sales
  })
  </script>