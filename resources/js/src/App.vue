<template>
  <v-app id="keep">
    <v-app-bar
      app
      clipped-left
      color="white"
    >
      <v-app-bar-nav-icon @click="drawer = !drawer" />
      <router-link to="/"><span class="title ml-3 mr-5" to="/">Events</span></router-link>
      <router-link to="/events/favorites"><span class="title ml-3 mr-5" to="/">Favorites</span></router-link>
      <div class="">

      <v-text-field
        
        solo-inverted
        flat
        hide-details
        label="Search"
        prepend-inner-icon="search"
        v-model="searchText"
        @keypress.enter="search"
        ref="searchInput"
      />
      </div>
      <v-btn large text  @click="search">Search</v-btn>

      <v-spacer />
      <v-btn v-if="$route.name !== 'login' && !$store.getters.userIsLoggedIn" to="/login">Login</v-btn>
      <v-btn v-if="$route.name !== 'register' && !$store.getters.userIsLoggedIn" class="ml-3" to="/register">Register</v-btn>
      <v-btn v-if="$store.getters.userIsLoggedIn" class="ml-3" @click="logout">Logout</v-btn>
      <v-btn @click="$store.commit('test')">Test</v-btn>
    </v-app-bar>


    <v-content>
      <v-container
        fluid
        class="grey lighten-4 fill-height"
      >
      <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex';

  export default {
    props: {
    },
    computed: {
      ...mapGetters(['userIsLoggedIn']),
    },
    data: () => ({
      drawer: false,
      searchText: '',
    }),
    mounted(){
      this.$store.commit('getUserFromLocalStorage');
    },
    methods: {
      logout() {
        this.$store.commit('logout');
        if(this.$route.name !== 'home') {
          this.$router.replace('/')
        }
      },
      search() {
        if(!this.searchText.length) return this.$refs.searchInput.focus();
        this.$store.commit('setSearchText', {searchText: this.searchText});
        if(this.$route.name == 'events-search-results') {
          return;
        } 
        this.$router.push({name: 'events-search-results'});
      }
    }
  }
</script>

<style>
a {
  text-decoration: none;
  color: unset;
}
#keep .v-navigation-drawer__border {
  display: none
}
</style>