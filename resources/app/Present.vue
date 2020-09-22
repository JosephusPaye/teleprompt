<template>
  <div>
    <div
      class="flex items-center border-b border-gray-800 px-8 py-3 fixed w-full bg-gray-900 z-10"
      style="height: 72px"
      v-show="showToolbar"
    >
      <Button @click="$emit('navigate', 'presentation', presentation)"
        >⬅ Back</Button
      >
      <ToggleButton
        class="ml-auto"
        :value.sync="presentation.settings.mirrorVertically"
        >Mirror X</ToggleButton
      >
      <ToggleButton
        class="ml-2"
        :value.sync="presentation.settings.mirrorHorizontally"
        >Mirror Y</ToggleButton
      >
    </div>
    <div
      class="h-screen w-screen bg-contain no-repeat bg-center bg-black"
      @click="showToolbar = !showToolbar"
      :style="{
        backgroundImage: `url(${slide.url})`,
        transform: `rotateX(${mirrorX ? '180deg' : '0deg'}) rotateY(${
          mirrorY ? '180deg' : '0deg'
        })`,
      }"
    ></div>
  </div>
</template>

<script>
import Button from './Button.vue';
import ToggleButton from './ToggleButton.vue';

export default {
  name: 'Presentation',

  props: {
    presentation: Object,
    initialSlide: {
      type: Number,
      default: 0,
    },
  },

  components: {
    Button,
    ToggleButton,
  },

  data() {
    return {
      showToolbar: true,
      currentSlide: this.initialSlide,
    };
  },

  mounted() {
    document.addEventListener('keydown', this.onKeydown);
  },

  beforeDestroy() {
    document.removeEventListener('keydown', this.onKeydown);
  },

  computed: {
    slides() {
      return this.presentation.slides;
    },

    slide() {
      return this.slides[this.currentSlide];
    },

    mirrorX() {
      return this.presentation.settings.mirrorVertically;
    },

    mirrorY() {
      return this.presentation.settings.mirrorHorizontally;
    },
  },

  methods: {
    onKeydown(e) {
      const lastIndex = this.presentation.slides.length - 1;

      if (e.key === 'ArrowRight') {
        this.currentSlide = Math.min(this.currentSlide + 1, lastIndex);
      } else if (e.key === 'ArrowLeft') {
        this.currentSlide = Math.max(this.currentSlide - 1, 0);
      }
    },
  },
};
</script>
