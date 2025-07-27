<template>
    <MainLayout>
      <router-view />
    </MainLayout>
  </template>
  
  <script>
  import MainLayout from './components/ui/MainLayout.vue'
  
  export default {
    components: { MainLayout }
  }
  </script>