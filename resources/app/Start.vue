<template>
  <div class="flex flex-col items-center justify-center">
    <div class="flex items-center">
      <img src="/icon.png" class="w-16 h-16" alt="Teleprompt icon" />
      <div class="text-5xl ml-6">Teleprompt</div>
    </div>

    <div class="flex mt-10">
      <Button href="/new">New Presentation</Button>
      <div class="w-2"></div>
      <Button @click="openPresentation">Open Presentation</Button>
    </div>

    <div
      v-if="presentations.length > 0"
      class="border border-gray-800 mt-12 w-full max-w-2xl rounded p-8"
    >
      <div class="font-semibold uppercase tracking-wider text-xl">
        Recent presentations
      </div>
      <div class="grid grid-cols-2 gap-4 mt-5">
        <Button
          :href="`/${presentation.code}`"
          v-for="presentation in presentations"
          :key="presentation.code"
          class="block truncate rounded-full justify-start"
          >{{ presentation.title }}</Button
        >
      </div>
    </div>
  </div>
</template>

<script>
import Button from './Button.vue';

import { getPresentations } from './storage';

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

  data() {
    return {
      presentations: getPresentations().map((p) => {
        console.log(p);
        return {
          code: p.code,
          title: p.title,
        };
      }),
    };
  },
};
</script>
