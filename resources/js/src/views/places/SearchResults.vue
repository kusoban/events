<template>
  <v-container fluid>
      <h1>{{ loaded ? (events.length ? 'What we have found:' : 'Nothing found :(') : 'Loading...'}}</h1>
      <p>Not enough results? Try <router-link to="/search">extended search</router-link></p>
      <EventsGrid :loaded="loaded" :events="events"></EventsGrid>
      <v-pagination
      v-if="pagination.length > 1"
      v-model="pagination.page"
      :length="pagination.length"
      @input="loadSearchResults(pagination.page)"
    ></v-pagination>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
import paginationMixin from '../../mixins/pagination';

export default {
    name: 'SearchResults',
    components: {
        'EventsGrid': EventsGrid,
    },
    mixins: [paginationMixin],
    data() {
        return {
            loaded: false,
            events: []
        }
    },
    methods: {
        loadSearchResults(page) {
            console.log('gst:', this.globalSearchText)
             this.$api.get('/search', {
                params: {
                    'search_text': this.globalSearchText,
                    page: page || 1,
                }
            }).then(response => {
                this.events = response.data;
                this.loaded = true;
                this.setPagination(response.meta);
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
            handler : function () {
                this.loadSearchResults();
            }
        }
    }

}
</script>

<style>

</style>