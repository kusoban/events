<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="5">
            <v-card class="elevation-3">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Login form</v-toolbar-title>
                    <v-spacer />
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn icon large target="_blank" v-on="on">
                                <v-icon>mdi-code-tags</v-icon>
                            </v-btn>
                        </template>
                        <span>Source</span>
                    </v-tooltip>
                </v-toolbar>
                <v-form class="pb-2" @submit.prevent="login">
                    <v-card-text>
                            <v-text-field
                                label="Email"
                                name="login"
                                prepend-icon="person"
                                type="email"
                                v-model="email"
                            />

                            <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                type="password"
                                v-model="password"
                            />
                    </v-card-text>
                <v-card-actions>
                    <div class="d-flex flex-column align-center" style="width:100%">
                        <v-btn class="mb-2" type="submit" large text color="primary" >Login</v-btn>
                        <span class="text-center">Don't have an account? <router-link to="/register">Register</router-link></span>
                    </div>
                </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: ""
        };
    },
    mounted() {
    },
    methods: {
        login() {
            this.$store.dispatch('login', {email: this.email, password: this.password}).then(() => {
            }).then((data) => {
                this.$router.push('/')
                console.log('data from component', data);
            }).catch(err => {
                console.log('err from component:', err)
            });
        }
    }
};
</script>