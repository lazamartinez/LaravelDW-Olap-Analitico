<template>
  <div class="olap-controls card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">
        <i class="bi bi-bar-chart-line me-2"></i>
        Consulta OLAP
      </h5>
    </div>
    <div class="card-body">
      <form @submit.prevent="executeQuery" class="needs-validation" novalidate>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Dimensión</label>
            <select v-model="query.dimension" class="form-select" required>
              <option value="producto">Producto</option>
              <option value="tiempo">Tiempo</option>
              <option value="sucursal">Sucursal</option>
              <option value="cliente">Cliente</option>
            </select>
          </div>
          
          <div class="col-md-6">
            <label class="form-label fw-bold">Métrica</label>
            <select v-model="query.metric" class="form-select" required>
              <option value="monto_total">Ventas Totales</option>
              <option value="cantidad_vendida">Unidades Vendidas</option>
              <option value="margen_ganancia">Margen de Ganancia</option>
            </select>
          </div>
          
          <div class="col-md-6" v-if="query.dimension === 'tiempo'">
            <label class="form-label fw-bold">Nivel Temporal</label>
            <select v-model="query.timeLevel" class="form-select" required>
              <option value="dia">Día</option>
              <option value="mes">Mes</option>
              <option value="trimestre">Trimestre</option>
              <option value="anio">Año</option>
            </select>
          </div>
          
          <div class="col-md-6" v-if="query.dimension === 'producto'">
            <label class="form-label fw-bold">Categoría</label>
            <select v-model="query.category" class="form-select">
              <option value="">Todas las categorías</option>
              <option v-for="cat in categories" :value="cat">{{ cat }}</option>
            </select>
          </div>
          
          <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary w-100 py-2">
              <i class="bi bi-lightning-charge-fill me-2"></i>
              Ejecutar Consulta
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  emits: ['query'],
  setup(props, { emit }) {
    const query = ref({
      dimension: 'producto',
      metric: 'monto_total',
      timeLevel: 'mes',
      category: ''
    });
    
    const categories = ref([]);
    
    const executeQuery = () => {
      const filters = [];
      if (query.value.category) {
        filters.push({
          field: 'p.categoria',
          operator: '=',
          value: query.value.category
        });
      }
      
      emit('query', {
        ...query.value,
        filters
      });
    };
    
    onMounted(async () => {
      try {
        const response = await axios.get('/api/olap/metrics');
        // Puedes usar estos datos para mejorar la UI
      } catch (error) {
        console.error('Error loading metrics:', error);
      }
      
      // Cargar categorías disponibles
      try {
        const result = await axios.get('/api/olap/query', {
          params: {
            dimension: 'producto',
            metric: 'monto_total',
            group: 'categoria'
          }
        });
        categories.value = [...new Set(result.data.map(item => item.categoria))];
      } catch (error) {
        console.error('Error loading categories:', error);
      }
    });
    
    return {
      query,
      categories,
      executeQuery
    };
  }
};
</script>

<style lang="scss" scoped>
.olap-controls {
  border-radius: 0.75rem;
  border: none;
  
  .card-header {
    border-radius: 0.75rem 0.75rem 0 0 !important;
    font-size: 1.1rem;
  }
  
  .form-select, .form-control {
    border: 1px solid #dee2e6;
    transition: all 0.3s;
    
    &:focus {
      border-color: var(--bs-primary);
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
  }
  
  label {
    font-size: 0.9rem;
    color: #495057;
  }
}
</style>