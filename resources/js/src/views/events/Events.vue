<template>
    <v-container fluid>
        <h1 class="text-center">{{loaded ? 'Today:' : 'Loading...'}}</h1>
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
            loaded: false
        };
    },
    mounted() {
      console.log('access', this.$store.getters.user.accessToken);
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
    }
};
</script>

<style>
</style>