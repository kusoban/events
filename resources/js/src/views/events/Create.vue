<template>
    <v-flex 12>
        <v-form v-model="valid">
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="eventToCreate.name"
                            :rules="nameRules"
                            :counter="10"
                            label="Event Name"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="eventToCreate.description"
                            :rules="descriptionRules"
                            label="Description"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-datetime-picker label="Select Datetime" v-model="eventToCreate.dateTime"></v-datetime-picker>
                    </v-col>
                </v-row>
                <v-btn :disabled="!eventToCreate.dateTime || !valid"  @click="create">Create</v-btn>
            </v-container>
        </v-form>
    </v-flex>
</template>

<script>
import DatetimePicker from "vuetify-datetime-picker";
export default {
    name: "CreateEvent",
    data() {
        return {
            
            valid: false,
            nameRules: [
                v => !!v || 'Name is required',
                v => v.length >= 3 || 'Name must be at least 3 characters',
            ],
            descriptionRules: [
                v => !!v || 'Description is required',
                v => v.length >= 10 || 'Description must be at least 10 characters',
            ],
            eventToCreate: {
                name: "",
                description: "",
                dateTime: ""
            }
        };
    },

    methods: {
        create() {
            if(!this.eventToCreate.dateTime) this.valid = false;

            this.$api.get('/events/', data => {
                console.log(data);
            });
        }
    }
};
</script>

<style>
</style>