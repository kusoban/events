<template>
  <v-container fluid>
      <h1>What we've found:</h1>
      <EventsGrid :events="events"></EventsGrid>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
export default {
    props: ['searchText'],
    components: {
        'EventsGrid': EventsGrid,
    },
    data() {
        return {
            events: []
        }
    },
    mounted() {
        this.loadSearchResults();
    },
    methods: {
        loadSearchResults() {
            this.$api.get('/search', {
                params: {
                    'search_text': this.globalSearchText,
                }
            }).then(response => {
                this.events = response.data;
            })
        }
    },
    computed: {
        globalSearchText() {
            return this.$store.getters.globalSearchText;
        }
    },
    watch: {
        globalSearchText: {
            immediate: true,
            handler: function(val, oldVal) {
                this.$api.get('/search', {
                params: {
                    'search_text': this.globalSearchText,
                }
                }).then(response => {
                    this.events = response.data;
                }).catch(err => {
                    console.log(err.response)
                })
            }
        }
    }

}
</script>

<style>

</style>