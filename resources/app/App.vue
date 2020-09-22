<template>
  <div id="app">
    <Start
      v-if="view === 'start'"
      @navigate="onNavigate"
      class="h-screen w-screen"
    />
    <Presentation
      v-else-if="view === 'presentation'"
      @navigate="onNavigate"
      class="h-screen w-screen"
      :presentation="backendData.presentation"
    />
    <Present
      v-else-if="view === 'present'"
      @navigate="onNavigate"
      class="h-screen w-screen"
      :presentation="backendData.presentation"
      :initialSlide="initialSlide"
    />
  </div>
</template>

<script>
import Start from './Start.vue';
import Presentation from './Presentation.vue';
import Present from './Present.vue';

export default {
  name: 'App',
  components: {
    Start,
    Presentation,
    Present,
  },
  props: {
    backendData: Object,
  },
  data() {
    return {
      view: this.backendData.view || 'start',
      initialSlide: 0,
    };
  },

  mounted() {
    console.log(this.backendData);
  },

  methods: {
    onNavigate(newView, dataA, dataB) {
      if (newView === 'present') {
        this.initialSlide = dataB;
      }

      this.view = newView;
    },
  },
};
</script>

<style>
@tailwind base;
@tailwind components;
@tailwind utilities;

html,
body,
#app {
  @apply w-screen h-screen;
}

body {
  @apply bg-gray-900 text-white;
}
</style>
