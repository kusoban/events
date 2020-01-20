<template>
    <v-container fluid><h1>Favorites</h1>
        <EventsGrid :events="events" :loaded="loaded"></EventsGrid>
    </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
export default {
    name: 'RegisteredToEvents',
    components: {
        EventsGrid,
    },
    data() {
        return {
            events: [],
            loaded: false,
        }
    },
    mounted() {
        this.$api.get('/events/registered', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
            }
        }).then(response => {
            this.events = response;
            this.loaded = true;
        })
    }
}
</script>

<style>

</style>