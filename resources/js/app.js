require('./bootstrap');
window.Vue = require('vue');
window.Axios = require('axios');
window.Swal = require('sweetalert2');
import store from './store';

Vue.component('pos-header', require('./components/pos-header.vue').default);
Vue.component('pos', require('./components/pos.vue').default);
Vue.component(
    'categorie',
    require('./components/categorie/categorie.vue').default
);
const app = new Vue({
    el: '#app',
    store,
});