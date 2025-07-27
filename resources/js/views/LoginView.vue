<template>
    <div class="flex align-items-center justify-content-center min-h-screen">
      <Card class="w-full md:w-6 lg:w-4">
        <template #title>Iniciar Sesión</template>
        <template #content>
          <form @submit.prevent="handleSubmit">
            <div class="field">
              <label for="email">Email</label>
              <InputText id="email" v-model="form.email" class="w-full" />
            </div>
            
            <div class="field mt-3">
              <label for="password">Contraseña</label>
              <Password id="password" v-model="form.password" class="w-full" toggleMask />
            </div>
            
            <Button 
              type="submit" 
              label="Ingresar" 
              icon="pi pi-lock" 
              class="w-full mt-3" 
              :loading="loading"
            />
          </form>
        </template>
      </Card>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useAuthStore } from '../stores/auth'
  import { useToast } from 'primevue/usetoast'
  
  const authStore = useAuthStore()
  const toast = useToast()
  const loading = ref(false)
  const form = ref({
    email: '',
    password: ''
  })
  
  const handleSubmit = async () => {
    loading.value = true
    try {
      await authStore.login(form.value)
      toast.add({
        severity: 'success',
        summary: 'Éxito',
        detail: 'Sesión iniciada correctamente',
        life: 3000
      })
    } catch (error) {
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.message || 'Credenciales incorrectas',
        life: 3000
      })
    } finally {
      loading.value = false
    }
  }
  </script>