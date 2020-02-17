<template>
    <v-container fluid>
        <h1><strong>{{name}}</strong> places</h1>
        <!-- <PlacesGrid :places="places" :loaded="loaded"></PlacesGrid> -->
        <ListMap :events="[]" :loaded="loaded" :places="places"></ListMap>
    </v-container>
</template>

<script>
import PlacesGrid from './PlacesGrid';
import ListMap from '../../components/ListMap';
export default {
    name: 'PlacesByType',
    components: {
        PlacesGrid,
        ListMap,
    },
    props: ['name', 'typeId', 'params'],
    data() {
        return {
            places: [],
            loaded: false,
        }
    },
    mounted() {
        this.$api.get(`/search/places/types?place_types_names[0]=${this.name}`, {
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