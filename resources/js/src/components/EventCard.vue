<template>
    <v-card 
    width="355px"
    class="mx-auto text-left"
    outlined
  >
  <v-card-title>
  <router-link :to="`/event/${event.id}`">
    {{event.name}}
  </router-link>
  </v-card-title>

    <v-card-text>
    {{event.description}}
    </v-card-text>
    <v-card-actions>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
    name: 'EventCard',
    props: {
        event,
    }
}
</script>

<style>

</style>