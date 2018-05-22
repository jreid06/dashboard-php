import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'


import {
  routes
} from './routes'

Vue.use(VueRouter)
Vue.use(Vuetify)
// Vue.use(Toastr)

const router = new VueRouter({
  routes: routes
})


new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
})