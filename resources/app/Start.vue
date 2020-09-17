<template>
  <div class="flex flex-col items-center justify-center">
    <div class="text-5xl">📃 Teleprompt</div>
    <div class="flex mt-10">
      <Button @click="$emit('navigate', 'upload')">Upload Presentation</Button>
      <div class="w-2"></div>
      <Button @click="$emit('navigate', 'open')">Open Presentation</Button>
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
};
</script>
