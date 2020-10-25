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
      class="border border-gray-800 mt-16 w-full max-w-2xl rounded p-8"
    >
      <div class="block -mt-12">
        <span class="bg-gray-900 text-gray-400 px-2 tracking-wider text-lg"
          >Recent presentations</span
        >
      </div>
      <div class="grid grid-cols-2 gap-4 mt-5">
        <div
          v-for="presentation in presentations"
          :key="presentation.code"
          class="flex rounded-full"
        >
          <Button
            :href="`/${presentation.code}`"
            class="rounded-l-full flex-grow truncate pr-2 flex"
            >{{ presentation.title }} <span class="ml-auto"></span
          ></Button>
          <Button
            class="rounded-r-full pl-3 pr-4"
            title="Delete"
            @click="confirmDelete(presentation)"
            >❌</Button
          >
        </div>
      </div>
    </div>

    <div class="mx-auto">
      <div class="text-center mt-24 pt-4 text-gray-700 text-sm">
        Created by
        <a
          class="underline hover:text-gray-500 focus:text-gray-400"
          href="https://twitter.com/JosephusPaye"
          target="_blank"
          rel="noopener"
          >Josephus Paye II</a
        >
        for
        <a
          class="underline hover:text-gray-500 focus:text-gray-400"
          href="https://twitter.com/JosephusPaye/status/1214853295023411200"
          target="_blank"
          rel="noopener"
          >#CreateWeekly</a
        >. View on
        <a
          class="underline hover:text-gray-500 focus:text-gray-400"
          href="https://github.com/JosephusPaye/teleprompt"
          target="_blank"
          rel="noopener"
          >Github</a
        >.
      </div>
    </div>
  </div>
</template>

<script>
import httpie from 'httpie/dist/httpie.js';

import Button from './Button.vue';
import { getPresentations, deletePresentation } from './storage';

export default {
  name: 'Start',

  components: {
    Button,
  },

  data() {
    return {
      presentations: getPresentations(),
    };
  },

  methods: {
    openPresentation() {
      const code = prompt('Enter the presentation code:');

      if (code && code.trim().length > 0) {
        window.location.href = '/' + code;
      }
    },

    confirmDelete(presentation) {
      if (confirm(`Are you sure you want to delete "${presentation.title}"?`)) {
        httpie
          .del(`/${presentation.code}`, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-Csrf-Token': window.backendData.csrfToken,
            },
          })
          .then(() => {
            deletePresentation(presentation.code);
            alert('✅ Presentation deleted');

            this.presentations = getPresentations();
          })
          .catch((err) => {
            console.log('unable to delete from server', err);

            // Delete the local presentation if the server request failed
            deletePresentation(presentation.code);
            alert('✅ Presentation deleted');

            this.presentations = getPresentations();
          })
          .catch((err) => {
            console.log('unable to delete', err);
            alert('⚠ Unable to delete presentation. Refresh and try again.');
          });
      }
    },
  },
};
</script>
