<template>
  <v-container fluid>
      <h1>{{ loaded ? (events.length ? 'What we have found:' : 'Nothing found :(') : 'Loading...'}}</h1>
      <EventsGrid :loaded="loaded" :events="events"></EventsGrid>
      <v-pagination
      v-if="search.length > 1"
      v-model="search.page"
      :length="search.length"
      @input="changePage"
    ></v-pagination>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
export default {
    name: 'SearchResults',
    components: {
        'EventsGrid': EventsGrid,
    },
    data() {
        return {
            search: {
                length: 1,
                page: 1,
                nextUrl: '',
                prevUrl: '',
            },
            loaded: false,
            events: []
        }
    },
    methods: {
        changePage(page) {
            this.loadSearchResults(page);
        },
        loadSearchResults(page) {
            console.log('gst:', this.globalSearchText)
             this.$api.get('/search', {
                params: {
                    'search_text': this.globalSearchText,
                    page: page || 1,
                }
            }).then(response => {
                this.events = response.data;
                this.search.length = response.last_page;
                this.search.nextUrl = response.next_page_url;
                this.search.prevUrl = response.prev_page_url;

                this.loaded = true;
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