import './bootstrap';

import Vue from 'vue'

/**
 * Bootstrap-vue
 */
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.component('users', () => import('./components/users/index.vue'))
Vue.component('setores', () => import('./components/setores/index.vue'))
Vue.component('setores-create', () => import('./components/setores/create.vue'))
Vue.component('roles', () => import('./components/roles/index.vue'))
Vue.component('roles-create', () => import('./components/roles/create.vue'))

/**
 * Sweetalert2
 */
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// /**
//  * Vue Multiselect
//  */
// import Multiselect from "vue-multiselect";
// Vue.use(Multiselect)


new Vue({
    el: '#app'
})
