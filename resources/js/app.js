import '../scss/app.scss' // Ruta relativa corregida
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

createApp(App).use(router).mount('#app')