<template>
  <div id="app">
    <topnavbar />
    <router-view></router-view>
  </div>
</template>

<script type="text/javascript">
import topnavbar from "./views/TopNavbar.vue";

export default {
  components: {
    topnavbar, // register component
  },
  created: function () {
    document.body.style.backgroundColor = "#98bae7";
  },
  destroyed: function () {
    document.body.style.backgroundColor = null;
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin-top: 100px;
}
</style>
