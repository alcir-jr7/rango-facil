<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import StarRating from '@/components/StarRating.vue'

type Order = {
  id: number
  total_price: number
  created_at: string
  store: { id: number; name: string } | null
  products: { id: number; name: string; quantity: number }[]
}

const props = defineProps<{ order: Order }>()

const form = useForm({
  rating: 5,
  comment: '',
})

const ratingLabel = computed(() => {
  const labels: Record<number, string> = {
    1: 'Muito ruim 😞',
    2: 'Ruim 😕',
    3: 'Regular 😐',
    4: 'Bom 😊',
    5: 'Excelente! 🤩',
  }
  return labels[form.rating] ?? ''
})

function submit() {
  form.post(`/orders/${props.order.id}/reviews`)
}

const formatCurrency = (v: number) =>
  Number(v).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
</script>

<template>
  <Head title="Avaliar Compra" />
  <AppLayout>
    <div class="max-w-2xl mx-auto px-6 py-10">

      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Avaliar Compra</h1>
        <p class="text-gray-500">Compartilhe sua experiência com este pedido</p>
      </div>

      <!-- Order summary card -->
      <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 mb-6">
        <div class="flex items-center justify-between mb-3">
          <h2 class="font-semibold text-gray-800">Pedido #{{ order.id }}</h2>
          <span class="text-gray-600 font-bold">{{ formatCurrency(order.total_price) }}</span>
        </div>
        <p v-if="order.store" class="text-sm text-gray-500 mb-2">
          🏪 {{ order.store.name }}
        </p>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="p in order.products"
            :key="p.id"
            class="text-xs bg-white border border-orange-200 text-gray-600 px-2.5 py-1 rounded-full"
          >
            {{ p.name }} × {{ p.quantity }}
          </span>
        </div>
      </div>

      <!-- Review form -->
      <form @submit.prevent="submit" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">

        <!-- Rating stars -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-3">
            Qual nota você dá? <span class="text-red-500">*</span>
          </label>
          <div class="flex items-center gap-4">
            <StarRating v-model="form.rating" size="lg" />
            <span class="text-lg font-medium text-orange-500 transition-all">
              {{ ratingLabel }}
            </span>
          </div>
          <p v-if="form.errors.rating" class="mt-1 text-sm text-red-500">
            {{ form.errors.rating }}
          </p>
        </div>

        <!-- Comment -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Comentário <span class="text-gray-400 font-normal">(opcional)</span>
          </label>
          <textarea
            v-model="form.comment"
            rows="4"
            placeholder="Conte como foi sua experiência com este pedido, tempo de entrega, qualidade dos produtos..."
            class="w-full rounded-xl border-gray-200 text-gray-700 text-sm focus:ring-orange-400 focus:border-orange-400 resize-none"
            maxlength="1000"
          />
          <p class="text-right text-xs text-gray-400 mt-1">
            {{ form.comment.length }}/1000
          </p>
          <p v-if="form.errors.comment" class="mt-1 text-sm text-red-500">
            {{ form.errors.comment }}
          </p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-2">
          <a
            href="/orders"
            class="text-gray-500 hover:text-gray-700 font-medium text-sm transition"
          >
            ← Voltar
          </a>
          <button
            type="submit"
            :disabled="form.processing || form.rating === 0"
            class="bg-orange-500 text-white px-8 py-2.5 rounded-xl font-semibold hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <span v-if="form.processing">Enviando...</span>
            <span v-else>Enviar avaliação</span>
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
