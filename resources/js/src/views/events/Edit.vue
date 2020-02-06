<template>
    <v-flex>
            <v-container>
                <EventCreateEditForm 
                    button-text="Update" 
                    :event="event"
                    :categories="categories" 
                    @submit="create"
                ></EventCreateEditForm>
            </v-container>
    </v-flex>
</template>
<script>
import Map from '../../components/Map';
import DatetimePicker from "vuetify-datetime-picker";
import EventCreateEditForm from './EventCreateEditForm';

export default {
    name: "CreateEvent",
    components: {
        Map,
        EventCreateEditForm,
    },

    data() {
        return {
            event: {},
            categories: [],
        };
    },

    mounted() {
        this.$api.get(`/events/${this.$route.params.id}`).then(response => {
            this.event = response.data;
        }).catch(err => {
            console.log('err');
        })

        this.$api.get('/categories').then(response => {
            this.categories = response.data
        }).catch(err => {
            console.log('err');
        })
    },
   
    methods: {
        create(event) {
            this.$api.put(
                `/events/${event.id}`,
                event,
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.getters.user.accessToken
                    }
                }).then(response => {
                    this.$router.push(`/events/${response.data.id}`)
                })
        },
        addTag() {
            if(!this.tag) return
            let tags = this.eventToCreate.tags;
            if (tags.includes(this.tag)) return;
            this.eventToCreate.tags.push(this.tag);
            this.tag = ''
        },
        removeTag(tag) {
            this.eventToCreate.tags = this.eventToCreate.tags.filter(v => {
                return v != tag;
            })
        }
    }
};
</script>

<style>
</style>