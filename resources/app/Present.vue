<template>
  <div class="flex flex-col overflow-x-hidden overflow-y-hidden">
    <div
      class="flex justify-between items-center border-b border-gray-800 px-8 py-3 fixed w-full bg-gray-900 z-20"
      style="height: 72px"
    >
      <Button @click="$emit('navigate', 'presentation')" class="py-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="white"
          width="24px"
          height="24px"
          class="-mr-2"
        >
          <path d="M0 0h24v24H0z" fill="none" />
          <path d="M11.67 3.87L9.9 2.1 0 12l9.9 9.9 1.77-1.77L3.54 12z" />
        </svg>
      </Button>

      <div class="text-xl font-semibold flex-grow ml-6 mr-16">
        <div class="w-2/3 truncate">{{ presentation.title }}</div>
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
