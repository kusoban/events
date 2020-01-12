<template>
  <h1>create event</h1>
</template>

<script>
import axios from 'axios';

export default {
    name: 'create-event',
    mounted() {
      axios.get('/api/events').then(result => console.log(result.data))
    }
}
</script>

<style>

</style>