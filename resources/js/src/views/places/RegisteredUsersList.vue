<template>
<v-dialog @input="(v) => { v || $emit('closeDialog')}" :value="dialog" scrollable max-width="300px">
      <v-card>
        <v-card-title>Registered Users</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px;">
            <v-list>
                <v-list-item  v-for="user in users" :key="user">
                    <span>
                        {{user}}
                    </span>
                </v-list-item>
            </v-list>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="blue darken-1" text @click="$emit('closeDialog')">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'RegisteredUsersList',
    props: {
        users: Array,
        dialog: Boolean
    },
    methods: {
        handleDialog(v) {

        }
    }
 

}
</script>

<style>

</style>