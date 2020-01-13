<template>
  <v-app id="keep">
    <v-app-bar
      app
      clipped-left
      color="white"
    >
      <!-- <v-app-bar-nav-icon @click="drawer = !drawer" /> -->
      <router-link to="/"><span class="title ml-3 mr-5" to="/">Events</span></router-link>
      <v-text-field
        solo-inverted
        flat
        hide-details
        label="Search"
        prepend-inner-icon="search"
      />

      <v-spacer />
      <v-btn v-if="this.$route.name !== 'login' && !this.$store.getters.userIsLoggedIn" to="/login">Login</v-btn>
      <v-btn v-if="this.$route.name !== 'register' && !this.$store.getters.userIsLoggedIn" class="ml-3" to="/register">Register</v-btn>
      <v-btn v-if="this.$store.getters.userIsLoggedIn" class="ml-3" @click="$store.commit('logout')">Logout</v-btn>
    </v-app-bar>


    <v-content>
      <v-container
        text-center
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
    }),
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