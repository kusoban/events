<template>
    <v-card 
    class="mx-auto text-left"
    outlined
    max-width="555"
  >
   <v-img
      src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
      height="200px"
    ></v-img>
  <v-card-title>
    {{event.name}}
  </v-card-title>

    <v-card-text>
    {{event.description}}
    <p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia amet laudantium optio dolores quisquam illum, similique autem rem eveniet perferendis consequuntur. Sed soluta culpa quaerat iste perferendis, quis nobis nam!</p>
    </v-card-text>
    <v-card-actions>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
    mounted() {
        this.$api.get(`/events/${this.$route.params.id}`).then(response => {
            this.event = (response.data)
        })
    },
    data() {
        return {
            event: {},
        }
    }
}
</script>

<style>

</style>