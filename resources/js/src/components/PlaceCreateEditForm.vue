<template>
        <v-card class="pa-5">

        <v-form v-model="valid" :lazy-validation="true">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="placeToEdit.name"
                            label="Place Name"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="placeToEdit.address"
                            label="Place Address"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-textarea
                            v-model="placeToEdit.description"
                            label="Description"
                            required
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-autocomplete
                            v-model="placeToEdit.types"
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
                        <p>
                        Do you want to add any of your created events to the place?

                        </p>
                        <v-autocomplete
                            v-model="placeToEdit.events"
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
                    <Map :propsMarker="place.location" :allowCreateMarker="true" @markerLocationChange="markerLocationChange"/>
                </div>
                <v-btn :disabled="!valid" @click="$emit('submit', placeToEdit)">{{buttonText}}</v-btn>
        </v-form>
        </v-card>
</template>
<script>
import Map from './Map';
export default {
    name: "CreateEditPlaceForm",
    components: {Map},
    props: ['button-text', 'place', 'categories', 'placeTypes', 'events'],
    data() {
        return {
            valid: false,
            nameRules: [
                v => !!v || "Name is required",
            ],
            descriptionRules: [
                v => !!v || "Description is required",
            ],
            placeToEdit: {
                name: "",
                description: "",
                address: "",
                types: [],
                events: [],
                location_lat: '',
                location_lng: ''
            }
        };
    },

    methods: {
        markerLocationChange(data) {
           this.placeToEdit.location_lat = data.lat;
           this.placeToEdit.location_lng = data.lng;
        },
    },
    watch :{
        place: {
            immediate: true,
            handler(v) {
                this.placeToEdit = v;
            }
        }
    }
};
</script>

<style>
</style>