<template>
  <div class="olap-operations">
    <!-- Mobile Controls (solo visible en móviles) -->
    <div class="d-lg-none mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Controles OLAP</h6>
          <button class="btn btn-sm btn-link" @click="showMobileControls = !showMobileControls">
            <i class="fas" :class="showMobileControls ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
          </button>
        </div>
        <div class="card-body" v-show="showMobileControls">
          <div class="d-grid gap-2">
            <button 
              v-for="op in operations" 
              :key="op.value"
              @click="executeOperation(op.value)"
              class="btn btn-outline-primary btn-sm text-start"
            >
              <i :class="op.icon" class="me-2"></i>{{ op.label }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop Controls (solo visible en desktop) -->
    <div class="d-none d-lg-block">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
          <h5 class="mb-0"><i class="fas fa-cubes me-2"></i>Operaciones OLAP</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <button 
              v-for="op in operations" 
              :key="op.value"
              @click="executeOperation(op.value)"
              class="btn btn-outline-primary text-start"
            >
              <i :class="op.icon" class="me-2"></i>{{ op.label }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para parámetros de operación -->
    <div class="modal fade" id="operationModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ operationTitle }}</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Formulario para SLICE -->
            <div v-if="currentOperation === 'slice'" class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Dimensión</label>
                <select v-model="sliceParams.dimension" class="form-select">
                  <option value="time">Tiempo</option>
                  <option value="product">Producto</option>
                  <option value="store">Sucursal</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Valor</label>
                <input v-model="sliceParams.value" type="text" class="form-control">
              </div>
            </div>

            <!-- Formulario para DICE -->
            <div v-if="currentOperation === 'dice'">
              <div class="mb-3">
                <label class="form-label">Filtros</label>
                <div v-for="(filter, index) in diceParams.filters" :key="index" class="row g-2 mb-2">
                  <div class="col-md-5">
                    <select v-model="filter.dimension" class="form-select">
                      <option value="time">Tiempo</option>
                      <option value="product">Producto</option>
                      <option value="store">Sucursal</option>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <input v-model="filter.value" type="text" class="form-control" placeholder="Valor">
                  </div>
                  <div class="col-md-2">
                    <button @click="removeDiceFilter(index)" class="btn btn-sm btn-danger w-100">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <button @click="addDiceFilter" class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-plus me-1"></i>Agregar Filtro
                </button>
              </div>
            </div>

            <!-- Formulario para ROLL-UP -->
            <div v-if="currentOperation === 'rollup'" class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Dimensión</label>
                <select v-model="rollupParams.dimension" class="form-select">
                  <option value="time">Tiempo</option>
                  <option value="product">Producto</option>
                  <option value="store">Sucursal</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Métrica</label>
                <select v-model="rollupParams.metric" class="form-select">
                  <option value="monto_total">Ventas Totales</option>
                  <option value="cantidad_vendida">Unidades Vendidas</option>
                  <option value="margen_ganancia">Margen de Ganancia</option>
                </select>
              </div>
            </div>

            <!-- Formulario para DRILL-DOWN -->
            <div v-if="currentOperation === 'drilldown'">
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Dimensión</label>
                  <select v-model="drilldownParams.dimension" class="form-select" @change="clearDrilldownParams">
                    <option value="time">Tiempo</option>
                    <option value="product">Producto</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Métrica</label>
                  <select v-model="drilldownParams.metric" class="form-select">
                    <option value="monto_total">Ventas Totales</option>
                    <option value="cantidad_vendida">Unidades Vendidas</option>
                    <option value="margen_ganancia">Margen de Ganancia</option>
                  </select>
                </div>
              </div>
              
              <div class="row g-3" v-if="drilldownParams.dimension === 'time'">
                <div class="col-12">
                  <label class="form-label">Año</label>
                  <select v-model="drilldownParams.year" class="form-select">
                    <option v-for="year in availableYears" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
              
              <div class="row g-3" v-if="drilldownParams.dimension === 'product'">
                <div class="col-12">
                  <label class="form-label">Categoría</label>
                  <select v-model="drilldownParams.category" class="form-select">
                    <option v-for="category in availableCategories" :value="category">{{ category }}</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Formulario para PIVOT -->
            <div v-if="currentOperation === 'pivot'" class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Filas</label>
                <select v-model="pivotParams.rows" class="form-select">
                  <option value="time_year">Año (Tiempo)</option>
                  <option value="product_category">Categoría (Producto)</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Columnas</label>
                <select v-model="pivotParams.columns" class="form-select">
                  <option value="time_quarter">Trimestre (Tiempo)</option>
                  <option value="store_region">Región (Sucursal)</option>
                </select>
              </div>
              <div class="col-md-12">
                <label class="form-label">Métrica</label>
                <select v-model="pivotParams.metric" class="form-select">
                  <option value="monto_total">Ventas Totales</option>
                  <option value="cantidad_vendida">Unidades Vendidas</option>
                  <option value="margen_ganancia">Margen de Ganancia</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
            <button @click="confirmOperation" type="button" class="btn btn-primary">
              <span v-if="loading" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
              Ejecutar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from 'mdb-ui-kit';

export default {
  name: 'OlapOperations',
  data() {
    return {
      showMobileControls: false,
      loading: false,
      currentOperation: '',
      operationTitle: '',
      modal: null,
      operations: [
        { value: 'slice', label: 'Slice', icon: 'fas fa-cut' },
        { value: 'dice', label: 'Dice', icon: 'fas fa-dice' },
        { value: 'rollup', label: 'Roll-Up', icon: 'fas fa-angle-double-up' },
        { value: 'drilldown', label: 'Drill-Down', icon: 'fas fa-angle-double-down' },
        { value: 'pivot', label: 'Pivot', icon: 'fas fa-exchange-alt' }
      ],
      sliceParams: {
        dimension: 'time',
        value: ''
      },
      diceParams: {
        filters: [{ dimension: 'time', value: '' }]
      },
      rollupParams: {
        dimension: 'time',
        metric: 'monto_total'
      },
      drilldownParams: {
        dimension: 'time',
        year: new Date().getFullYear(),
        category: '',
        metric: 'monto_total'
      },
      pivotParams: {
        rows: 'time_year',
        columns: 'time_quarter',
        metric: 'monto_total'
      },
      availableYears: Array.from({length: 5}, (_, i) => new Date().getFullYear() - i),
      availableCategories: ['Alimentos', 'Bebidas', 'Limpieza', 'Electrónica', 'Otros']
    };
  },
  mounted() {
    this.modal = new Modal(document.getElementById('operationModal'));
  },
  methods: {
    executeOperation(operation) {
      this.currentOperation = operation;
      this.operationTitle = `Operación ${operation.toUpperCase()}`;
      this.modal.show();
    },
    addDiceFilter() {
      this.diceParams.filters.push({ dimension: 'time', value: '' });
    },
    removeDiceFilter(index) {
      if (this.diceParams.filters.length > 1) {
        this.diceParams.filters.splice(index, 1);
      }
    },
    clearDrilldownParams() {
      this.drilldownParams.year = new Date().getFullYear();
      this.drilldownParams.category = '';
    },
    async confirmOperation() {
      this.loading = true;
      
      let endpoint = '';
      let params = {};
      
      switch (this.currentOperation) {
        case 'slice':
          endpoint = '/api/olap/slice';
          params = {
            dimension: this.sliceParams.dimension,
            value: this.sliceParams.value
          };
          break;
        case 'dice':
          endpoint = '/api/olap/dice';
          params = {
            filters: this.diceParams.filters
          };
          break;
        case 'rollup':
          endpoint = '/api/olap/roll-up';
          params = {
            dimension: this.rollupParams.dimension,
            metric: this.rollupParams.metric
          };
          break;
        case 'drilldown':
          endpoint = '/api/olap/drill-down';
          params = {
            dimension: this.drilldownParams.dimension,
            parent_value: this.drilldownParams.dimension === 'time' 
              ? { year: this.drilldownParams.year }
              : { category: this.drilldownParams.category },
            metric: this.drilldownParams.metric
          };
          break;
        case 'pivot':
          endpoint = '/api/olap/pivot';
          params = {
            rows: this.pivotParams.rows,
            columns: this.pivotParams.columns,
            metric: this.pivotParams.metric
          };
          break;
      }
      
      try {
        const response = await axios.post(endpoint, params);
        this.$emit('operation-result', response.data);
        this.modal.hide();
      } catch (error) {
        console.error('Error en operación OLAP:', error);
        this.$emit('operation-error', error.response?.data?.message || 'Error en la operación');
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.olap-operations .btn {
  text-align: left;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
}

@media (max-width: 992px) {
  .olap-operations .btn {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
  }
}
</style>