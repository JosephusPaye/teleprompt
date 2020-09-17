<template>
  <div id="app" class="h-screen w-screen">
    <Start class="h-screen w-screen" />
  </div>
</template>

<script>
import Start from './Start.vue';

export default {
  name: 'App',
  components: {
    Start,
  },
  props: {
    backendData: Object,
  },
  data() {
    return {};
  },
  mounted() {
    console.log(this.backendData);
  },
  methods: {
    //
  },
};
</script>

<style>
@tailwind base;
@tailwind components;
@tailwind utilities;

body {
  @apply bg-gray-900 text-white;
}
</style>
