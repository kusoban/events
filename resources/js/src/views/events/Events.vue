<template>
  <v-container fluid> 
      <h1 class="text-center">Today</h1>
      <EventsGrid :events="events"></EventsGrid>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
export default {
    name: 'Events',
    components: {
      EventsGrid,
    },
    mounted() {
        this.$api.get('/events/').then(response => {
          console.log(response)
          setTimeout(() => {
            this.events = response.data;
          }, 1500)
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