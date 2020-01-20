<template>
      <v-row class="d-flex justify-between">
      <v-flex xs12 sm6 md6 lg4 v-if="!loaded" class="pa-2" v-for="x in Array(12)">
        <v-skeleton-loader width="" type="article"></v-skeleton-loader>
      </v-flex>
        <v-flex xs12 sm6 md6 lg4 class="pa-2" v-for="event in events">
            <EventCard  :event="event"></EventCard>
        </v-flex>
    </v-row>
</template>

<script>
import EventCard from './EventCard';

export default {
    props: ['events', 'loaded'],
    components: {
        'EventCard': EventCard,
    },
    name: 'EventsGrid',
}
</script>

<style>

</style>