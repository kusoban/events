<template>
<div class="">
  <input type="email" v-model="username" name="" id="email">
  <input type="password" v-model="password" name="" id="password">
  <button @click="login">login</button>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Login",
    data() {
      return {
        username: '',
        password: '',
      }
    },
    methods: {
      login() {
        this.$store.dispatch('login', {username: this.username, password: this.password})
      }
    }

}
</script>

<style>

</style>