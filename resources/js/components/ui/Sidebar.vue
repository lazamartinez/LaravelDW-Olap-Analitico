<template>
    <div class="sidebar">
      <PanelMenu :model="items" class="w-full md:w-15rem">
        <template #item="{ item }">
          <router-link 
            v-if="item.route"
            :to="item.route" 
            class="p-menuitem-link"
            :class="{ 'active-route': $route.path === item.route }"
          >
            <span :class="item.icon" class="p-menuitem-icon"></span>
            <span class="p-menuitem-text">{{ item.label }}</span>
          </router-link>
          <a v-else :href="item.url" class="p-menuitem-link">
            <span :class="item.icon" class="p-menuitem-icon"></span>
            <span class="p-menuitem-text">{{ item.label }}</span>
          </a>
        </template>
      </PanelMenu>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  
  const route = useRoute()
  
  const items = ref([
    {
      label: 'Dashboard',
      icon: 'pi pi-home',
      route: '/'
    },
    {
      label: 'Análisis de Ventas',
      icon: 'pi pi-chart-bar',
      route: '/sales'
    },
    {
      label: 'Productos',
      icon: 'pi pi-box',
      route: '/products'
    },
    {
      separator: true
    },
    {
      label: 'Configuración',
      icon: 'pi pi-cog',
      items: [
        {
          label: 'Perfil',
          icon: 'pi pi-user',
          route: '/profile'
        }
      ]
    }
  ])
  </script>
  
  <style scoped>
  .sidebar {
    height: 100vh;
    background: var(--surface-card);
    border-right: 1px solid var(--surface-border);
  }
  
  .active-route {
    background-color: var(--primary-color) !important;
    color: white !important;
  }
  
  .active-route .p-menuitem-icon {
    color: white !important;
  }
  
  .p-menuitem-link {
    border-radius: 6px;
    margin: 2px 8px;
    padding: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.2s;
  }
  
  .p-menuitem-link:hover {
    background-color: var(--surface-hover);
  }
  </style>