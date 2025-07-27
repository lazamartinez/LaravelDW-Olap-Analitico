<template>
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title>Gestión de Productos</template>
          <template #subtitle>Administración del catálogo de productos</template>
          <template #content>
            <DataTable
              :value="products"
              :paginator="true"
              :rows="10"
              :loading="loading"
              stripedRows
            >
              <Column field="code" header="Código" sortable></Column>
              <Column field="name" header="Nombre" sortable></Column>
              <Column field="category" header="Categoría" sortable></Column>
              <Column field="price" header="Precio" sortable>
                <template #body="{ data }">
                  {{ formatCurrency(data.price) }}
                </template>
              </Column>
              <Column header="Acciones">
                <template #body>
                  <Button icon="pi pi-pencil" class="p-button-rounded p-button-text p-button-success mr-2" />
                  <Button icon="pi pi-trash" class="p-button-rounded p-button-text p-button-danger" />
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
  import { useOlapStore } from '@/stores/olap'
  
  const olapStore = useOlapStore()
  const products = ref([])
  const loading = ref(false)
  
  onMounted(async () => {
    loading.value = true
    await olapStore.fetchProducts()
    products.value = olapStore.products
    loading.value = false
  })
  
  const formatCurrency = (value) => {
    return new Intl.NumberFormat('es-ES', {
      style: 'currency',
      currency: 'EUR'
    }).format(value)
  }
  </script>
  
  <style scoped>
  .p-card {
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  
  .p-datatable {
    font-size: 0.9rem;
  }
  </style>