import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import vuetify from './plugins/vuetify';
import './plugins/dateTime';

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import axiosApi from './axios/api';

Vue.prototype.$api = axiosApi;

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
