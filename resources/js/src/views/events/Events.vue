<template>
  <v-row>
    <v-flex lg3 v-for="event in events">

  <v-card 
    class="mx-auto text-left"
    max-width="344"
    outlined
  >
   <v-img
      src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
      height="200px"
    ></v-img>
  <v-card-title>
  <router-link :to="`/event/${event.id}`">
    {{event.name}}
  </router-link>
  </v-card-title>

    <v-card-text>
    {{event.description}}
    </v-card-text>
    <v-card-actions>
    </v-card-actions>
  </v-card>
    </v-flex>

  </v-row>
</template>

<script>
export default {
    name: 'Events',
    mounted() {
      this.$api.get('/events/').then(response => {
        console.log(response)
        this.events = response.data;
      })
    },
    data() {
      return {
        events: []
      }
    }
}
</script>

<style>

</style>