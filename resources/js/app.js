require('./bootstrap');
window.Vue = require('vue');
window.Axios = require('axios');
import es from 'vee-validate/dist/locale/es';
import VeeValidate, { Validator } from 'vee-validate';
window.Swal = require('sweetalert2');
import store from './store';
Vue.use(VeeValidate);
Validator.localize('es', es);
import SmartTable from 'vuejs-smart-table';
Vue.use(SmartTable);

Vue.component('pos-header', require('./components/pos-header.vue').default);
Vue.component('pos', require('./components/pos.vue').default);
Vue.component(
    'categorie',
    require('./components/categorie/categorie.vue').default
);
Vue.component('product', require('./components/product/product.vue').default);

const app = new Vue({
    el: '#app',
    store,
});