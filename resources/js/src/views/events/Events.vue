<template>
    <v-container fluid>
        <ListMap 
            @changePage="loadEvents" 
            :paginationLength="paginationLength" 
            :loaded="loaded" 
            :events="events"
        >
            <h1 class="text-center">{{loaded ? 'Upcoming events:' : 'Loading...'}}</h1>
        </ListMap>
    </v-container>
</template>

<script>
import ListMap from "../../components/ListMap";
// import paginationMixin from '../../mixins/pagination';

export default {
    name: "Events",
    components: {
        ListMap
    },
    // mixins: [paginationMixin],
    data() {
        return {
            paginationLength: 0,
            listOrMap: '',
            events: [],
            loaded: false,
            searchText: ''
        };
    },
    mounted() {
       this.loadEvents(1);
    },
    methods: {
        loadEvents(page) {
            this.$api
            .get(`/events?page=${page}`)
            .then(response => {
                this.events = response.data;
                this.loaded = true;
                this.paginationLength = response.meta.last_page;
            });
        },
        search() {

        }
    }
};
</script>

<style>
</style>