<template>
  <div class="modal fade show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ sucursal ? 'Editar Sucursal' : 'Nueva Sucursal' }}
          </h5>
          <button type="button" class="btn-close" @click="close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Código *</label>
                <input v-model="formData.codigo" type="text" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nombre *</label>
                <input v-model="formData.nombre" type="text" class="form-control" required>
              </div>

              <div class="col-md-4">
                <label class="form-label">Provincia *</label>
                <input v-model="formData.provincia" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Cantón *</label>
                <input v-model="formData.canton" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Distrito *</label>
                <input v-model="formData.distrito" type="text" class="form-control" required>
              </div>

              <div class="col-12">
                <label class="form-label">Dirección Exacta</label>
                <textarea v-model="formData.direccion_exacta" class="form-control"></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input v-model="formData.telefono" type="text" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Horario</label>
                <input v-model="formData.horario" type="text" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label">Fecha Apertura *</label>
                <input v-model="formData.fecha_apertura" type="date" class="form-control" required>
              </div>

              <div class="col-md-6">
                <div class="form-check form-switch mt-4 pt-2">
                  <input v-model="formData.activa" class="form-check-input" type="checkbox">
                  <label class="form-check-label">Sucursal Activa</label>
                </div>
              </div>
            </div>

            <div class="modal-footer mt-4">
              <button type="button" class="btn btn-secondary" @click="close">
                Cancelar
              </button>
              <button type="submit" class="btn btn-primary">
                {{ sucursal ? 'Actualizar' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    sucursal: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      formData: {
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
      }
    }
  },
  created() {
    if (this.sucursal) {
      this.formData = { ...this.sucursal }
    }
  },
  methods: {
    close() {
      this.$emit('close')
    },
    async submitForm() {
      try {
        if (this.sucursal) {
          await axios.put(`/api/sucursales/${this.sucursal.sucursal_id}`, this.formData)
        } else {
          await axios.post('/api/sucursales', this.formData)
        }
        this.$emit('saved')
      } catch (error) {
        console.error('Error saving sucursal:', error)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@use '../../../scss/variables' as vars;
@use '../../../scss/components/forms' as forms;

.modal-content {
  padding: map-get(vars.$spacing, lg); // Ajusta según tus variables

  .form-label {
    // Usamos map-get para obtener el color del mapa de variables
    color: map-get(vars.$colors, text-primary);
  }
}
</style>