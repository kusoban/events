<template>
    <v-card 
    width="100%"
    class="mx-auto text-left"
    outlined
  >
  <v-card-title>
  <router-link :to="{name: 'show-event', params: {id: event.id}}">
    {{event.name}}
  </router-link>
  {{event.id}}
  </v-card-title>

    <v-card-text>
    <p>
      {{event.description}}
    </p>
    </v-card-text>
    <v-card-actions>
      <v-chip class="ml-1" v-for="category in event.categories" @click="goToCategoryPage(category.name)">{{category.name}}</v-chip>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
    name: 'EventCard',
    props: [
      'event',
    ],
    methods: {
      goToCategoryPage(name) {
        if (this.$route.params.category == name) return;
        this.$router.push(`/events/category/${name}`);
      }
    }
}
</script>

<style>

</style>