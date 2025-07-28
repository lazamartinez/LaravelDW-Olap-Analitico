<template>
  <div class="sucursal-list">
    <div class="d-flex justify-content-between mb-4">
      <h2>Sucursales</h2>
      <button @click="showForm" class="btn btn-primary">
        <i class="bi bi-plus"></i> Nueva Sucursal
      </button>
    </div>

    <div v-if="loading" class="text-center my-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
      </div>
    </div>

    <div v-else>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Ubicación</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="sucursal in sucursales" :key="sucursal.sucursal_id">
              <td>{{ sucursal.codigo }}</td>
              <td>{{ sucursal.nombre }}</td>
              <td>{{ sucursal.provincia }}, {{ sucursal.canton }}</td>
              <td>
                <span :class="['badge', sucursal.activa ? 'bg-success' : 'bg-secondary']">
                  {{ sucursal.activa ? 'Activa' : 'Inactiva' }}
                </span>
              </td>
              <td>
                <button @click="editSucursal(sucursal)" class="btn btn-sm btn-warning me-2">
                  <i class="bi bi-pencil"></i>
                </button>
                <button @click="confirmDelete(sucursal.sucursal_id)" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <SucursalForm 
      v-if="showModal"
      :sucursal="selectedSucursal"
      @close="closeModal"
      @saved="refreshData"
    />
  </div>
</template>

<script>
import axios from 'axios'
import SucursalForm from './SucursalForm.vue'

export default {
  components: { SucursalForm },
  data() {
    return {
      sucursales: [],
      loading: true,
      showModal: false,
      selectedSucursal: null
    }
  },
  created() {
    this.fetchSucursales()
  },
  methods: {
    async fetchSucursales() {
      try {
        const response = await axios.get('/api/sucursales')
        this.sucursales = response.data
      } catch (error) {
        console.error('Error fetching sucursales:', error)
      } finally {
        this.loading = false
      }
    },
    showForm() {
      this.selectedSucursal = null
      this.showModal = true
    },
    editSucursal(sucursal) {
      this.selectedSucursal = { ...sucursal }
      this.showModal = true
    },
    async confirmDelete(id) {
      if (confirm('¿Está seguro de eliminar esta sucursal?')) {
        try {
          await axios.delete(`/api/sucursales/${id}`)
          this.refreshData()
        } catch (error) {
          console.error('Error deleting sucursal:', error)
        }
      }
    },
    closeModal() {
      this.showModal = false
    },
    refreshData() {
      this.closeModal()
      this.loading = true
      this.fetchSucursales()
    }
  }
}
</script>

<style lang="scss" scoped>
@use '@/scss/variables' as *;
@use '@/scss/mixins' as *;

.sucursal-list {
  padding: map-get($spacing, md);
}
</style>