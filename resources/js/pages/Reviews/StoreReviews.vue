<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import StarRating from '@/components/StarRating.vue'

type Review = {
  id: number
  rating: number
  comment: string | null
  created_at: string
  user: { name: string }
  order_id: number
}

const props = defineProps<{
  reviews: Review[]
  avgRating: number
}>()

const ratingCounts = Array.from({ length: 5 }, (_, i) => {
  const star = 5 - i
  const count = props.reviews.filter(r => r.rating === star).length
  const pct = props.reviews.length ? Math.round((count / props.reviews.length) * 100) : 0
  return { star, count, pct }
})
</script>

<template>
  <Head title="Avaliações da Loja" />
  <AppLayout>
    <div class="max-w-3xl mx-auto px-6 py-10">

      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Avaliações Recebidas</h1>
        <p class="text-gray-500">O que os clientes acharam dos seus pedidos</p>
      </div>

      <!-- Stats -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8 flex items-center gap-8">
        <div class="text-center">
          <p class="text-5xl font-extrabold text-orange-500">{{ avgRating || '—' }}</p>
          <StarRating
            :model-value="Math.round(avgRating)"
            readonly
            size="sm"
            class="justify-center mt-1"
          />
          <p class="text-xs text-gray-400 mt-1">{{ reviews.length }} avaliações</p>
        </div>

        <div class="flex-1 space-y-1.5">
          <div
            v-for="r in ratingCounts"
            :key="r.star"
            class="flex items-center gap-2 text-sm"
          >
            <span class="text-gray-500 w-4">{{ r.star }}</span>
            <span class="text-orange-400">★</span>
            <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
              <div
                class="bg-orange-400 h-full rounded-full transition-all duration-500"
                :style="{ width: r.pct + '%' }"
              />
            </div>
            <span class="text-gray-400 text-xs w-6">{{ r.count }}</span>
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div
        v-if="reviews.length === 0"
        class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm"
      >
        <div class="text-5xl mb-3">🌟</div>
        <p class="text-gray-500">Nenhuma avaliação recebida ainda.</p>
        <p class="text-gray-400 text-sm mt-1">As avaliações aparecem quando clientes confirmam o recebimento.</p>
      </div>

      <!-- Review list -->
      <div v-else class="space-y-4">
        <div
          v-for="r in reviews"
          :key="r.id"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
        >
          <div class="flex items-start justify-between mb-2">
            <div>
              <p class="font-semibold text-gray-800">{{ r.user.name }}</p>
              <p class="text-xs text-gray-400">Pedido #{{ r.order_id }} · {{ r.created_at }}</p>
            </div>
            <StarRating :model-value="r.rating" readonly size="sm" />
          </div>
          <p v-if="r.comment" class="text-gray-600 text-sm italic mt-2 leading-relaxed">
            "{{ r.comment }}"
          </p>
          <p v-else class="text-gray-400 text-sm italic mt-2">
            Sem comentário.
          </p>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
