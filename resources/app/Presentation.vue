<template>
  <div class="flex flex-col items-center justify-center">
    <div v-if="!presentation" class="flex flex-col">
      <div class="text-5xl text-center">⚠</div>
      <div class="mt-2 text-4xl">Presentation not found</div>
      <div class="mt-8 text-center">
        <Button class="px-16" @click="$emit('navigate', 'start')"
          >Go Home</Button
        >
      </div>
    </div>
    <div v-else class="h-screen w-screen flex flex-col">
      <div
        class="flex justify-between items-center border-b border-gray-800 px-8 py-3 fixed w-full bg-gray-900"
        style="height: 72px"
      >
        <div class="text-xl font-semibold truncate">
          📃 {{ presentation.title }}
        </div>
        <div class="flex flex-shrink-0 ml-6">
          <Button>▶ Present</Button>
          <!-- <Button class="ml-2">🔀 Reorder</Button> -->
          <ToggleButton class="ml-2" :value.sync="showSettings"
            >⚙ Settings</ToggleButton
          >
        </div>
      </div>
      <div class="flex-grow flex" style="margin-top: 72px">
        <div class="grid slides gap-4 p-8 w-full h-0">
          <button
            v-for="(slide, index) in slides"
            :key="slide.id"
            class="rounded-lg slide-thumbnail bg-cover bg-center border border-gray-800"
            :style="{
              backgroundImage: `url(${slide.url})`,
              transform: `rotateX(${mirrorX ? '180deg' : '0deg'}) rotateY(${
                mirrorY ? '180deg' : '0deg'
              })`,
            }"
            @click="$emit('navigate', 'present', presentation, index)"
          ></button>
        </div>
        <div
          v-if="showSettings"
          class="border-l border-gray-800 p-8 flex-shrink-0"
          style="width: 420px"
        >
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
      </div>
    </div>
  </div>
</template>

<script>
import Button from './Button.vue';
import ToggleButton from './ToggleButton.vue';

export default {
  name: 'Presentation',
  props: {
    presentation: Object,
  },
  components: {
    Button,
    ToggleButton,
  },
  data() {
    return {
      showSettings: false,
    };
  },
  computed: {
    slides() {
      return this.presentation ? this.presentation.slides : [];
    },

    mirrorX() {
      return this.presentation
        ? this.presentation.settings.mirrorVertically
        : false;
    },

    mirrorY() {
      return this.presentation
        ? this.presentation.settings.mirrorHorizontally
        : false;
    },
  },
};
</script>

<style>
.slides {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-template-rows: 1fr;
  grid-gap: 16px;
}

.slide-thumbnail::before {
  content: '';
  display: block;
  height: 0;
  width: 0;
  padding-bottom: calc(9 / 16 * 100%); /* 16x9 aspect ratio */
}
</style>
