<template>
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title>Análisis de Ventas</template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <SalesChart />
              </div>
              <div class="col-12 md:col-6">
                <DataTable :value="sales" class="p-datatable-sm">
                  <Column field="date" header="Fecha"></Column>
                  <Column field="product" header="Producto"></Column>
                  <Column field="amount" header="Monto"></Column>
                </DataTable>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import SalesChart from '@/components/charts/SalesChart.vue'
  
  const sales = ref([
    { date: '2023-01-01', product: 'Producto A', amount: 1500 },
    { date: '2023-01-02', product: 'Producto B', amount: 2300 }
  ])
  </script>