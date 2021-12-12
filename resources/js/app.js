/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import Vue from "vue";
require('./bootstrap');
import router from './router'
import "bootstrap/dist/css/bootstrap.css";
import vuetify from './plugins/vuetify'
import 'vuetify/dist/vuetify.min.css'
import i18n from './i18n'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from "./store/components/sidebar";

window.Vue = require('vue').default;

Vue.component('New', require('./components/App.vue').default);

Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.prototype.$log = console.log.bind(console)

const app = new Vue({
    store,
    i18n,
    router,
    icons,
    vuetify,
    el: '#app',
});
