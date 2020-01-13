import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import vuetify from './plugins/vuetify';
import './plugins/dateTime';

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import axios from 'axios';
const axiosApi = axios.create({
  headers: {
    'Access-Control-Allow-Origin': '*',
  },
  baseURL: 'http://events.api/api',
})
Vue.prototype.$api = axiosApi;

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
