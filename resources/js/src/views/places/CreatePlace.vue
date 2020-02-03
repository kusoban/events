<template>
    <v-flex>
            <v-container>
        <v-card class="pa-5">

        <v-form v-model="valid">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="placeToCreate.name"
                            :rules="nameRules"
                            label="Place Name"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="placeToCreate.address"
                            label="Place Address"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-textarea
                            v-model="placeToCreate.description"
                            :rules="descriptionRules"
                            label="Description"
                            required
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-autocomplete
                            v-model="placeToCreate.types"
                            :items="placeTypes"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            chips
                            small-chips
                            label="Types"
                            multiple
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-autocomplete
                            v-model="placeToCreate.categories"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            chips
                            small-chips
                            label="categories"
                            multiple
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="4">
                        <p>
                        Do you want to add any of your created events to the place?

                        </p>
                        <v-autocomplete
                            v-model="placeToCreate.events"
                            :items="events"
                            item-text="name"
                            item-value="id"
                            outlined
                            dense
                            chips
                            small-chips
                            label="events"
                            multiple
                        ></v-autocomplete>
                    </v-col>
                </v-row>
                <div style="position: relative; height: 300px;" class="">
                    <Map :allowCreateMarker="true" @markerLocationChange="markerLocationChange"/>
                </div>
                <v-btn :disabled="!valid" @click="create">Create</v-btn>
        </v-form>
        </v-card>
            </v-container>
    </v-flex>
</template>
<script>
import Map from '../../components/Map';
import DatetimePicker from "vuetify-datetime-picker";
export default {
    name: "CreatePlace",
    components: {Map},
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
    }, data() {
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