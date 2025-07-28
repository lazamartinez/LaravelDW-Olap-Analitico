<template>
  <div class="main-layout">
    <Navbar />
    <div class="layout-container">
      <Sidebar />
      <main class="content">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'

export default {
  components: {
    Navbar,
    Sidebar
  }
}
</script>

<style scoped>
.main-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.layout-container {
  display: flex;
  flex: 1;
}
.content {
  flex: 1;
  padding: 20px;
}
</style>