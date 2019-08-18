import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categorie: [],
        product: [],
        status: false,
        urlcategorie: '/Categoria',
        urlproduct: 'Producto',
    },
    mutations: {
        LISTCATEGORIE(state, item) {
            state.categorie = item;
        },
        LISTPRODUCT(state, item) {
            state.product = item;
        },
    },
    actions: {
        Listarcategorie({ commit, state }) {
            axios
                .get(state.urlcategorie)
                .then(res => {
                    commit('LISTCATEGORIE', res.data);
                    state.status = true;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        Listarproducto({ commit, state }) {
            axios
                .get(state.urlproduct)
                .then(res => {
                    commit('LISTPRODUCT', res.data);
                    state.status = true;
                })
                .catch(err => {
                    console.log(err);
                });
        },
    },
});