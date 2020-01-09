<template>
    <div id="app">
        <router-link to="events">events</router-link>
        <router-link to="login">loginssd</router-link>
        <router-link to="register">register</router-link>
        <router-link to="/event/create">create event</router-link>
        <router-link to="login"><button @click="logout">logout</button></router-link>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
    methods: {
        logout() {
            this.$store.dispatch('logout')
        }
    }
};
</script>

<style>
html, body, #app {
    height: 100%;
}
    #app {
        display: flex;
        flex-direction: column;
    }
</style>