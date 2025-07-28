<template>
    <div class="olap-controls card">
      <div class="card-header">
        Consulta OLAP
      </div>
      <div class="card-body">
        <form @submit.prevent="executeQuery">
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label">Dimensión</label>
              <select v-model="query.dimension" class="form-select">
                <option value="producto">Producto</option>
                <option value="tiempo">Tiempo</option>
                <option value="sucursal">Sucursal</option>
                <option value="cliente">Cliente</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Métrica</label>
              <select v-model="query.metric" class="form-select">
                <option value="monto_total">Ventas Totales</option>
                <option value="cantidad_vendida">Unidades Vendidas</option>
                <option value="margen_ganancia">Margen de Ganancia</option>
              </select>
            </div>
            
            <div class="col-md-6" v-if="query.dimension === 'tiempo'">
              <label class="form-label">Nivel Jerárquico</label>
              <select v-model="query.timeLevel" class="form-select">
                <option value="dia">Día</option>
                <option value="mes">Mes</option>
                <option value="trimestre">Trimestre</option>
                <option value="anio">Año</option>
              </select>
            </div>
            
            <div class="col-md-6" v-if="query.dimension === 'producto'">
              <label class="form-label">Categoría</label>
              <select v-model="query.category" class="form-select">
                <option value="">Todas</option>
                <option value="Granos">Granos</option>
                <option value="Lácteos">Lácteos</option>
                <option value="Bebidas">Bebidas</option>
              </select>
            </div>
            
            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-primary w-100">
                Ejecutar Consulta
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        query: {
          dimension: 'producto',
          metric: 'monto_total',
          timeLevel: 'mes',
          category: ''
        }
      }
    },
    methods: {
      executeQuery() {
        this.$emit('query', this.query)
      }
    }
  }
  </script>
  
  <style lang="scss" scoped>
  @use '../scss/variables' as *;
  
  .form-select {
    border-color: $primary;
  }
  </style>
  