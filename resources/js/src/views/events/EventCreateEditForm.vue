<template>
    <v-card class="pa-5">
        <v-form v-model="valid">
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        v-model="eventToCreateOrEdit.name"
                        label="Event Name"
                        required
                    ></v-text-field>
                </v-col>
                 <v-col cols="12" md="4">
                    <v-datetime-picker
                        color="red"
                        label="Date"
                        v-model="eventToCreateOrEdit.starts_at"
                    ></v-datetime-picker>
                </v-col>

                 <v-col cols="12" md="4">
                    <p>Attach event to one of your places?</p>
                    <v-select 
                        label="You can leave it empty" 
                        :items="[{name: 'Do not attach', id: null}, ...places]"  
                        item-text="name"
                        item-value="id"
                        v-model="eventToCreateOrEdit.place_id"
                    >                       
                    </v-select>
                </v-col>

                  <v-col cols="12" md="12">
                    <v-textarea
                        v-model="eventToCreateOrEdit.description"
                        label="Description"
                        required
                    ></v-textarea>
                </v-col>

                <v-col cols="12" md="4">
                    <v-autocomplete
                        v-model="eventToCreateOrEdit.categories"
                        :items="categories"
                        item-text="name"
                        item-value="id"
                        outlined
                        dense
                        chips
                        small-chips
                        label="Categories"
                        multiple
                    ></v-autocomplete>
                </v-col>

              
             
                <v-col cols="12" md="4">
                    <v-text-field v-model="tag" label="Tag name" required></v-text-field>
                    <div class>
                        <v-chip
                            v-for="tag in eventToCreateOrEdit.tags"
                            class="ma-2"
                            close
                            color="orange"
                            label
                            outlined
                            @click:close="removeTag(tag)"
                        >{{tag}}</v-chip>
                    </div>
                    <v-row>
                        <v-spacer></v-spacer>
                        <div class>
                            <v-btn @click="addTag">Add Tag</v-btn>
                        </div>
                    </v-row>
                </v-col>

               
               
            </v-row>
            <div style="position: relative; height: 300px;" class>
                <Map v-if="!eventToCreateOrEdit.place_id" :draggable="true" :allowCreateMarker="true" @markerLocationChange="markerLocationChange" :propsMarker="propsMarker" />

                <Map v-else :draggable="false" :allowCreateMarker="false" @markerLocationChange="markerLocationChange" :propsMarker="propsMarker" />
            </div>
            <v-btn
                :disabled="!eventToCreateOrEdit.starts_at || !valid"
                @click="$emit('submit', eventToCreateOrEdit)"
            >{{buttonText}}</v-btn>
        </v-form>
    </v-card>
</template>
<script>
import Map from "../../components/Map";
import DatetimePicker from "vuetify-datetime-picker";
export default {
    name: "EventCreatEditForm",
    components: { Map },
    props: ["categories", 'button-text', 'event', 'places'],
    data() {
        return {
            propsMarker: {
                location: this.event.location,
                draggable: true,
                allowCreateMarker: true,
            },
            tag: "",
            valid: false,
            nameRules: [v => !!v || "Name is required"],
            descriptionRules: [v => !!v || "Description is required"],
            eventToCreateOrEdit: {
                place_id: false,
                name: "",
                description: "",
                starts_at: "",
                categories: [],
                tags: [],
                location_lat: "",
                location_lng: ""
            }
        };
    },

    methods: {
        test() {
            // console.log(!this.eventToCreateOrEdit.place_id);
        },
        markerLocationChange(data) {
            // console.log(this.eventToCreateOrEdit.place_id)
            this.eventToCreateOrEdit.location_lat = data.lat;
            this.eventToCreateOrEdit.location_lng = data.lng;
        },
        addTag() {
            if (!this.tag) return;

            let tags = this.eventToCreateOrEdit.tags;
            
            if (tags.includes(this.tag)) return;
            
            this.eventToCreateOrEdit.tags.push(this.tag);
            this.tag = "";
        },
        removeTag(tag) {
            this.eventToCreateOrEdit.tags = this.eventToCreateOrEdit.tags
            .filter(
                v => v != tag
            );
        }
    },
    computed: {
        placeId() {
            return this.eventToCreateOrEdit.place_id;
        }
    },
    watch: {
        event: {
            handler(event) {
                this.eventToCreateOrEdit = event;
            }
        },
        placeId: {
            handler(id) {
                console.log('start')

                if(!id) {
                    this.propsMarker = {
                        location: this.event.location,
                    }
                    return;
                }

                const place = this.places.find(place => place.id == id);

                console.log('here', id, )
                console.log('this.places', this.places)
                console.log('place', place);
                if(!place) return;
                this.event.location = place.location;
                this.propsMarker = {
                    location: place.location
                }
            }
        }
    }
};
</script>

<style>
</style>