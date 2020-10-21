<template>
  <div class="t-editor">
    <input type="hidden" :id="id" :value="value" ref="input" />

    <trix-editor
      ref="trix"
      :class="`t-editor-content ${contentClass || ''}`"
      :disabled="disabled"
      :input="id"
      :placeholder="placeholder"
      @trix-change="onChange"
      @trix-initialize="onInitialize"
    ></trix-editor>
  </div>
</template>

<script>
import 'trix';

export default {
  name: 'Editor',

  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
    value: String,
    placeholder: String,
    contentClass: String,
  },

  data() {
    return {
      id: 't1-editor-' + Math.random().toString(36).substr(2, 10),
    };
  },

  watch: {
    value(newValue) {
      if (!this.ignoreChange) {
        this.$refs.trix.editor.loadHTML(newValue);
      }
    },
  },

  mounted() {
    document.addEventListener('trix-file-accept', this.disableAttachments);
    document.addEventListener('trix-attachment-add', this.removeAttachments);
  },

  beforeDestroy() {
    document.removeEventListener('trix-file-accept', this.disableAttachments);
    document.removeEventListener('trix-attachment-add', this.removeAttachments);
  },

  methods: {
    disableAttachments(e) {
      e.preventDefault();
    },

    removeAttachments(e) {
      e.attachment.remove();
    },

    onInitialize() {
      // TO FIX: workaround for Trix incorrectly enabling disabled
      // toolbar buttons (indent, undo, redo) initially
      const toolbar = this.$refs.trix.toolbarElement;

      toolbar.querySelector(
        '[data-trix-action="decreaseNestingLevel"]'
      ).disabled = true;
      toolbar.querySelector(
        '[data-trix-action="increaseNestingLevel"]'
      ).disabled = true;

      toolbar.querySelector('[data-trix-action="undo"]').disabled = true;
      toolbar.querySelector('[data-trix-action="redo"]').disabled = true;

      this.$emit('ready', this.$refs.trix.editor, this.$refs.input);
    },

    onChange() {
      const value = this.$refs.input.value;

      this.ignoreChange = true;

      this.$emit('change', value);
      this.$emit('input', value);

      this.$nextTick(() => {
        this.ignoreChange = false;
      });
    },

    focus() {
      this.$refs.trix.focus();
    },
  },
};
</script>

<style lang="scss">
trix-toolbar * {
  box-sizing: border-box;
}

