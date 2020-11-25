<template>
  <div>
    <b-navbar fixed-top>
      <template slot="start">
        <router-link to="/">
          <b-navbar-item>
            <b-icon icon="information-variant"></b-icon>
            <span>Inicio</span>
          </b-navbar-item>
        </router-link>
        <router-link to="/afd">
          <b-navbar-item>
            <b-icon icon="graphql"></b-icon>
            <span>AFD</span>
          </b-navbar-item>
        </router-link>
        <router-link to="/ap">
          <b-navbar-item>
            <b-icon icon="stack-overflow"></b-icon>
            <span>AP</span>
          </b-navbar-item>
        </router-link>
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
.navbar {
  background-color: #02182b !important;
}
a.navbar-item {
  color: #ffffff !important;
  background-color: #02182b;
}
a.navbar-item:hover {
  color: #02182b !important;
}
.router-link-active .navbar-item {
  height: 100%;
}
a .navbar-item {
  height: 100%;
}
</style>