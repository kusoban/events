<template>
<div class="">
  <input type="email" v-model="username" name="" id="email">
  <input type="password" v-model="password" name="" id="password">
  <button @click="login">Register</button>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Register",
    data() {
      return {
        username: '',
        password: '',
      }
    },
    methods: {
      login() {
        this.$store.dispatch('register', {username: this.username, password: this.password})
      }
    }

}
</script>

<style>

</style>