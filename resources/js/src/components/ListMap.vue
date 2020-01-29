<template>
    <div>
        <slot></slot>
        <span>Show results as:</span>
        <v-radio-group v-model="listMode" row>
            <v-radio label="List" :value="true"></v-radio>
            <v-radio label="Map" :value="false"></v-radio>
        </v-radio-group>
        <EventsGrid
            v-if="listMode"
            @changePage="(page) => $emit('changePage', page)"
            :paginationLength="paginationLength"
            :loaded="loaded"
            :events="events"
        ></EventsGrid>
        <div v-else style="position: relative; height: 500px;">
            <EventsMap 
                :loaded="loaded" 
                :events="events"
            ></EventsMap>
        </div>
    </div>
</template>

<script>
import EventsGrid from "./EventsGrid";
import EventsMap from "./EventsMap";
export default {
    name: "ListMap",
    components: {
        EventsGrid,
        EventsMap
    },
    props: {
        paginationLength: Number,
        events: Array,
        loaded: Boolean
    },
    data() {
        return {
            listMode: true
        };
    },
    mounted() {
        console.log(this.loaded);
    },
    methods: {
        changePage(page) {
        }
    }
};
</script>

<style>
</style>