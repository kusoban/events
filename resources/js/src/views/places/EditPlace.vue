<template>
    <v-flex>
            <v-container>
                <PlaceCreateEditForm @submit="updatePlace" :place="place" :categories="categories" :place-types="placeTypes" :events="events"/>
            </v-container>
    </v-flex>
</template>
<script>
import Map from '../../components/Map';
import PlaceCreateEditForm from '../../components/PlaceCreateEditForm';

export default {
    name: "EditPlace",
    components: {Map, PlaceCreateEditForm},
     data() {
        return {
            place: {},
            categories: [],
            placeTypes: [],
            events: [],
        }
    },

    mounted() {
        this.$api.get(`/places/${this.$route.params.id}`).then(response => {
            console.log(response.data);
            this.place = response.data;
            this.place.types = response.data.types.map(v => v.id);
            this.place.events = response.data.events.map(v => v.id);
        }).catch(err => {
            console.log(err.response);
        })

        this.$api.get('/categories').then(response => {
            this.categories = response.data
        }).catch(err => {
            console.log(err.response);
        })
        this.$api.get('/place-types').then(response => {
            this.placeTypes = response.data
        }).catch(err => {
            console.log(err.response);
        })

        this.$api.get('/users/events', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.accessToken
            }
        }).then(response => {
            this.events = response.data;
        }).catch(err => {
            console.log(err.response);
        })
    },

    methods: {
        updatePlace(place) {
            this.$api.put(
                `/places/${place.id}`,
                place,
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
                    }
                }).then(response => {
                    return console.log(response);
                    this.$router.push(`/places/${response.data.id}`)
                })
        },
    }
};
</script>

<style>
</style>