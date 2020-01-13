<template>
    <TestComponent msg="Welcome to Your Vue.js App"/>
</template>

<script>
// @ is an alias to /src
import TestComponent from '@/components/TestComponent.vue'

export default {
  name: 'home',
  components: {
    TestComponent
  }
}
</script>
