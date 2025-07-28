<template>
    <div class="container mt-4">
      <SalesDashboard />
    </div>
  </template>
  
  <script>
  import SalesDashboard from '@/js/components/dashboard/SalesDashboard.vue';
  
  export default {
    components: { SalesDashboard }
  }
  </script>

<style lang="scss">
@use '../../scss/variables' as *;

.container {
  background: map-get($colors, background);
}
</style>

  