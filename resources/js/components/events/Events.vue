<template>
  <section>
  <div class="container">
  <div class="notification">
    This container is <strong>centesssred</strong> on desktop.
  </div>
</div>

  </section>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Events',
    mounted() {
      axios.get('/api/events').then(result => console.log(result.data))
    }
}
</script>

<style>

</style>