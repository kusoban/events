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

        <div v-if="events.length">

            <EventsGrid
                v-if="listMode"
                @changePage="(page) => $emit('changePage', page)"
                :paginationLength="paginationLength"
                :loaded="loaded"
                :events="events"
            ></EventsGrid>
            <div v-if="!listMode" style="position: relative; height: 500px;">
                <EventsMap 
                    :loaded="loaded"
                    :events="events"
                ></EventsMap>
            </div>
        </div>

        <div v-if="places && places.length">
            <PlacesGrid
                v-if="listMode"
                @changePage="(page) => $emit('changePage', page)"
                :paginationLength="paginationLength"
                :loaded="loaded"
                :places="places"
            ></PlacesGrid>
        
            <div v-if="!listMode" style="position: relative; height: 500px;">
                <PlacesMap 
                    :loaded="loaded"
                    :places="places"
                ></PlacesMap>
            </div>
        </div>
    </div>
</template>

<script>
import EventsGrid from "./EventsGrid";
import PlacesGrid from "../views/places/PlacesGrid";
import EventsMap from "./EventsMap";
import PlacesMap from "./PlacesMap";
export default {
    name: "ListMap",
    components: {
        EventsGrid,
        EventsMap,
        PlacesGrid,
        PlacesMap
    },
    props: {
        paginationLength: Number,
        events: Array,
        places: Array,
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