<template>
    <v-flex>
            <v-container>
        <v-card class="pa-5">

        <v-form v-model="valid">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="eventToCreate.name"
                            :rules="nameRules"
                            label="Event Name"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-textarea
                            v-model="eventToCreate.description"
                            :rules="descriptionRules"
                            label="Description"
                            required
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-autocomplete
                            v-model="eventToCreate.categories"
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
                        <v-text-field
                            v-model="tag"
                            :rules="tagRules"
                            label="Event Name"
                            required
                        ></v-text-field>
                        <div class="">

                           <v-chip v-for="tag in eventToCreate.tags"
                            class="ma-2"
                            close
                            color="orange"
                            label
                            outlined
                            @click:close="removeTag(tag)"
                            >
                            {{tag}}
                            </v-chip>
                        </div>
                        <v-row>
                            <v-spacer></v-spacer>
                            <div class="">

                                <v-btn @click="addTag">Add Tag</v-btn>
                            </div>

                        </v-row>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-datetime-picker color="red" label="Select Datetime" v-model="eventToCreate.starts_at"></v-datetime-picker>
                    </v-col>
                </v-row>
                <v-btn :disabled="!eventToCreate.starts_at || !valid" @click="create">Create</v-btn>
        </v-form>
        </v-card>
            </v-container>
    </v-flex>
</template>

<script>
import DatetimePicker from "vuetify-datetime-picker";
export default {
    name: "CreateEvent",
    mounted() {
        this.$api.get('/categories').then(response => {
            this.categories = response.data
        })
    },
    data() {
        return {
            categories: [],
            tag: '',
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
            tagRules: [
                v => !!v || "Tag is required",
                v => v.length > 1 || "Tag should be at least 2 letters"
            ],
            eventToCreate: {
                name: "",
                description: "",
                starts_at: "",
                categories: [],
                tags: [],
            }
        };
    },

    methods: {
        create() {
            // return console.log(this.eventToCreate.starts_at)
            this.$api.post(
                "/events",
                this.eventToCreate,
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
                    }
                }).then(response => {
                    this.$router.push(`/event/${response.data.id}`)
                })
        },
        addTag() {
            let tags = this.eventToCreate.tags;
            if (tags.includes(this.tag)) return;
            this.eventToCreate.tags.push(this.tag);
        },
        removeTag(tag) {
            this.eventToCreate.tags = this.eventToCreate.tags.filter(v => {
                return v != tag;
            })
        }
    }
};
</script>

<style>
</style>