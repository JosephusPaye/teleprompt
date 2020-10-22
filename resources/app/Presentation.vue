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
          <div
            class="w-2/3 py-2 rounded px-3 -ml-3 flex hover:bg-gray-800 transition duration-200"
            :class="{ 'bg-gray-800': titleFocused }"
          >
            📃
            <input
              placeholder="Untitled presentation"
              v-model="presentation.title"
              @focus="titleFocused = true"
              @blur="titleFocused = false"
              class="bg-transparent leading-none font-semibold focus:outline-none w-full ml-2"
            />
          </div>
        </div>
        <div class="flex flex-shrink-0 ml-6">
          <Button :disabled="saving" @click="save">{{
            saving ? 'Saving...' : '💾 Save'
          }}</Button>
          <Button class="ml-2" @click="$emit('navigate', 'present')"
            >▶ Present</Button
          >
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
      titleFocused: false,
    };
  },

  methods: {
    save() {
      this.saving = true;
      httpie
        .patch(`/${this.code}`, {
          body: {
            title:
              this.presentation.title.trim().length > 0
                ? this.presentation.title
                : 'Untitled presentation',
            content: this.presentation.content,
          },
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-Csrf-Token': window.backendData.csrfToken,
          },
        })
        .then(({ data }) => {
          this.saving = false;
          this.presentation.title = data.presentation.title;
          this.presentation.content = data.presentation.content;
          // TODO: Update save button to say 'Saved!', see the Copy button in the Noodle editor
          alert('✅ Presentation saved');
        })
        .catch((err) => {
          this.saving = false;
          console.log('unable to save', err);
          alert('⚠ Unable to save presentation. Try again later.');
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
            alert('✅ Presentation deleted');
            window.location.href = '/';
          })
          .catch((err) => {
            console.log('unable to delete', err);
            this.saving = false;
            alert('⚠ Unable to delete presentation. Refresh and try again.');
          });
      }
    },
  },
};
</script>
