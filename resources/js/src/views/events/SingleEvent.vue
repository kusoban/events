<template>
<v-container>
       <v-skeleton-loader
            class="mx-auto"
            width="555px"
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
        <v-btn color="amber" text>Add to Favorites</v-btn>
        <v-btn color="amber" text>Register</v-btn>
    </v-card-actions>
  </v-card>

</v-container>
</template>

<script>
import moment from 'moment';
export default {
    mounted() {
        setTimeout(
          () => {
            this.$api.get(`/events/${this.$route.params.id}`).then(response => {
                this.event = (response.data)
                // console.log(moment(response.data.starts_at, 'YYYY-MM-DD HH:mm:ss').fromNow());
            })
          },
          1500
        )
    },
    data() {
        return {
            event: {},
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