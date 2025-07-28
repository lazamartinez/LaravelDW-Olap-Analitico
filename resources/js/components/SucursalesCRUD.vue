<!-- resources/js/components/SucursalesCRUD.vue -->
<template>
    <div class="sucursales-container">
      <h2>Administración de Sucursales</h2>
      
      <!-- Formulario para agregar/editar -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">{{ editing ? 'Editar Sucursal' : 'Nueva Sucursal' }}</h5>
          <form @submit.prevent="submitForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Código</label>
                <input v-model="form.codigo" type="text" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input v-model="form.nombre" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Provincia</label>
                <input v-model="form.provincia" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Cantón</label>
                <input v-model="form.canton" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Distrito</label>
                <input v-model="form.distrito" type="text" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Dirección Exacta</label>
                <textarea v-model="form.direccion_exacta" class="form-control"></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <input v-model="form.telefono" type="text" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label">Horario</label>
                <input v-model="form.horario" type="text" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label">Fecha Apertura</label>
                <input v-model="form.fecha_apertura" type="date" class="form-control" required>
              </div>
              <div class="col-md-2">
                <div class="form-check form-switch">
                  <input v-model="form.activa" class="form-check-input" type="checkbox">
                  <label class="form-check-label">Activa</label>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">
                  {{ editing ? 'Actualizar' : 'Guardar' }}
                </button>
                <button v-if="editing" @click="cancelEdit" class="btn btn-secondary ms-2">
                  Cancelar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Tabla de sucursales -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Listado de Sucursales</h5>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Ubicación</th>
                  <th>Teléfono</th>
                  <th>Fecha Apertura</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="sucursal in sucursales" :key="sucursal.sucursal_id">
                  <td>{{ sucursal.codigo }}</td>
                  <td>{{ sucursal.nombre }}</td>
                  <td>{{ sucursal.provincia }}, {{ sucursal.canton }}</td>
                  <td>{{ sucursal.telefono || '-' }}</td>
                  <td>{{ formatDate(sucursal.fecha_apertura) }}</td>
                  <td>
                    <span :class="['badge', sucursal.activa ? 'bg-success' : 'bg-secondary']">
                      {{ sucursal.activa ? 'Activa' : 'Inactiva' }}
                    </span>
                  </td>
                  <td>
                    <button @click="editSucursal(sucursal)" class="btn btn-sm btn-warning me-2">
                      Editar
                    </button>
                    <button @click="deleteSucursal(sucursal.sucursal_id)" class="btn btn-sm btn-danger">
                      Eliminar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        sucursales: [],
        form: {
          sucursal_id: null,
          codigo: '',
          nombre: '',
          provincia: '',
          canton: '',
          distrito: '',
          direccion_exacta: '',
          telefono: '',
          horario: '',
          fecha_apertura: new Date().toISOString().split('T')[0],
          activa: true
        },
        editing: false
      };
    },
    created() {
      this.fetchSucursales();
    },
    methods: {
      async fetchSucursales() {
        try {
          const response = await axios.get('/api/sucursales');
          this.sucursales = response.data;
        } catch (error) {
          console.error('Error fetching sucursales:', error);
        }
      },
      async submitForm() {
        try {
          if (this.editing) {
            await axios.put(`/api/sucursales/${this.form.sucursal_id}`, this.form);
          } else {
            await axios.post('/api/sucursales', this.form);
          }
          this.resetForm();
          this.fetchSucursales();
        } catch (error) {
          console.error('Error saving sucursal:', error);
        }
      },
      editSucursal(sucursal) {
        this.form = { ...sucursal };
        this.editing = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
      },
      cancelEdit() {
        this.resetForm();
      },
      async deleteSucursal(id) {
        if (confirm('¿Está seguro de eliminar esta sucursal?')) {
          try {
            await axios.delete(`/api/sucursales/${id}`);
            this.fetchSucursales();
          } catch (error) {
            console.error('Error deleting sucursal:', error);
          }
        }
      },
      resetForm() {
        this.form = {
          sucursal_id: null,
          codigo: '',
          nombre: '',
          provincia: '',
          canton: '',
          distrito: '',
          direccion_exacta: '',
          telefono: '',
          horario: '',
          fecha_apertura: new Date().toISOString().split('T')[0],
          activa: true
        };
        this.editing = false;
      },
      formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
      }
    }
  };
  </script>
  
  <style lang="scss" scoped>
  @use '../scss/variables' as *;
  
  .table-responsive {
    background: $white;
  }
  </style>
  