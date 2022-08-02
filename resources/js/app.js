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
Vue.component('edit-user', () => import('./components/users/edit.vue'))
Vue.component('setor-role', () => import ('./components/users/setor-role.vue'))
Vue.component('select-setor', () => import('./components/setores/select.vue'))
Vue.component('setores', () => import('./components/setores/index.vue'))
Vue.component('create-setor', () => import('./components/setores/create.vue'))
Vue.component('edit-setor', () => import('./components/setores/edit.vue'))
Vue.component('roles', () => import('./components/roles/index.vue'))
Vue.component('create-role', () => import('./components/roles/create.vue'))
Vue.component('role-permissions', () => import('./components/roles/permissions.vue'))
Vue.component('edit-role', () => import('./components/roles/edit.vue'))

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
