<script setup lang="ts">
import { ref, computed } from 'vue'

const props = withDefaults(defineProps<{
  modelValue: number
  readonly?: boolean
  size?: 'sm' | 'md' | 'lg'
}>(), {
  readonly: false,
  size: 'md',
})

const emit = defineEmits<{
  'update:modelValue': [value: number]
}>()

const hovered = ref(0)

const sizeClass = computed(() => ({
  sm: 'text-xl',
  md: 'text-3xl',
  lg: 'text-4xl',
}[props.size]))

function setRating(value: number) {
  if (!props.readonly) emit('update:modelValue', value)
}
</script>

<template>
  <div class="flex gap-1" :class="{ 'cursor-pointer': !readonly }">
    <button
      v-for="star in 5"
      :key="star"
      type="button"
      :disabled="readonly"
      class="transition-transform duration-100 focus:outline-none"
      :class="[
        sizeClass,
        !readonly ? 'hover:scale-110' : 'cursor-default',
      ]"
      @click="setRating(star)"
      @mouseenter="!readonly && (hovered = star)"
      @mouseleave="!readonly && (hovered = 0)"
    >
      <span
        :class="
          star <= (hovered || modelValue)
            ? 'text-orange-400'
            : 'text-gray-300'
        "
      >★</span>
    </button>
  </div>
</template>