trix-toolbar {
  @apply border-b border-gray-800 fixed w-full;

  .trix-button-row {
    @apply px-8 bg-gray-900;
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    overflow-x: auto;
    overflow-y: hidden;
  }

  .trix-button-group {
    @apply flex border-l border-r border-gray-800;

    &:not(:first-child) {
      margin-left: 6vw;
    }
  }

  .trix-button-group-spacer {
    flex-grow: 1;
  }

  .trix-button {
    position: relative;
    float: left;
    color: rgba(0, 0, 0, 0.6);
    font-size: 0.75em;
    font-weight: 600;
    white-space: nowrap;
    padding: 0 2em;
    margin: 0;
    outline: none;
    border: none;
    background: transparent;

    &:not(:first-child) {
      @apply border-l border-solid border-t-0 border-b-0 border-r-0 border-gray-800;
    }

    &.trix-active {
      @apply bg-blue-600;
    }

    &:not(:disabled) {
      cursor: pointer;
    }

    &:disabled {
      color: rgba(0, 0, 0, 0.125);
    }
  }

  .trix-button--icon {
    font-size: inherit;
    width: 3em;
    height: 3em;
    max-width: calc(1em + 3.5vw);
    text-indent: -9999px;

    &::before {
      display: inline-block;
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      opacity: 0.6;
      content: '';
      background-position: center;
      background-repeat: no-repeat;
      background-size: contain;
      right: 25%;
      left: 25%;
    }
    &.trix-active::before {
      opacity: 1;
    }

    &:disabled::before {
      opacity: 0.125;
    }
  }

  .trix-button--icon-bold::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M15.6 11.8c1-.7 1.6-1.8 1.6-2.8a4 4 0 0 0-4-4H7v14h7c2.1 0 3.7-1.7 3.7-3.8 0-1.5-.8-2.8-2.1-3.4zM10 7.5h3a1.5 1.5 0 1 1 0 3h-3v-3zm3.5 9H10v-3h3.5a1.5 1.5 0 1 1 0 3z"/></svg>');
  }

  .trix-button--icon-italic::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M10 5v3h2.2l-3.4 8H6v3h8v-3h-2.2l3.4-8H18V5h-8z"/></svg>');
  }

  .trix-button--icon-strike::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M12.73 14l.28.14c.26.15.45.3.57.44.12.14.18.3.18.5 0 .3-.15.56-.44.75-.3.2-.76.3-1.39.3A13.52 13.52 0 0 1 7 14.95v3.37a10.64 10.64 0 0 0 4.84.88c1.26 0 2.35-.19 3.28-.56.93-.37 1.64-.9 2.14-1.57s.74-1.45.74-2.32c0-.26-.02-.51-.06-.75h-5.21zm-5.5-4c-.08-.34-.12-.7-.12-1.1 0-1.29.52-2.3 1.58-3.02 1.05-.72 2.5-1.08 4.34-1.08 1.62 0 3.28.34 4.97 1l-1.3 2.93c-1.47-.6-2.73-.9-3.8-.9-.55 0-.96.08-1.2.26-.26.17-.38.38-.38.64 0 .27.16.52.48.74.17.12.53.3 1.05.53H7.23zM3 13h18v-2H3v2z"/></svg>');
  }

  .trix-button--icon-quote::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>');
  }

  .trix-button--icon-heading-1::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M12 9v3H9v7H6v-7H3V9h9zM8 4h14v3h-6v12h-3V7H8V4z"/></svg>');
  }

  .trix-button--icon-bullet-list::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M4 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm4 3h14v-2H8v2zm0-6h14v-2H8v2zm0-8v2h14V5H8z"/></svg>');
  }

  .trix-button--icon-number-list::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M2 17h2v.5H3v1h1v.5H2v1h3v-4H2v1zm1-9h1V4H2v1h1v3zm-1 3h1.8L2 13.1v.9h3v-1H3.2L5 10.9V10H2v1zm5-6v2h14V5H7zm0 14h14v-2H7v2zm0-6h14v-2H7v2z"/></svg>');
  }

  .trix-button--icon-undo::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M12.5 8c-2.6 0-5 1-6.9 2.6L2 7v9h9l-3.6-3.6A8 8 0 0 1 20 16l2.4-.8a10.5 10.5 0 0 0-10-7.2z"/></svg>');
  }

  .trix-button--icon-redo::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M18.4 10.6a10.5 10.5 0 0 0-16.9 4.6L4 16a8 8 0 0 1 12.7-3.6L13 16h9V7l-3.6 3.6z"/></svg>');
  }

  .trix-button--icon-decrease-nesting-level::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M3 19h19v-2H3v2zm7-6h12v-2H10v2zm-8.3-.3l2.8 2.9L6 14.2 4 12l2-2-1.4-1.5L1 12l.7.7zM3 5v2h19V5H3z"/></svg>');
  }

  .trix-button--icon-increase-nesting-level::before {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24"><path d="M3 19h19v-2H3v2zm7-6h12v-2H10v2zm-6.9-1L1 14.2l1.4 1.4L6 12l-.7-.7-2.8-2.8L1 9.9 3.1 12zM3 5v2h19V5H3z"/></svg>');
  }

  .trix-button--icon-link,
  .trix-button--icon-code,
  .trix-button-group--file-tools {
    display: none !important;
  }
}

trix-editor {
  padding-top: 5.5em !important;

  &:focus {
    outline: none !important;
  }
}
</style>
