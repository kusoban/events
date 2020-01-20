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
        setGuardChecked(state, payload) {
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
        setSearchText(state, payload) {
            state.globalSearchText = payload.searchText;
        },
        getUserFromLocalStorage(state) {
            
        },
        test(state) {
            state.user.id = null,
            state.user.accessToken = null,
            state.user.email = null
        }
    },

    actions: {
        login ({ commit }, payload) {
            return new Promise((res, rej) => {
                api.post('/login', payload)
                    .then(data => {
                        console.log(data)
                        commit('setUser', { email: data.user.email, id: data.user.id, accessToken: data.token_data.access_token })
                        setAccessToken(data.token_data.access_token)
                        return res()
                    }).catch(err => {
                        console.log(err.response);
                        return rej(err.response);
                    })
            }) 
        },
        register ({ commit }, {email, password, password_confirmation}) {
            return new Promise((res, rej) => {
                api.post("/register", {email, password, password_confirmation})
                    .then((data) => {
                        console.log(data);
                        commit('setUser', { email: data.user.email, id: data.user.id, accessToken: data.token_data.access_token })
                        setAccessToken(data.token_data.access_token)
                        res()
                    })
                    .catch(err => {
                        rej(err.response)
                    });
            })
        },
        authorize({state}) {
            return new Promise((resolve, reject) => {
            if(!state.user.accessToken) {
                router.push('/register');
                reject('not authorized')
            }
            resolve()

            }); 
        }
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

function setAccessToken(token) {
    localStorage.setItem('access-token', token);
}

export default store; 