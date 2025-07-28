<template>
  <div class="app-container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
      <div class="container">
        <router-link class="navbar-brand" to="/">OLAP Dashboard</router-link>
        <div class="navbar-nav">
          <router-link class="nav-link" to="/sucursales">Sucursales</router-link>
          <router-link class="nav-link" to="/analytics">Analítica</router-link>
        </div>
      </div>
    </nav>
    
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style lang="scss">
/* Las reglas @use deben ir primero */
@use '../scss/variables' as *;

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  color: map-get($colors, text-primary);
}
</style>

