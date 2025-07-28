import { createRouter, createWebHistory } from 'vue-router'
import SucursalesView from './views/SucursalesView.vue'
import AnalyticsView from './views/AnalyticsView.vue'

const routes = [
  {
    path: '/sucursales',
    name: 'sucursales',
    component: SucursalesView
  },
  {
    path: '/analytics',
    name: 'analytics',
    component: AnalyticsView
  },
  {
    path: '/',
    redirect: '/analytics'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
