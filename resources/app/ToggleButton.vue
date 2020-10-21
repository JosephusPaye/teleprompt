<template>
  <Button :selected="value" @click="$emit('update:value', !value)">
    <slot></slot>
  </Button>
</template>

<script>
import Button from './Button.vue';

export default {
  name: 'ToggleButton',
  components: {
    Button,
  },
  props: {
    value: null,
  },
};
</script>
