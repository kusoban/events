<template>
  <v-container fluid> 
      <h1>{{this.$route.params.name}}</h1>
  <EventsGrid :events="events"></EventsGrid>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid'

export default {
    name: 'CategoryEvents',
    components: {
        'EventsGrid': EventsGrid
    },
    mounted() {
        this.$api.get('/search/category', {
            params: {
                name: this.$route.params.name,
            }
        }).then(response => {
            this.events = response.data;
        })
    },
    data() {
        return {
            events: [],
        }
    },

}
</script>

<style>

</style>