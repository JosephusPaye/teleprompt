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
      :code="backendData.code"
    />
    <Present
      v-else-if="view === 'present'"
      @navigate="onNavigate"
      class="h-screen w-screen"
      :presentation="backendData.presentation"
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
    };
  },

  methods: {
    onNavigate(newView, dataA, dataB) {
      this.view = newView;
    },
  },
};
</script>

<style lang="scss">
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

.prose-xl {
  &,
  > * {
    @apply text-white relative z-10;
  }

  h1 {
    font-size: 1.5em;
    font-weight: bold;
  }

  blockquote {
    padding-left: 1em;
    background-color: rgba(255, 255, 0, 0.2);
    padding-top: 0.8em;
    padding-bottom: 1em;
    margin-bottom: 1em;
  }

  ul {
    list-style: inside;

    > li {
      padding-left: 0em;

      > ul {
        padding-left: 2rem;
      }
    }
  }

  ol {
    list-style: decimal;
    padding-left: 0.9em;

    > li {
      padding-left: 0.5em;
    }
  }

  ul,
  ol {
    > li > *:last-child {
      margin-bottom: 0;
    }

    > li > *:first-child {
      margin-top: 0;
    }
  }
}
</style>
