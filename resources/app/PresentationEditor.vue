<template>
  <div class="presentation-editor w-screen">
    <Editor
      v-model="presentation.content"
      placeholder="Write something awesome..."
      contentClass="p-8 max-w-4xl mx-auto prose-xl mirrorable"
      @change="$emit('change', $event)"
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
};
</script>
