<template>
  <div class="flex flex-col items-center justify-center">
    <div v-if="!presentation" class="flex flex-col">
      <div class="text-5xl text-center">⚠</div>
      <div class="mt-2 text-4xl">Presentation not found</div>
      <div class="mt-2 text-lg text-center opacity-75">
        No presentation matches code "{{ code }}"
      </div>
      <div class="mt-8 text-center">
        <Button class="px-16" href="/">Go Home</Button>
      </div>
    </div>

    <div v-else class="h-screen w-screen flex flex-col overflow-x-hidden">
      <div
        class="flex justify-between items-center border-b border-gray-800 px-8 py-3 fixed w-full bg-gray-900 z-10"
        style="height: 72px"
      >
        <div class="text-xl font-semibold flex-grow mr-16">
          📃
          <input
            v-model="presentation.title"
            class="bg-transparent leading-none focus:outline-none w-2/3"
          />
        </div>
        <div class="flex flex-shrink-0 ml-6">
          <Button :disabled="saving" @click="save">{{
            saving ? 'Saving...' : '💾 Save'
          }}</Button>
          <Button class="ml-2" :disabled="deleting" @click="confirmDelete">{{
            deleting ? 'Deleting...' : '✖ Delete'
          }}</Button>
        </div>
      </div>
      <div class="flex-grow flex" style="margin-top: 72px">
        <PresentationEditor :presentation="presentation" />
      </div>
    </div>
  </div>
</template>

<script>
import httpie from 'httpie/dist/httpie.js';

import Button from './Button.vue';
import ToggleButton from './ToggleButton.vue';
import PresentationEditor from './PresentationEditor.vue';

export default {
  name: 'Presentation',

  props: {
    presentation: Object,
    code: String,
  },

  components: {
    Button,
    PresentationEditor,
  },

  data() {
    return {
      saving: false,
      deleting: false,
    };
  },

  methods: {
    save() {
      this.saving = true;
      httpie
        .patch(`/${this.code}`, {
          body: {
            title: this.presentation.title,
            content: this.presentation.content,
          },
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-Csrf-Token': window.backendData.csrfToken,
          },
        })
        .then(() => {
          this.saving = false;
          // TODO: Update save button to say 'Saved!', see the Copy button in the Noodle editor
          alert('Saved');
        })
        .catch((err) => {
          this.saving = false;
          console.log('unable to save', err);
          alert('Unable to save presentation. Try again later.');
        });
    },

    confirmDelete() {
      if (confirm('Are you sure you want to delete this presentation?')) {
        this.deleting = true;

        httpie
          .del(`/${this.code}`, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-Csrf-Token': window.backendData.csrfToken,
            },
          })
          .then(() => {
            this.deleting = false;
            alert('Presentation deleted');
            window.location.href = '/';
          })
          .catch((err) => {
            console.log('unable to delete', err);
            this.saving = false;
            alert('Unable to delete presentation. Refresh and try again.');
          });
      }
    },
  },
};
</script>
