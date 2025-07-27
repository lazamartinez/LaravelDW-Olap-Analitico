<template>
    <div class="layout-wrapper">
      <Navbar />
      <Sidebar />
      
      <div class="layout-main-container">
        <div class="layout-main">
          <Toast />
          <router-view v-slot="{ Component }">
            <transition name="fade" mode="out-in">
              <component :is="Component" />
            </transition>
          </router-view>
        </div>
        <Footer />
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from './Navbar.vue'
  import Sidebar from './Sidebar.vue'
  import Footer from './Footer.vue'
  import Toast from 'primevue/toast'
  
  export default {
    components: { Navbar, Sidebar, Footer, Toast }
  }
  </script>
  
  <style lang="scss" scoped>
  .layout-wrapper {
    min-height: 100vh;
    
    .layout-main-container {
      margin-left: 250px;
      padding: 2rem;
      transition: margin-left 0.3s;
    }
  }
  
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>