<template>
  <div id="wp-vue-app">
    <app-navigation></app-navigation>
    <router-view/>
  </div>
</template>

<script>
import AppNavigation from './components/AppNavigation'

export default {
  components: {
    AppNavigation
  }
}
</script>

<style lang="scss">
@import "./../node_modules/animate.css/animate";

#wp-vue-app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
