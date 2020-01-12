import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    count: 0,
    user: {
        email: '',
        token: '',
        refresh_token: '',
    }
  },
  mutations: {
    increment (state) {
      state.count++
    },
    login(state, payload) {
        console.log(payload);
        state.user.email = payload.email;
        state.user.token = payload.token;
        state.user.refresh_token = payload.refresh_token;
    },
    logout(state) {
        state.user = {}
    }
  },

  actions: {
      login({commit}, {username, password}) {
        axios.post('/api/login', {
            username,
            password,
            }).then(result => {
                if(result.status !== 200) return (this.error = true);
                commit('login', result.data);
            }).catch(err => {
                console.log(err.response);
            })
        },
        logout({commit}) {
            commit('logout');
        }
  },
  getters: {
      count(state) {
          return 'state count is ' + state.count;
      },
      test() {
          return 'kek'
      }
  }
})

export default store; 