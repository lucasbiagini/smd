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
Vue.component('index-unauthorized', () => import('./components/index/unauthorized.vue'))
Vue.component('processos', () => import('./components/processos/index.vue'))
Vue.component('create-processo', () => import('./components/processos/create.vue'))
Vue.component('edit-processo', () => import('./components/processos/edit.vue'))
Vue.component('processo', () => import('./components/processos/show.vue'))
Vue.component('agentes', () => import('./components/agentes/agentes.vue'))
Vue.component('agente', () => import('./components/agentes/agente.vue'))
Vue.component('fluxo', () => import('./components/processos/fluxo.vue'))
Vue.component('escopo', () => import('./components/processos/escopo.vue'))
Vue.component('finalidade', () => import('./components/processos/finalidade.vue'))
Vue.component('frequencia', () => import('./components/processos/frequencia.vue'))
Vue.component('dados', () => import('./components/dados/dados.vue'))
Vue.component('create-dado', () => import('./components/dados/create.vue'))
Vue.component('dado', () => import('./components/dados/dado.vue'))
Vue.component('titulares', () => import('./components/titulares/titulares.vue'))
Vue.component('create-titular', () => import('./components/titulares/create.vue'))
Vue.component('titular', () => import('./components/titulares/titular.vue'))
/**
 * Sweetalert2
 */
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

/**
 * Global Mixins
 */
import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

new Vue({
    el: '#app'
})
