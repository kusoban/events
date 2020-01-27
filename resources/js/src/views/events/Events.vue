<template>
    <v-container fluid>
        <v-row class="flex-nowrap pa-2">
            <v-flex md5 sm8>
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        <v-text-field
                            solo-inverted
                            flat
                            hide-details
                            label="Search"
                            prepend-inner-icon="search"
                            v-model="searchText"
                            @keypress.enter="search"
                            ref="searchInput"
                        />
                        <v-btn large text  @click="search">Search</v-btn>
                    </div>
                    <p>Or use <router-link to="/search">extended search</router-link></p>

                </div>
                    <!-- </div> -->
            </v-flex>

        </v-row>
        <h1 class="text-center">{{loaded ? 'Upcoming events:' : 'Loading...'}}</h1>
        <EventsGrid :loaded="loaded" :events="events"></EventsGrid>
    </v-container>
</template>

<script>
import EventsGrid from "../../components/EventsGrid";
export default {
    name: "Events",
    components: {
        EventsGrid
    },
    data() {
        return {
            events: [],
            loaded: false,
            searchText: ''
        };
    },
    mounted() {
        this.$api
            .get("/events", {
                headers: {
                    Authorization:
                        "Bearer " + this.$store.getters.user.accessToken
                }
            })
            .then(response => {
                this.events = response.data;
                this.loaded = true;
            });
    },
    methods: {
        search() {
            this.$store.commit('setSearchText', {searchText: this.searchText});
            this.$router.push('/events/search-results')
        }
    },
};
</script>

<style>
</style>