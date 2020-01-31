import Vuex from 'vuex';
import Vue from 'vue';

import router from '../router/'
import api from '../axios/api';

Vue.use(Vuex);
// console.log(localStorage.getItem('access-token'))
const store = new Vuex.Store({
    state: {
        guardChecked: false,
        user: {
            id: null,
            email: null,
            accessToken: localStorage.getItem('access-token'),
        },
        globalSearchText: '',
    },
    mutations: {
        setGuardChecked (state, payload) {
            state.guardChecked = payload;
        },

        logout (state) {
            localStorage.clear('access-token')
            state.guardChecked = false;
            state.user = {
                id: null,
                email: null,
                accessToken: null,
            }
        },
        setUser (state, user) {
            state.user = user;
        },
        setSearchText (state, payload) {
            state.globalSearchText = payload.searchText;
        },

        test (state) {
            state.user.id = null,
                state.user.accessToken = null,
                state.user.email = null
        }
    },

    actions: {
        login ({ commit }, payload) {
            return new Promise((res, rej) => {
                api.post('/login', payload)
                    .then(({ user: { id, email }, token_data: { access_token} }) => {
                        commit('setUser', { id, email, accessToken: access_token })
                        setAccessToken(access_token)
                        return res()
                    }).catch(err => {
                        console.log(err.response);
                        return rej(err.response);
                    })
            })
        },
        register ({ commit }, { email, password, password_confirmation }) {
            return new Promise((res, rej) => {

                api.post("/register", { email, password, password_confirmation })
                
                    .then(( { user: { id, email }, token_data: {access_token}} ) => {
                        commit('setUser', { id, email, accessToken: access_token })
                        setAccessToken(data.token_data.access_token)
                        res()
                    })
                    .catch(err => {
                        return console.log(err)
                        rej(err.response)
                    });

            })
        },

        authorize ({ getters }) {
            return new Promise((resolve, reject) => {

                if (!getters.userIsLoggedIn) {
                    router.push('/register');
                    reject('not authorized')
                }

                resolve()

            });
        },

        getUserFromLocalStorage ({ commit }) {
            const accessToken = localStorage.getItem('access-token');

            if (accessToken) {
                api.get('/me',
                    { 
                        headers: {
                            Authorization: 'Bearer ' + accessToken,
                        } 
                    }
                ).then(({ data: { id, email } }) => {

                    commit('setUser', {
                        id,
                        email,
                        accessToken,
                    })

                })
            }
        },
    },

    getters: {

        userIsLoggedIn (state) {
            return !!state.user.id;
        },

        user (state) {
            return state.user;
        },

        test () {
            return 'kek'
        },

        globalSearchText (state) {
            return state.globalSearchText
        },

        accessToken(state) {
            return state.user.accessToken;
        }

    }
})

function setAccessToken (token) {
    localStorage.setItem('access-token', token);
}

export default store; 