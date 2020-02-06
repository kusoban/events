<template>
    <v-flex>
            <v-container>
                <PlaceCreateEditForm 
                    button-text="Create" 
                    :categories="categories" 
                    :place="{}" 
                    :place-types="placeTypes" 
                    :events="events" 
                    @submit="create"
                ></PlaceCreateEditForm>
            </v-container>
    </v-flex>
</template>
<script>
import Map from '../../components/Map';
import PlaceCreateEditForm from '../../components/PlaceCreateEditForm';

export default {
    name: "CreatePlace",
    components: {
        Map,
        PlaceCreateEditForm,
    },
    data() {
        return {
            categories: [],
            placeTypes: [],
            events: [],
            valid: false,
            nameRules: [
                v => !!v || "Name is required",
                v => v.length >= 3 || "Name must be at least 3 characters"
            ],
            descriptionRules: [
                v => !!v || "Description is required",
                v =>
                    v.length >= 10 ||
                    "Description must be at least 10 characters"
            ],
            placeToCreate: {
                types: [],
                events: [],
                name: "",
                description: "",
                categories: [],
                location_lat: '',
                location_lng: ''
            }
        };
    },

     mounted() {
        
        this.$api.get('/categories').then(response => {
            this.categories = response.data
        })
        this.$api.get('/place-types').then(response => {
            this.placeTypes = response.data
        })

        this.$api.get('/users/events', {
            headers: {
                'Authorization': 'Bearer ' + this.$store.getters.accessToken
            }
        }).then(response => {
            this.events = response.data
        })
    },

    methods: {
        create(place) {
            this.$api.post(
                "/places",
                place,
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