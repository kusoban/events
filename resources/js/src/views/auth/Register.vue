<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="6">
            <h3 class="pb-2">Register to start using all of the available features</h3>
            <v-card class="elevation-3">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Register</v-toolbar-title>
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
                <v-form class="pb-2"  @submit.prevent="register" v-model="form.valid">
                    <v-card-text>
                            <v-text-field
                                label="Email"
                                name="login"
                                :rules="emailRules"
                                prepend-icon="person"
                                type="text"
                                v-model="email"
                            />

                            <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                :rules="passwordRules"
                                prepend-icon="lock"
                                type="password"
                                v-model="password"
                            />
                            <v-text-field
                                id="passwordConfirmation"
                                label="Confirm Password"
                                name="passwordConfirmation"
                                :rules="passwordConfirmationRules"
                                prepend-icon="lock"
                                type="password"
                                v-model="passwordConfirmation"
                            />
                    </v-card-text>
                    <v-card-actions>
                        <div class="d-flex flex-column align-center justify-center" style="width: 100%">
                            <v-btn 
                                type="submit"
                                text 
                                :disabled="!form.valid"
                                large
                                color="primary"
                                class="mb-2"
                            
                            >Register</v-btn>
                            <span class="text-center">Already registered? <router-link to="/login">Login</router-link></span>
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
            errors: [],
            buttonText: "Register",
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+/.test(v) || "E-mail must be valid"
            ],
            passwordRules: [
                v => !!v || "Password is required",
                v => v.length >= 6 || "Password should be at least 6 characters"
            ],
            passwordConfirmationRules: [
                v => v.length >= 6 || "Passwords Don't Match",
                v => v == this.password || "Passwords Don't Match"
            ],
            email: "",
            password: "",
            passwordConfirmation: "",
            form: {
                valid: false
            }
        };
    },
    methods: {
        register() {
            this.$store.dispatch("register", {
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirmation
            }).then(() => {
                this.$router.push('/')
            }).catch(err => {
                return console.log(err);
                this.errors = err.response.errors;
                console.log(err)
            });
        }
    }
};
</script>