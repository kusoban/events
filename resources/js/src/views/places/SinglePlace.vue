<template>
<v-container>
       <v-skeleton-loader
            class="mx-auto"
            type="article, icons"
            v-if="!place.id"
          ></v-skeleton-loader>

    <v-card 
    v-if="place.id"
    class="mx-auto text-left"
    outlined
  >
  <v-card-title>
    {{place.name}}
  </v-card-title>
  <v-card-text>

                  <v-chip class="mr-2" v-for="type in place.types" :key="type.id">{{type.name}}</v-chip>

  </v-card-text>
  <div class="d-flex flex-wrap">
   
   <v-list-item>
      <v-list-item-icon>
        <v-icon color="red">mdi-map-marker</v-icon>
      </v-list-item-icon>
      <v-list-item-subtitle>{{place.address}}</v-list-item-subtitle>
    </v-list-item>
  </div>
    <v-card-text>
      {{place.description}}
    </v-card-text>
    </v-card>
   <div style="position: relative; height: 300px;" class="">
      <Map :propsMarker="{location: place.location, draggable: false}" :allowCreateMarker="false"/>
   </div>
   <h2>Soon at {{place.name}}:</h2>
   <EventsGrid :events="placeEvents" :loaded="true"></EventsGrid>
</v-container>
</template>

<script>
import moment from 'moment';
import RegisteredUsersList from './RegisteredUsersList';
import Map from '../../components/Map';
import EventsGrid from '../../components/EventsGrid';

export default {
    name: 'SingleEvent',
    components: {
      RegisteredUsersList,
      Map,
      EventsGrid
    },
    data() {
        return {
            place: {},
            placeEvents: [],
            usersWhoRegistered: [],
            showUsersWhoLikes: false,
            loading: {
              favorite: false,
              register: false,
            }
        }
    },
    mounted() {
      
        this.$api.get(`/places/${this.$route.params.id}`, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters.user.accessToken,
          }
        }).then(response => {
          console.log(response);
          this.place = response.data;
        })

        this.$api.get(`/places/${this.$route.params.id}/events`, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters.user.accessToken,
          }
        }).then(response => {
          console.log(response);
          this.placeEvents = response.data;
        })
    },
    methods: {
        toggleFavorite() {
          this.$store.dispatch('authorize')
            .then(() => {
              this.loading.favorite = true;
              return this.$api.post('/events/favorites', {
                'eventId': this.event.id
              },
              {
                headers: {
                  'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
                }
              })
              .then(response => {
                this.event.isFavorite = !this.event.isFavorite
                this.loading.favorite = false
              })
              }).catch(e => {

              })

        },
        toggleRegister() {
          this.$store.dispatch('authorize').then(() => {
            console.log('success')
            this.loading.register = true;
            this.$api.post('/events/register', {
              'eventId': this.event.id
            },
            {
              headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
              }
            }
            ).then(response => {
              this.event.isRegisteredTo = !this.event.isRegisteredTo
              this.loading.register = false ;
            })
          }).catch((err) => {
            console.log('err:::', err)
          })
        },
        closeDialog(v) {
          this.showUsersWhoRegistered = false;
        }
    },
}
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