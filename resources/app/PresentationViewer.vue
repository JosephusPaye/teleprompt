<template>
  <div class="presentation-viewer w-screen" ref="scroller">
    <div
      class="p-8 max-w-6xl mx-auto prose-xl mirrorable"
      :class="{ 'mirror-x': mirrorX, 'mirror-y': mirrorY, 'pt-64': mirrorX }"
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

    scrollFactor() {
      return this.textSize * 100;
    },
  },

  watch: {
    mirrorX() {
      this.scrollToStart();
    },
  },

  mounted() {
    document.addEventListener('keydown', this.onKeydown);
    this.scrollToStart({ smooth: false });
  },

  beforeDestroy() {
    document.removeEventListener('keydown', this.onKeydown);
  },

  methods: {
    onKeydown(e) {
      if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
        e.preventDefault();
        this.previous();
      } else if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
        e.preventDefault();
        this.next();
      }
    },

    previous() {
      this.$el.scrollBy({
        left: 0,
        top: this.scrollFactor * (this.mirrorX ? 1 : -1),
        behavior: 'smooth',
      });
    },

    next() {
      this.$el.scrollBy({
        left: 0,
        top: this.scrollFactor * (this.mirrorX ? -1 : 1),
        behavior: 'smooth',
      });
    },

    scrollToStart(options = { smooth: true }) {
      if (this.mirrorX) {
        this.$el.scrollTo({
          left: 0,
          top: this.$el.scrollHeight,
          behavior: options.smooth ? 'smooth' : undefined,
        });
      } else {
        this.$el.scrollTo({
          left: 0,
          top: 0,
          behavior: options.smooth ? 'smooth' : undefined,
        });
      }
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
