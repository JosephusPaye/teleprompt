<template>
  <div class="presentation-viewer w-screen">
    <div
      class="p-8 max-w-6xl mx-auto prose-xl mirrorable"
      :class="{ 'mirror-x': mirrorX, 'mirror-y': mirrorY }"
      :style="{
        fontSize: `${1.25 * textSize}rem`,
        lineHeight: textSize >= 3 ? '1.5' : '1.8',
      }"
      v-html="presentation.content"
    ></div>
  </div>
</template>

<script>
export default {
  name: 'PresentationViewer',

  props: {
    presentation: {
      type: Object,
      required: true,
    },
  },

  computed: {
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

    textSize() {
      return this.presentation ? this.presentation.settings.textSize : 1;
    },
  },
};
</script>

<style>
.mirror-x {
  --mirror-x: 180deg;
}

.mirror-y {
  --mirror-y: 180deg;
}

.mirrorable {
  transform: rotateX(var(--mirror-x, 0deg)) rotateY(var(--mirror-y, 0deg));
}
</style>
