<template>
    <div class>
        <v-navigation-drawer v-model="drawer" app right temporary>
            <v-list dense>
                <router-link to="/">
                    <v-list-item link>
                        <v-list-item-action>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>Home</v-list-item-content>
                    </v-list-item>
                </router-link>
                <router-link to="/events/create">
                    <v-list-item link v-if="$store.getters.userIsLoggedIn">
                        <v-list-item-action>
                            <v-icon>mdi-event</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>Create Event</v-list-item-content>
                    </v-list-item>
                </router-link>
                <router-link to="/places/create">
                    <v-list-item link v-if="$store.getters.userIsLoggedIn">
                        <v-list-item-action>
                            <v-icon>mdi-event</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>Create Place</v-list-item-content>
                    </v-list-item>
                </router-link>
                <router-link to="/events/favorites">
                    <v-list-item link v-if="$store.getters.userIsLoggedIn">
                        <v-list-item-action>
                            <v-icon>mdi-star</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>Favorites</v-list-item-content>
                    </v-list-item>
                </router-link>

                <router-link to="/register">
                    <v-list-item
                        link
                        v-if="$route.name !== 'register' && !$store.getters.userIsLoggedIn"
                    >
                        <v-list-item-action>
                            <v-icon>mdi-door</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>
                            Register
                            <!-- <v-list-item-title>Home</v-list-item-title> -->
                        </v-list-item-content>
                    </v-list-item>
                </router-link>
                <router-link to="/login">
                    <v-list-item
                        link
                        v-if="$route.name !== 'login' && !$store.getters.userIsLoggedIn"
                    >
                        <v-list-item-action>
                            <v-icon>mdi-login</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>
                            Login
                            <!-- <v-list-item-title>Home</v-list-item-title> -->
                        </v-list-item-content>
                    </v-list-item>
                </router-link>
                <router-link to="/events/registered">
                    <v-list-item link v-if="$store.getters.userIsLoggedIn">
                        <v-list-item-action>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>
                            Registered
                            <!-- <v-list-item-title>Home</v-list-item-title> -->
                        </v-list-item-content>
                    </v-list-item>
                </router-link>
                <v-list-item link v-if="$store.getters.userIsLoggedIn" @click="logout">
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>

                    <v-list-item-content>
                        Logout
                        <!-- <v-list-item-title>Home</v-list-item-title> -->
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-text-field
                            solo-inverted
                            flat
                            hide-details
                            label="Search"
                            prepend-inner-icon="search"
                            v-model="searchText"
                            @keypress.enter="search"
                            ref="searchInput"
                        />
                        <!-- </div> -->
                        <v-btn small text @click="search">Search</v-btn>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar app clipped-left color="white">
            <!-- <router-link to="/"><span class="title ml-3 mr-5" to="/">Events</span></router-link> -->

            <!-- <div class=""> -->
            <router-link to="/" class="mr-4">
                <v-icon>mdi-home</v-icon>
            </router-link>
            <v-text-field
                solo-inverted
                flat
                hide-details
                label="Search"
                prepend-inner-icon="search"
                v-model="searchText"
                @keypress.enter="search"
                ref="searchInput"
            />
            <!-- </div> -->
            <v-btn large text @click="search">Search</v-btn>

            <v-spacer />

            <!-- <v-btn @click="$store.commit('test')">Test</v-btn> -->
            <v-app-bar-nav-icon @click="drawer = !drawer" />
        </v-app-bar>
    </div>
</template>

<script>
export default {
    name: 'Navigation',
    data: () => ({
      drawer: false,
      searchText: '',
    }),
    methods: {
        logout() {
            this.$store.commit('logout');
            if(this.$route.name !== 'home') {
                this.$router.replace('/')
            }
        },
        search() {
            if(!this.searchText.length) return this.$refs.searchInput.focus();
            this.$store.commit('setSearchText', {searchText: this.searchText});
            if(this.$route.name == 'events-search-results') return;
            this.$router.push({name: 'events-search-results'});
        }
    }
};
</script>

<style>
</style>