<template>
    <v-card 
    width="100%"
    class="mx-auto text-left"
    outlined
  >
  <v-card-title>
  <router-link :to="{name: 'show-place', params: {id: place.id}}">
    {{place.name}}
  </router-link>
  {{place.id}}
  </v-card-title>

    <v-card-text>
    <p>
      {{place.description}}
    </p>
    </v-card-text>
    <v-card-actions>
      <v-chip class="ml-1" v-for="type in place.types" :key="type.id" @click="">{{type.name}}</v-chip>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
    name: 'PlaceCard',
    props: [
      'place',
    ],
    methods: {
    }
}
</script>

<style>

</style>