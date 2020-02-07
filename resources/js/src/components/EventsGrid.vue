<template>
    <v-row class="d-flex justify-between">
        <v-flex xs12 sm6 md6 lg4 v-if="!loaded" class="pa-2" v-for="x in Array(12)">
            <v-skeleton-loader width type="article"></v-skeleton-loader>
        </v-flex>
        <v-flex xs12 sm6 md6 lg4 class="pa-2" v-for="event in events">
            <EventCard :event="event"></EventCard>
        </v-flex>
        <v-pagination
            v-if="paginationLength > 1"
            v-model="pagination.page"
            :length="paginationLength"
            @input="(page) => $emit('changePage', page)"
        ></v-pagination>
    </v-row>
</template>

<script>
import EventCard from "./EventCard";
import paginationMixin from "../mixins/pagination";
export default {
    name: "EventsGrid",
    components: {
        EventCard: EventCard
    },
    mixins: [paginationMixin],
    props: ["events", "loaded", "paginationLength"],
    methods: {}
};
</script>

<style>
</style>