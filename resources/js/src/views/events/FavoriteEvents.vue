<template>
    <v-container fluid>
        <h1>Favorites</h1>
        <EventsGrid :events="events" :loaded="loaded"></EventsGrid>
    </v-container>
</template>

<script>
import EventsGrid from '../../components/EventsGrid';
export default {
    name: 'FavoriteEvents',
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
        this.$api.get('/events/favorites', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
            }
        }).then(response => {
            this.events = response;
            this.loaded = true;
        }).catch(err => {
            if(err.response.status = 404) {
                this.loaded = true;
            }
        })
    }
}
</script>

<style>

</style>