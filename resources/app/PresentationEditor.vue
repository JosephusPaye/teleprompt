<template>
  <div class="presentation-editor w-screen">
    <Editor
      v-model="presentation.content"
      contentClass="presentation-content prose-xl mirrorable"
    />
  </div>
</template>

<script>
import Editor from './Editor.vue';

export default {
  name: 'PresentationEditor',

  props: {
    presentation: {
      type: Object,
      required: true,
    },
  },

  components: {
    Editor,
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
  },
};
</script>

<style lang="scss">
.presentation-content {
  @apply p-8 max-w-4xl mx-auto;

  &.prose-xl {
    h1 {
      font-size: 1.5em;
      font-weight: bold;
    }

    blockquote {
      padding-left: 1em;
      background-color: rgba(255, 255, 0, 0.2);
      padding-top: 0.8em;
      padding-bottom: 1em;
      margin-bottom: 1em;
    }

    ul {
      list-style: inside;

      > li {
        padding-left: 0em;

        > ul {
          padding-left: 2rem;
        }
      }
    }

    ol {
      list-style: decimal;
      padding-left: 0.9em;

      > li {
        padding-left: 0.5em;
      }
    }

    ul,
    ol {
      > li > *:last-child {
        margin-bottom: 0;
      }

      > li > *:first-child {
        margin-top: 0;
      }
    }
  }
}
</style>
