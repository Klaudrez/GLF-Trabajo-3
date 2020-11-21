<template>
  <div class="home">
    <HelloWorld msg="Welcome to Your Vue.js App" />
    <v-btn color="accent" depressed outlined raised @click="this.botoncito"
      >¡Click! {{ this.contador }}</v-btn
    >
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "Home",
  components: {
    HelloWorld,
  },
  data() {
    return {
      contador: 0,
    };
  },
  methods: {
    botoncito() {
      this.contador += 1;
      console.log("Click", this.contador);
    },
  },
};
</script>
