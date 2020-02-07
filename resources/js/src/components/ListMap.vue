<template>
    <div>
        <slot></slot>
        <div class="mt-3">
            <span >Show events as:</span>
        </div>
        <v-radio-group v-model="listMode" row>
            <v-radio label="Map" :value="false"></v-radio>
            <v-radio label="List" :value="true"></v-radio>
        </v-radio-group>
        <EventsGrid
            v-if="listMode"
            @changePage="(page) => $emit('changePage', page)"
            :paginationLength="paginationLength"
            :loaded="loaded"
            :events="events"
        ></EventsGrid>
        <div v-if="!listMode && events.length" style="position: relative; height: 500px;">
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
        loaded: Boolean,
        propsListMode:  Boolean,
    },
    data() {
        return {
            listMode: this.propsListMode || false
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