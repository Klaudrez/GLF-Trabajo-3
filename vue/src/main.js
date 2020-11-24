import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from './router';
import VueCytoscape from 'vue-cytoscape';
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

Vue.use(Buefy);
Vue.use(VueCytoscape);
Vue.config.productionTip = false;

new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app')
