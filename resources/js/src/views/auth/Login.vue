<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
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
                <v-card-text>
                    <v-form>
                        <v-text-field
                            label="Email"
                            name="login"
                            prepend-icon="person"
                            type="text"
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
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text color="primary" @click="login">Login</v-btn>
                </v-card-actions>
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
                console.log('kek')
                this.$router.push('/');
            });
        }
    }
};
</script>