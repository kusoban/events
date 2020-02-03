<template>
<v-container>
       <v-skeleton-loader
            class="mx-auto"
            max-width="555px"
            type="article, icons, actions"
            v-if="!event.id"
          ></v-skeleton-loader>

    <v-card 
    v-if="event.id"
    class="mx-auto text-left"
    outlined
    max-width="555"
  >
  <v-card-title>
    {{event.name}}
  </v-card-title>
  <div class="d-flex flex-wrap">
   
   <v-list-item>
      <v-list-item-icon>
        <v-icon>mdi-calendar</v-icon>
      </v-list-item-icon>
      <v-list-item-subtitle>{{getDate() }}</v-list-item-subtitle>
    </v-list-item>
   <v-list-item>
      <v-list-item-icon>
        <v-icon>mdi-clock</v-icon>
      </v-list-item-icon>
      <v-list-item-subtitle>{{getTime()}} / <span :class="['humanTime', getUrgency()]">{{getHumanDate()}}</span></v-list-item-subtitle>
    </v-list-item>
   <v-list-item v-if="usersWhoRegistered.length">
      <v-list-item-icon>
        <v-icon>mdi-account-group</v-icon>
      </v-list-item-icon>
      <v-list-item-subtitle><span><a @click="showUsersWhoRegistered = !showUsersWhoRegistered" href="javascript:void(0)">{{`${usersWhoRegistered.length} ${usersWhoRegistered.length > 1 ? 'people' : 'person'}`}}</a> {{usersWhoRegistered.length > 1 ? 'have' : 'has'}} registered to this event</span></v-list-item-subtitle>
    </v-list-item>
  </div>
    <v-card-text>
    {{event.description}}
    </v-card-text>
    <v-card-actions>
        <v-spacer/>
        <v-btn :loading="loading.favorite" color="amber" text @click="toggleFavorite">{{event.isFavorite ? 'Remove from Favorites' : 'Add to favorites'}}</v-btn>
        <v-btn :loading="loading.register"  color="amber" text @click="toggleRegister">{{event.isRegisteredTo ? 'Unregister' : 'Register to Event'}}</v-btn>
    </v-card-actions>
  </v-card>
   <!-- <RegisteredUsersList @closeDialog="closeDialog" :users="usersWhoRegistered" :dialog="showUsersWhoRegistered"> -->
    
   <!-- </RegisteredUsersList> -->
   <div style="position: relative; height: 300px;" class="">
  <Map :propsMarker="event.location" :allowCreateMarker="false"/>
   </div>
</v-container>
</template>

<script>
import moment from 'moment';
import RegisteredUsersList from './RegisteredUsersList';
import Map from '../../components/Map';

export default {
    name: 'SingleEvent',
    components: {
      RegisteredUsersList,
      Map,
    },
    data() {
        return {
            usersWhoRegistered: [],
            showUsersWhoRegistered: false,
            event: {},
            loading: {
              favorite: false,
              register: false,
            }
        }
    },
    mounted() {
        console.log('mounted')
        console.log(this.$route.params.id);
        this.$api.get(`/places/${this.$route.params.id}`, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters.user.accessToken,
          }
        }).then(response => {
          console.log(response);
            // this.event = (response.data)
        })
        // this.$api.get(`/events/${this.$route.params.id}/registered-users`).then(response => {
        //   this.usersWhoRegistered = response;
        // })
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