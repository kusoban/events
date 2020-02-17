<template>
    <v-flex>
            <v-container>
                <EventCreateEditForm
                    button-text="Create" 
                    :categories="categories" 
                    :event="event"
                    :places="places"
                    @submit="update"
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
    mounted() {
        this.$api.get('/categories').then(response => {
            this.categories = response.data
        })

        this.$api.get('/places/my', {
            headers: {
                Authorization: 'Bearer ' + this.$store.getters.accessToken,
            }
        }).then(response => {
            this.places = response.data
        })
    },
    data() {
        return {
            categories: [],
            places: [],
            event: {
                name: '',
                description: '',
                starts_at: '',
                categories: [],
                tags: [],
                location: {
                    lat: '',
                    lng: '',
                }
            }
        };
    },

    methods: {
        update(event) {
            // return console.log(this.eventToCreate.starts_at)
            this.$api.post(
                "/events",
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