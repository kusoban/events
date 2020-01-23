<template>
    <v-flex>
        <v-container>
            <v-card class="pa-5">
                <v-form>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="eventToSearch.text"
                                label="Search for text in name or description"
                                required
                            ></v-text-field>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-datetime-picker
                                        color="red"
                                        label="From Date"
                                        v-model="eventToSearch.starts_at_from"
                                    ></v-datetime-picker>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-datetime-picker
                                        color="red"
                                        label="To Date"
                                        v-model="eventToSearch.starts_at_to"
                                    ></v-datetime-picker>
                                </v-col>
                            </v-row>
                            <v-autocomplete
                                v-model="eventToSearch.categories"
                                :items="allCategories"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Categories"
                                multiple
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="eventToSearch.tags"
                                :items="allTags"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Tags"
                                multiple
                            ></v-autocomplete>
                        </v-col>

                        <v-col cols="12" md="4"></v-col>
                    </v-row>
                    <v-btn class="mr-2" color="warning" @click="clearFields">Clear</v-btn>
                    <v-btn @click="search">Search</v-btn>
                </v-form>
            </v-card>
            <h1>{{loading ? 'Searching...' : loaded ? (foundEvents.length ? 'What we have found:' : 'Nothing found') : '' }}</h1>
            <EventsGrid :events="foundEvents" :loaded="!loading"></EventsGrid>
            <v-pagination
                v-if="pagination.length > 1"
                v-model="pagination.page"
                :length="pagination.length"
                @input="search(pagination.page)"
            ></v-pagination>
        </v-container>
    </v-flex>
</template>

<script>
import DatetimePicker from "vuetify-datetime-picker";
import EventsGrid from "../../components/EventsGrid";
import paginationMixin from "../../mixins/pagination";

export default {
    name: "Search",
    components: {
        EventsGrid
    },
    mixins: [paginationMixin],
    mounted() {
        this.$api.get("/categories").then(response => {
            this.allCategories = response.data;
        });
        this.$api.get("/tags").then(response => {
            this.allTags = response.data;
        });
    },
    data() {
        return {
            loading: false,
            loaded: false,
            foundEvents: [],
            allCategories: [],
            allTags: [],
            eventToSearch: {
                text: "",
                description: "",
                starts_at: "",
                categories: [],
                tags: [],
                starts_at_from: "",
                starts_at_to: ""
            }
        };
    },
    methods: {
        search(page) {
            (this.foundEvents = []), (this.loading = true);
            this.$api
                .get("/search/filter", {
                    params: {
                        page: page || 1,
                        text: this.eventToSearch.text,
                        starts_at_from: this.eventToSearch.starts_at_from,
                        starts_at_to: this.eventToSearch.starts_at_to,
                        categories: this.eventToSearch.categories,
                        tags: this.eventToSearch.tags
                    }
                })
                .then(response => {
                    this.foundEvents = response.data;
                    this.loading = false;
                    this.loaded = true;
                    this.setPagination(response.meta);
                })
                .catch(err => {
                    console.log("error in search controller:", err);
                });
        },
        clearFields() {
            this.eventToSearch = {
                text: "",
                description: "",
                starts_at: "",
                categories: [],
                tags: [],
                starts_at_from: "",
                starts_at_to: ""
            };
        }
    }
};
</script>

<style>
</style>