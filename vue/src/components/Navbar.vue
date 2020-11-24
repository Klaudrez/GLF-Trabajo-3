<template>
  <div>
      <b-navbar fixed-top>
        <!-- <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                <img
                    src="https://raw.githubusercontent.com/buefy/buefy/dev/static/img/buefy-logo.png"
                    alt="Lightweight UI components for Vue.js based on Bulma"
                >
            </b-navbar-item>
        </template> -->
        <template slot="start">
            <b-navbar-item>
                <router-link to="/">Inicio</router-link>
            </b-navbar-item>
            <b-navbar-item>
                <router-link to="/afd">AFD</router-link>
            </b-navbar-item>
            <b-navbar-item>
                <router-link to="/ap">AP</router-link>
            </b-navbar-item>
        </template>
    </b-navbar>
  </div>
</template>
<script>
export default {
  name: "Navbar",
  components: {},
};
</script>
<style>
.navbar-end {
    padding: 0 5% 0 0;
}
.navbar-start {
    padding: 0 0 0 5%;
}
</style>