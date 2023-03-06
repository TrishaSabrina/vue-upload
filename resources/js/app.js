require('./bootstrap');

import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'
import router from './router'


// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

Vue.component('pagination', require('laravel-vue-pagination'));


//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)




//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast


// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1`
Vue.use(VueAuth, auth)

// Load Index
Vue.component('index', Index)
const app = new Vue({
  el: '#app',
  router
})