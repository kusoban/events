<template>
    <v-container fluid>
        <h1>Your Events</h1>
        <ListMap v-if="events.length" :events="events" :loaded="loaded" :propsListMode="true"></ListMap>
    </v-container>
</template>

<script>
import ListMap from '../../components/ListMap';
export default {
    name: 'MyEvents',
    components: {
        ListMap,
    },
    data() {
        return {
            events: [],
            loaded: false,
        }
    },
    mounted() {
        this.$api.get('/events/my', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
            }
        }).then(response => {
            this.events = response.data;
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