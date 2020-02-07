<template>
      <v-row class="d-flex justify-between">
        <div style="width: 100%;" v-if="!loaded">
            <v-flex xs12 sm6 md6 lg4  class="pa-2" v-for="x in Array(12)" :key="x">
                <v-skeleton-loader width="" type="article"></v-skeleton-loader>
            </v-flex>
        </div>
        <v-flex xs12 sm6 md6 lg4 class="pa-2" v-for="place in places" :key="place.id">
            <PlaceCard  :place="place"></PlaceCard>
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
import PlaceCard from './PlaceCard';
import paginationMixin from '../../mixins/pagination';
export default {
    name: 'PlacesGrid',
    components: {
        'PlaceCard': PlaceCard,
    },
    mixins: [paginationMixin],
    props: ['places', 'loaded', 'paginationLength'],
    methods: {
    }
}
</script>

<style>

</style>