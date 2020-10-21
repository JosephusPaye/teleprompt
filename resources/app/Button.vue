<template>
  <button
    class="button rounded font-semibold px-6 h-12 leading-none py-2 select-none inline-flex items-center justify-center"
    :class="{ 'is-selected': selected, 'opacity-50': disabled }"
    @click="$emit('click', $event)"
    :disabled="disabled"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: 'Button',
  props: {
    disabled: Boolean,
    selected: Boolean,
  },
};
</script>

<style>
.button {
  @apply text-white bg-gray-800;
}

.button:hover:not(:disabled) {
  @apply bg-gray-700;
}

.button:active:not(:disabled) {
  box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2);
}

.button.is-selected:not(:disabled),
.button.is-selected:disabled {
  @apply bg-blue-600 text-white;
}

.button:disabled {
  opacity: 0.6;
}
</style>
