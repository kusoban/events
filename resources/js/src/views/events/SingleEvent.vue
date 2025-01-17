<template>
    <v-container>
        <v-skeleton-loader v-if="!event.id" class="mx-auto" type="article, icons, actions"></v-skeleton-loader>

        <v-card v-if="event.id" class="mx-auto text-left" outlined>
            <v-card-title>{{event.name}}</v-card-title>
            <div class="d-flex flex-wrap">
              <v-card-text>

              </v-card-text>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon color="blue">mdi-calendar</v-icon>
                    </v-list-item-icon>
                    <v-list-item-subtitle>{{getDate() }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon color="amber">mdi-clock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-subtitle>
                        {{getTime()}} /
                        <span :class="['humanTime', getUrgency()]">{{getHumanDate()}}</span>
                    </v-list-item-subtitle>
                </v-list-item>

                 <v-list-item v-if="event.place">
                    <v-list-item-icon>
                        <v-icon color="red">mdi-home-map-marker</v-icon>
                    </v-list-item-icon>
                    <v-list-item-subtitle>
                        at<router-link
                            :to="{name: 'show-place', params: {id: event.place.id}}"
                        > {{event.place.name}}</router-link>
                    </v-list-item-subtitle>
                </v-list-item>

                <v-list-item v-if="usersWhoRegistered.length">
                    <v-list-item-icon>
                        <v-icon>mdi-account-group</v-icon>
                    </v-list-item-icon>
                    <v-list-item-subtitle>
                        <span>
                            <a
                                @click="showUsersWhoRegistered = !showUsersWhoRegistered"
                                href="javascript:void(0)"
                            >{{`${usersWhoRegistered.length} ${usersWhoRegistered.length > 1 ? 'people' : 'person'}`}}</a>
                            {{usersWhoRegistered.length > 1 ? 'have' : 'has'}} registered to this event
                        </span>
                    </v-list-item-subtitle>
                </v-list-item>

               
            </div>
            <v-card-text>{{event.description}}</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    :loading="loading.favorite"
                    color="amber"
                    text
                    @click="toggleFavorite"
                >{{event.isFavorite ? 'Remove from Favorites' : 'Add to favorites'}}</v-btn>
                <v-btn
                    :loading="loading.register"
                    color="amber"
                    text
                    @click="toggleRegister"
                >{{event.isRegisteredTo ? 'Unregister' : 'Register to Event'}}</v-btn>
            </v-card-actions>
        </v-card>
        <RegisteredUsersList
            @closeDialog="closeDialog"
            :users="usersWhoRegistered"
            :dialog="showUsersWhoRegistered"
        ></RegisteredUsersList>
        <div style="position: relative; height: 300px;" class>
            <Map
                :propsMarker="{location: event.location, draggable: false}"
                :allowCreateMarker="false"
            />
        </div>
    </v-container>
</template>

<script>
import moment from "moment";
import RegisteredUsersList from "./RegisteredUsersList";
import Map from "../../components/Map";

export default {
    name: "SingleEvent",
    components: {
        RegisteredUsersList,
        Map
    },
    data() {
        return {
            usersWhoRegistered: [],
            showUsersWhoRegistered: false,
            event: {},
            loading: {
                favorite: false,
                register: false
            }
        };
    },
    mounted() {
        this.$api
            .get(`/events/${this.$route.params.id}`, {
                headers: {
                    Authorization:
                        "Bearer " + this.$store.getters.user.accessToken
                }
            })
            .then(response => {
                this.event = response.data;
            });
        this.$api
            .get(`/events/${this.$route.params.id}/registered-users`)
            .then(response => {
                this.usersWhoRegistered = response;
            });
    },
    methods: {
        getHumanDate() {
            if (!this.event.starts_at) return "Loading";
            return moment(
                this.event.starts_at,
                "YYYY-MM-DD HH:mm:ss"
            ).fromNow();
        },
        getDate() {
            if (!this.event.starts_at) return "Loading";
            return moment(this.event.starts_at).format("MMMM Do YYYY");
        },
        getTime() {
            if (!this.event.starts_at) return "Loading";
            return moment(this.event.starts_at).format("HH:mm");
        },
        getUrgency() {
            const diff = moment(this.event.starts_at).diff(moment(), "hours");
            if (diff < 0) return "past";
            if (diff < 24) return "soon";
        },
        toggleFavorite() {
            this.$store
                .dispatch("authorize")
                .then(() => {
                    this.loading.favorite = true;
                    return this.$api
                        .post(
                            "/events/favorites",
                            {
                                eventId: this.event.id
                            },
                            {
                                headers: {
                                    Authorization:
                                        "Bearer " +
                                        this.$store.getters.user.accessToken
                                }
                            }
                        )
                        .then(response => {
                            this.event.isFavorite = !this.event.isFavorite;
                            this.loading.favorite = false;
                        });
                })
                .catch(e => {});
        },
        toggleRegister() {
            this.$store
                .dispatch("authorize")
                .then(() => {
                    console.log("success");
                    this.loading.register = true;
                    this.$api
                        .post(
                            "/events/register",
                            {
                                eventId: this.event.id
                            },
                            {
                                headers: {
                                    Authorization:
                                        "Bearer " +
                                        this.$store.getters.user.accessToken
                                }
                            }
                        )
                        .then(response => {
                            this.event.isRegisteredTo = !this.event
                                .isRegisteredTo;
                            this.loading.register = false;
                        });
                })
                .catch(err => {
                    console.log("err:::", err);
                });
        },
        closeDialog(v) {
            this.showUsersWhoRegistered = false;
        }
    }
};
</script>

<style lang="scss" scoped>
.humanTime {
    color: greenyellow;
    &.past {
        color: red;
    }
    &.soon {
        color: orange;
    }
}
</style>