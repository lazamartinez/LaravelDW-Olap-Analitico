<template>
  <div class="sales-analysis">
    <div class="filters">
      <Dropdown v-model="selectedCategory" :options="categories" optionLabel="category" 
               placeholder="Seleccione categoría" class="filter-item" />
      <Dropdown v-model="selectedYear" :options="years" placeholder="Seleccione año" 
               class="filter-item" />
      <Button label="Aplicar filtros" @click="applyFilters" />
    </div>
    
    <DataTable :value="salesData" class="p-datatable-sm" stripedRows>
      <Column field="product.name" header="Producto" />
      <Column field="store.name" header="Sucursal" />
      <Column field="total_quantity" header="Cantidad" />
      <Column field="total_sales" header="Ventas">
        <template #body="{data}">
          ${{ data.total_sales.toFixed(2) }}
        </template>
      </Column>
    </DataTable>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useOlapStore } from '@/stores/olap'

export default {
  setup() {
    const olapStore = useOlapStore()
    const salesData = ref([])
    const selectedCategory = ref(null)
    const selectedYear = ref(null)
    const categories = ref([])
    const years = ref([2023, 2024, 2025])
    
    const fetchData = async () => {
      const params = {}
      if (selectedCategory.value) params.product_category = selectedCategory.value.category
      if (selectedYear.value) params.year = selectedYear.value
      
      await olapStore.fetchSalesData(params)
      salesData.value = olapStore.salesData
    }
    
    const applyFilters = () => {
      fetchData()
    }
    
    onMounted(async () => {
      await fetchData()
      // Obtener categorías únicas para el dropdown
      categories.value = [...new Set(salesData.value.map(item => item.product.category))]
        .map(category => ({ category }))
    })
    
    return {
      salesData,
      selectedCategory,
      selectedYear,
      categories,
      years,
      applyFilters
    }
  }
}
</script>

<style scoped>
.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}
.filter-item {
  min-width: 200px;
}
</style>