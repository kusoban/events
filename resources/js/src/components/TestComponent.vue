<template>
      <v-flex 12>
        <v-date-picker v-model="datePicker" color="green lighten-1"></v-date-picker>
        <v-datetime-picker label="Select Datetime" v-model="dateTime"> </v-datetime-picker>
      </v-flex>

</template>

<script>
import DatetimePicker from 'vuetify-datetime-picker'
export default {
  name: 'HelloWorld',

  mounted() {
    
  },
  data: () => ({
    datePicker: null,
    dateTime: null,
  }),
};
</script>
