<template>
  <v-container fluid> 
      <h1>{{`Category: ${String(this.$route.params.category)}`| capitalize}}</h1>
  <EventsGrid :loaded="loaded" :events="events"></EventsGrid>
   <v-pagination
      v-if="pagination.length > 1"
      v-model="pagination.page"
      :length="pagination.length"
      @input="loadEvents"
    ></v-pagination>
  </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid'
import paginationMixin from '../../mixins/pagination'

export default {
    name: 'CategoryEvents',
    components: {
        'EventsGrid': EventsGrid
    },
    mixins: [paginationMixin],
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
    methods: {
        loadEvents() {
                this.loaded = false;
                this.events = [];
                this.$api.get('/search/category', {
                    params: {
                        name: this.category,
                        page: this.pagination.page || 1,
                    }
                }).then(response => {
                    this.events = response.data;
                    this.loaded = true;
                })
            }
    },
    watch: {
        category: {
            immediate: true,
            handler(category) {
                this.loaded = false;
                this.events = [];
                this.$api.get('/search/category', {
                    params: {
                        name: category
                    }
                }).then(response => {
                    this.events = response.data;
                    this.loaded = true;
                    this.setPagination(response.meta);
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