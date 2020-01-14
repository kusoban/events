import Vuex from 'vuex';
import Vue from 'vue';

import axios from 'axios';
const api = axios.create({
    headers: {
        'Access-Control-Allow-Origin': '*',
    },
    baseURL: 'http://events.api/api',
})
api.interceptors.response.use(function (response) {
    return response.data;
})

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: {
            id: null,
            email: '',
            accessToken: '',
        },
        globalSearchText: '',
    },
    mutations: {
        logout (state) {
            state.user = {}
        },
        setUser (state, user) {
            state.user = user;
        },
        setSearchText(state, payload) {
            state.globalSearchText = payload.searchText;
        }
    },

    actions: {
        login ({ commit }, payload) {
            return api.post('/login', payload)
                .then(data => {
                    console.log(data)
                    commit('setUser', { email: data.user.email, id: data.user.id, accessToken: data.token_data.access_token });
                }).catch(err => {
                    console.log(err.response);
                })
        },
        register ({ commit }, payload) {
            return api.post("/register", payload)
                .then((data) => {
                    console.log(data);
                    commit('setUser', { email: data.user.email, id: data.user.id, accessToken: data.token_data.access_token })
                })
                .catch(err => {
                    console.error(err.response.data.errors);
                });
        },
    },
    getters: {
        userIsLoggedIn(state) {
            return !!state.user.id;
        },
        user(state) {
            return state.user;
        },
        test () {
            return 'kek'
        },
        globalSearchText(state) {
            return state.globalSearchText
        }
    }
})

export default store; 