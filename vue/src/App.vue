<template>
<v-app>
  <div id="app">
      <Navbar />
      <v-card
    outlined
    style="margin: 1%; padding: 1%;"
  >
   <router-view/>
      </v-card>
  </div>
</v-app>
</template>

<script>
import Navbar from "@/components/Navbar.vue";

export default {
  components: {
    Navbar,
  },
}
</script>

<style lang="scss">
.v-btn {
  margin: 2px;
}
.col {
  padding: 0 !important;
}
.v-text-field.v-text-field--enclosed .v-text-field__details {
  margin: 0 !important;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
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
