<template>
<v-container>
       <v-skeleton-loader
            class="mx-auto"
            max-width="555px"
            type="article, icons, actions"
            v-if="!event.id"
          ></v-skeleton-loader>

    </v-skeleton-loader>
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
  </div>
    <v-card-text>
    {{event.description}}
    </v-card-text>
    <v-card-actions>
        <v-spacer/>
        <v-btn :loading="loading.favorite" color="amber" text @click="toggleFavorite">{{event.isFavorite ? 'Remove from Favorites' : 'Add to favorites'}}</v-btn>
        <v-btn :loading="loading.register"  color="amber" text @click="toggleRegister">{{event.isRegisteredTo ? 'Unregister' : 'Register'}}</v-btn>
    </v-card-actions>
  </v-card>

</v-container>
</template>

<script>
import moment from 'moment';
export default {
    mounted() {
        this.$api.get(`/events/${this.$route.params.id}`, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters.user.accessToken,
          }
        }).then(response => {
            this.event = (response.data)
        })
    },
    data() {
        return {
            event: {},
            loading: {
              favorite: false,
              register: false,
            }
        }
    },
    methods: {
        getHumanDate() {
            if(!this.event.starts_at) return 'Loading';
            return moment(this.event.starts_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
        },
        getDate() {
            if(!this.event.starts_at) return 'Loading';
            return moment(this.event.starts_at).format('MMMM Do YYYY');
        },
        getTime() {
            if(!this.event.starts_at) return 'Loading';
            return moment(this.event.starts_at).format('HH:mm');
        },
        getUrgency() {
            const diff = moment(this.event.starts_at).diff(moment(), 'hours');
            if(diff < 0) return 'past';
            if (diff < 24 ) return 'soon';
        },
        toggleFavorite() {
          this.$store.dispatch('authorize').then(() => {
            this.loading.favorite = true;
            this.$api.post('/events/favorites', {
              'eventId': this.event.id
            },
            {
              headers: {
                'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
              }
            }
            ).then(response => {
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