<template>
  <MainLayout>
    <div class="main-content">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tarjeta de Resumen -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Resumen General</h3>
            <button class="btn btn-outline">Ver Detalles</button>
          </div>
          <SalesChart :data="salesData" />
        </div>

        <!-- Gráfico de Categorías -->
        <div class="card">
          <div class="chart-header">
            <h3>Ventas por Categoría</h3>
            <div class="chart-actions">
              <button class="btn btn-primary">Exportar</button>
            </div>
          </div>
          <CategoryPieChart :data="categoryData" />
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from '@/ui/MainLayout.vue';
import SalesChart from '@/charts/SalesChart.vue';
import CategoryPieChart from '@/charts/CategoryPieChart.vue';

export default {
  components: {
    MainLayout,
    SalesChart,
    CategoryPieChart
  },
  data() {
    return {
      salesData: [],
      categoryData: []
    }
  },
  async mounted() {
    await this.fetchData();
  },
  methods: {
    async fetchData() {
      // Lógica para obtener datos
    }
  }
}
</script>

<style lang="scss" scoped>
// Estilos específicos del componente si son necesarios
.grid {
  display: grid;
  gap: map-get($spacings, 4);
}
</style>