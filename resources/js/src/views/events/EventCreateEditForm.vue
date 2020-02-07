<template>
    <v-card class="pa-5">
        <v-form v-model="valid">
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        v-model="eventToCreateOrEdit.name"
                        label="Event Name"
                        required
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
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

                <v-col cols="12" md="4">
                    <v-datetime-picker
                        color="red"
                        label="Select Datetime"
                        v-model="eventToCreateOrEdit.starts_at"
                    ></v-datetime-picker>
                </v-col>
            </v-row>
            <div style="position: relative; height: 300px;" class>
                <Map :allowCreateMarker="true" @markerLocationChange="markerLocationChange" :propsMarker="{location: event.location, draggable: true}" />
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
    props: ["categories", 'button-text', 'event'],
    data() {
        return {
            tag: "",
            valid: false,
            nameRules: [v => !!v || "Name is required"],
            descriptionRules: [v => !!v || "Description is required"],
            eventToCreateOrEdit: {
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
        markerLocationChange(data) {
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
    watch: {
        event: {
            handler(event) {
                this.eventToCreateOrEdit = event;
            }
        }
    }
};
</script>

<style>
</style>