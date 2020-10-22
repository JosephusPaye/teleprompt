<template>
  <div class="flex flex-col items-center justify-center">
    <div class="text-5xl">Teleprompt</div>
    <div class="flex mt-10">
      <Button href="/new">New Presentation</Button>
      <div class="w-2"></div>
      <Button @click="openPresentation">Open Presentation</Button>
    </div>
  </div>
</template>

<script>
import Button from './Button.vue';

export default {
  name: 'Start',

  components: {
    Button,
  },

  methods: {
    openPresentation() {
      const code = prompt('Enter the presentation code:');

      if (code && code.trim().length > 0) {
        window.location.href = '/' + code;
      }
    },
  },
};
</script>
