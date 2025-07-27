<template>
    <Menubar :model="items">
      <template #start>
        <span class="font-bold text-xl">OLAP Dashboard</span>
      </template>
      <template #end>
        <div class="flex align-items-center gap-3">
          <Avatar 
            v-if="authStore.user"
            :label="authStore.user.name.charAt(0)" 
            class="mr-2" 
            size="large" 
            shape="circle" 
          />
          <Button 
            v-if="authStore.isAuthenticated"
            icon="pi pi-sign-out" 
            label="Cerrar Sesión" 
            class="p-button-text" 
            @click="authStore.logout"
          />
          <Button 
            v-else
            icon="pi pi-sign-in" 
            label="Iniciar Sesión" 
            class="p-button-text" 
            @click="$router.push('/login')"
          />
        </div>
      </template>
    </Menubar>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useAuthStore } from '../../stores/auth'
  import { useRouter } from 'vue-router'
  
  const authStore = useAuthStore()
  const router = useRouter()
  
  const items = ref([
    {
      label: 'Dashboard',
      icon: 'pi pi-home',
      command: () => router.push('/')
    },
    {
      label: 'Análisis',
      icon: 'pi pi-chart-bar',
      items: [
        {
          label: 'Ventas',
          command: () => router.push('/sales')
        },
        {
          label: 'Productos',
          command: () => router.push('/products')
        }
      ]
    }
  ])
  </script>
  
  <style scoped>
  .p-menubar {
    border-radius: 0;
    border-left: none;
    border-right: none;
    border-top: none;
    padding: 0.5rem 2rem;
  }
  </style>