<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps<{
  productId: number
  price: number
  minPrice?: number | null
}>()

const emit = defineEmits(['close'])

const priceType = ref<'normal' | 'minimo'>('normal')

function confirm() {
  router.post(`/cart/add/${props.productId}`, {
    price_type: priceType.value,
  })

  emit('close')
}
</script>

<template>
  <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6 space-y-4">
      <h2 class="text-xl font-bold">Escolha o preço</h2>

      <label class="flex items-center gap-3 cursor-pointer">
        <input
          type="radio"
          value="normal"
          v-model="priceType"
        />
        <span>
          Preço normal —
          <strong>{{ price.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }}</strong>
        </span>
      </label>

      <label
        v-if="minPrice"
        class="flex items-center gap-3 cursor-pointer text-green-600"
      >
        <input
          type="radio"
          value="minimo"
          v-model="priceType"
        />
        <span>
          Preço mínimo —
          <strong>{{ minPrice.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }}</strong>
        </span>
      </label>

      <div class="flex justify-end gap-3 pt-4">
        <button
          class="px-4 py-2 rounded-lg bg-gray-200"
          @click="$emit('close')"
        >
          Cancelar
        </button>

        <button
          class="px-4 py-2 rounded-lg bg-orange-500 text-white font-semibold"
          @click="confirm"
        >
          Adicionar ao carrinho
        </button>
      </div>
    </div>
  </div>
</template>