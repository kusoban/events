<template>
        <v-card class="pa-5">

        <v-form v-model="valid" :lazy-validation="true">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="placeToCreate.name"
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
</template>
<script>
import Map from './Map';
export default {
    name: "CreateEditPlaceForm",
    components: {Map},
    props: ['place', 'categories', 'placeTypes', 'events'],
    data() {
        return {
            valid: false,
            nameRules: [
                v => !!v || "Name is required",
            ],
            descriptionRules: [
                v => !!v || "Description is required",
            ],
            placeToCreate: {
                name: "",
                description: "",
                address: "",
                types: [],
                events: [],
                categories: [],
                location_lat: '',
                location_lng: ''
            }
        };
    },

    mounted() {
        

    },

    methods: {
        markerLocationChange(data) {
           this.placeToCreate.location_lat = data.lat;
           this.placeToCreate.location_lng = data.lng;
        },
        create() {
            this.$emit('submit', this.placeToCreate);
        },
    },
    watch :{
        place: {
            immediate: true,
            handler(v) {
                this.placeToCreate = v;
            }
        }
    }
};
</script>

<style>
</style>