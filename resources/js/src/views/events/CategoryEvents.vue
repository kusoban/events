<template>
  <v-container fluid> 
      <h1>{{`Category: ${String(this.$route.params.category)}`| capitalize}}</h1>
  <EventsGrid :loaded="loaded" :events="events"></EventsGrid>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid'

export default {
    name: 'CategoryEvents',
    components: {
        'EventsGrid': EventsGrid
    },
    data() {
        return {
            events: [],
            loaded: false,
        }
    },
    computed: {
        category() {
            return this.$route.params.category;
        }
    },
    watch: {
        category: {
            immediate: true,
            handler(name) {
                this.loaded = false;
                this.events = [];
                this.$api.get('/search/category', {
                    params: {
                        name
                    }
                }).then(response => {
                    this.events = response.data;
                    this.loaded = true;
                })
            }
        }
    },
    filters: {
        capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
}
</script>

<style>

</style>