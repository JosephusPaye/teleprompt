<template>
  <div class="p-8">
    <div class="text-2xl">Text size</div>
    <div class="mt-6">
      <input
        type="range"
        :min="1"
        :max="6"
        :step="1"
        class="w-full"
        v-model.number="presentation.settings.textSize"
      />
    </div>

    <div class="mt-10 text-2xl">Mirror</div>
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
import debounce from 'debounce';
import httpie from 'httpie/dist/httpie.js';

import * as storage from './storage';
import ToggleButton from './ToggleButton.vue';

export default {
  name: 'PresentationSettings',

  props: {
    presentation: Object,
  },

  components: {
    ToggleButton,
  },

  watch: {
    'presentation.settings': {
      deep: true,
      handler() {
        this.saveSettingsDebounced();
      },
    },
  },

  created() {
    this.saveSettingsDebounced = debounce(this.saveSettings, 500);
  },

  methods: {
    saveSettings() {
      storage.saveSettings(this.presentation.code, this.presentation.settings);

      httpie
        .patch(`/${this.presentation.code}/settings`, {
          body: {
            settings: this.presentation.settings,
          },
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-Csrf-Token': window.backendData.csrfToken,
          },
        })
        .then(({ data }) => {
          console.log('settings saved', data.presentation.settings);
        })
        .catch((err) => {
          console.error('unable to save settings', err);
        });
    },
  },
};
</script>
