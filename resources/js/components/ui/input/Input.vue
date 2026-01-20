<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { useVModel } from '@vueuse/core'
import { vMaska } from 'maska/vue';
import { MaskInputOptions } from 'maska';

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes['class']
  mask?: string | MaskInputOptions
}>()

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>()

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <input
  class="flex h-9 w-full rounded-md border border-input bg-transparent
         px-3 py-1 text-sm text-neutral-900
         placeholder:text-muted-foreground
         focus-visible:outline-none
         focus-visible:ring-1 focus-visible:ring-ring"
/>

</template>
