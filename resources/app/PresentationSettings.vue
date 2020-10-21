<template>
  <div class="p-8">
    <div class="text-2xl">Settings</div>
    <div class="mt-6">
      <ToggleButton
        class="w-full"
        :value.sync="presentation.settings.mirrorVertically"
        >Mirror vertically</ToggleButton
      >
    </div>
    <div class="mt-3">
      <ToggleButton
        class="w-full"
        :value.sync="presentation.settings.mirrorHorizontally"
        >Mirror horizontally</ToggleButton
      >
    </div>
  </div>
</template>

<script>
import ToggleButton from './ToggleButton.vue';

export default {
  name: 'PresentationSettings',
  props: {
    presentation: Object,
  },
  components: {
    ToggleButton,
  },
};
</script>
