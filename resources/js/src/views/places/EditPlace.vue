<template>
    <v-flex>
            <v-container>
                <PlaceCreateEditForm :place="place" :categories="categories" :place-types="placeTypes" :events="events"/>
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
            this.place = response.data;
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
            this.events = response.data
        }).catch(err => {
            console.log(err.response);
        })
    },

    methods: {
        markerLocationChange(data) {
            console.log('test')
           this.placeToCreate.location_lat = data.lat;
           this.placeToCreate.location_lng = data.lng;
           console.log(this.placeToCreate.location_lat)
           console.log(this.placeToCreate.location_lng)
        },
        create() {
            this.$api.post(
                "/places",
                this.placeToCreate,
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
                    }
                }).then(response => {
                    this.$router.push(`/places/${response.data.id}`)
                })
        },
    }
};
</script>

<style>
</style>