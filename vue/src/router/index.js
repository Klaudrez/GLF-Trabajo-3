import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import AFD from '../views/AFD.vue'
import AP from '../views/AP.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/afd',
    name: 'AFD',
    component: AFD
  },
  {
    path: '/ap',
    name: 'AP',
    component: AP
  }
]

const router = new VueRouter({
  routes
})

export default router
