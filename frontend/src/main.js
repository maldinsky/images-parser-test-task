import Vue from 'vue'
import Router from 'vue-router'
import App from './App.vue'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name:'main',
    },
  ]
})

new Vue({
  el: '#app',
  render: h => h(App),
  router
})
