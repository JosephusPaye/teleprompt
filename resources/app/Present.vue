<template>
  <div class="flex flex-col overflow-x-hidden overflow-y-hidden">
    <div
      class="flex justify-between items-center border-b border-gray-800 px-8 py-3 fixed w-full bg-gray-900 z-10"
      style="height: 72px"
    >
      <div class="text-xl font-semibold flex-grow mr-16">
        <div class="w-2/3 py-2 truncate">
          📃 <span class="ml-1">{{ presentation.title }}</span>
        </div>
      </div>
      <div class="flex flex-shrink-0 ml-6">
        <Button @click="$emit('navigate', 'presentation')">✒ Edit</Button>
        <ToggleButton class="ml-2" :value.sync="showSettings"
          >⚙ Settings</ToggleButton
        >
      </div>
    </div>
    <div class="flex-grow flex overflow-y-auto" style="margin-top: 72px">
      <PresentationViewer
        :presentation="presentation"
        class="flex-grow overflow-y-auto"
        :style="{ marginRight: showSettings ? '24rem' : '0' }"
      />
      <PresentationSettings
        v-if="showSettings"
        class="fixed right-0 border-l h-full border-gray-800"
        style="width: 24rem"
        :presentation="presentation"
      />
    </div>
  </div>
</template>

<script>
import Button from './Button.vue';
import ToggleButton from './ToggleButton.vue';
import PresentationViewer from './PresentationViewer.vue';
import PresentationSettings from './PresentationSettings.vue';

export default {
  name: 'Present',

  props: {
    presentation: Object,
  },

  components: {
    Button,
    ToggleButton,
    PresentationViewer,
    PresentationSettings,
  },

  data() {
    return {
      showSettings: false,
    };
  },
};
</script>
