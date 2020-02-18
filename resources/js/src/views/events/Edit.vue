<template>
    <v-flex>
            <v-container>
                <EventCreateEditForm 
                    button-text="Update" 
                    :event="{...event, place_id: event.place ? event.place.id : null}"
                    :categories="categories"
                    :places="places"
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
    name: "EditEvent",
    components: {
        Map,
        EventCreateEditForm,
    },

    data() {
        return {
            event: {},
            places: [],
            categories: [],
        };
    },

    mounted() {
        const getEvents = this.$api.get(`/events/${this.$route.params.id}`)
        
        const getPlaces = this.$api.get('/places/my', {
            headers: {
                Authorization: 'Bearer ' + this.$store.getters.accessToken,
            }
        })
        
        
        Promise.all([getEvents, getPlaces]).then(response => {
            console.log(response);
            this.event = response[0].data;            
            this.places = response[1].data;            
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