import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categorie: [],
        status: false,
        urlcategorie: '/Categoria',
    },
    mutations: {
        LISTCATEGORIE(state, item) {
            state.categorie = item;
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
    },
});