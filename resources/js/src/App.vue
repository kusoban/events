<template>
  <v-app id="keep">
     <Navigation/>


    <v-content class="grey lighten-4 fill-height">
      <v-container
        class="grey lighten-4"
      >
      <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex';
import Navigation from './components/Navigation';
  export default {
    components: {
      Navigation,
    },
    computed: {
      ...mapGetters(['userIsLoggedIn']),
    },
  
    mounted(){
      this.$store.dispatch('getUserFromLocalStorage');
    },
    methods: {
     
    
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