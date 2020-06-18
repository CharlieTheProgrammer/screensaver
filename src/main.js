import Vue from "vue";
import App from "./App.vue";

import './sass/app.scss'

require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false;

// Helper to find all vue files and register them to the main app automatically
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

new Vue({
  render: h => h(App)
}).$mount("#app");
