<template>
    <v-container fluid>
        <h1>Your places</h1>
        <PlacesGrid :places="places" :loaded="loaded"></PlacesGrid>
    </v-container>
</template>

<script>
import PlacesGrid from './PlacesGrid';
export default {
    name: 'MyPlaces',
    components: {
        PlacesGrid,
    },
    data() {
        return {
            places: [],
            loaded: false,
        }
    },
    mounted() {
        this.$api.get('/places/my', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
            }
        }).then(response => {
            this.places = response.data;
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