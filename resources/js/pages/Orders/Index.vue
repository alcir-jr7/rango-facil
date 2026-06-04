<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import StarRating from '@/components/StarRating.vue'

type Review = {
  id: number
  rating: number
  comment: string | null
}

type Product = {
  id: number
  name: string
  quantity: number
  price: number
}

type Order = {
  id: number
  status: 'paid' | 'delivered'
  total_price: number
  created_at: string
  store: { id: number; name: string } | null
  products: Product[]
  review: Review | null
}

const props = defineProps<{ orders: Order[] }>()

const formatCurrency = (v: number) =>
  Number(v).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })

const expanded = ref<Set<number>>(new Set())
function toggle(id: number) {
  expanded.value.has(id) ? expanded.value.delete(id) : expanded.value.add(id)
}

function confirmDelivery(orderId: number) {
  if (confirm('Confirmar que você recebeu este pedido? Esta ação não pode ser desfeita.')) {
    router.patch(`/orders/${orderId}/delivered`)
  }
}

function removeReview(reviewId: number) {
  if (confirm('Remover sua avaliação?')) {
    router.delete(`/reviews/${reviewId}`)
  }
}
</script>

<template>
  <Head title="Meus Pedidos" />
  <AppLayout>
    <div class="max-w-4xl mx-auto px-6 py-10">

      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Meus Pedidos</h1>
          <p class="text-gray-500 mt-1">Confirme o recebimento e avalie suas compras</p>
        </div>
        <Link
          href="/dashboard"
          class="text-orange-500 hover:text-orange-600 font-medium text-sm"
        >
          ← Voltar ao início
        </Link>
      </div>

      <!-- Flash -->
      <div
        v-if="$page.props.flash?.success"
        class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 flex items-center gap-2"
      >
        <span class="text-green-500 text-lg">✓</span>
        {{ $page.props.flash.success }}
      </div>

      <!-- Empty state -->
      <div
        v-if="orders.length === 0"
        class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm"
      >
        <div class="text-6xl mb-4">🛍️</div>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Nenhum pedido ainda</h2>
        <p class="text-gray-400 mb-6">Suas compras aparecem aqui após o pagamento</p>
        <Link
          href="/dashboard"
          class="bg-orange-500 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-orange-600 transition"
        >
          Explorar lojas
        </Link>
      </div>

      <!-- Orders -->
      <div v-else class="space-y-4">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white rounded-2xl border shadow-sm overflow-hidden"
          :class="order.status === 'paid' ? 'border-blue-200' : order.review ? 'border-gray-100' : 'border-orange-200'"
        >
          <!-- Card header -->
          <div class="px-6 py-5 flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <!-- Loja + data -->
              <div class="flex items-center gap-2 flex-wrap mb-1">
                <span class="font-bold text-gray-900 text-lg">
                  {{ order.store?.name ?? 'Pedido #' + order.id }}
                </span>
                <span
                  class="px-2.5 py-0.5 rounded-full text-xs font-semibold"
                  :class="{
                    'bg-blue-100 text-blue-700': order.status === 'paid',
                    'bg-green-100 text-green-700': order.status === 'delivered' && order.review,
                    'bg-orange-100 text-orange-700': order.status === 'delivered' && !order.review,
                  }"
                >
                  {{
                    order.status === 'paid'
                      ? '📦 Aguardando recebimento'
                      : order.review
                        ? '✅ Avaliado'
                        : '⭐ Avalie sua compra'
                  }}
                </span>
              </div>
              <p class="text-sm text-gray-400">
                Pedido #{{ order.id }} · {{ order.created_at }}
              </p>

              <!-- Produtos (resumo) -->
              <div class="mt-2 flex flex-wrap gap-1">
                <span
                  v-for="p in order.products"
                  :key="p.id"
                  class="text-xs bg-gray-50 border border-gray-200 text-gray-600 px-2 py-0.5 rounded-full"
                >
                  {{ p.name }} × {{ p.quantity }}
                </span>
              </div>
            </div>

            <!-- Total + expand -->
            <div class="flex flex-col items-end gap-2 shrink-0">
              <span class="font-bold text-xl text-gray-900">
                {{ formatCurrency(order.total_price) }}
              </span>
              <button
                @click="toggle(order.id)"
                class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1"
              >
                {{ expanded.has(order.id) ? 'Menos detalhes ▲' : 'Ver detalhes ▼' }}
              </button>
            </div>
          </div>

          <!-- ── CTA principal (sempre visível) ── -->
          <div class="px-6 pb-5">

            <!-- ESTADO 1: Pago → Confirmar recebimento -->
            <div
              v-if="order.status === 'paid'"
              class="bg-blue-50 border border-blue-200 rounded-xl px-5 py-4 flex items-center justify-between gap-4"
            >
              <div>
                <p class="font-semibold text-blue-900 text-sm">Recebeu seu pedido?</p>
                <p class="text-xs text-blue-600 mt-0.5">
                  Confirme o recebimento para liberar a avaliação da loja.
                </p>
              </div>
              <button
                @click="confirmDelivery(order.id)"
                class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm"
              >
                ✓ Confirmar recebimento
              </button>
            </div>

            <!-- ESTADO 2: Entregue, sem avaliação → Avaliar -->
            <div
              v-else-if="order.status === 'delivered' && !order.review"
              class="bg-orange-50 border border-orange-200 rounded-xl px-5 py-4 flex items-center justify-between gap-4"
            >
              <div>
                <p class="font-semibold text-orange-900 text-sm">O que achou da compra?</p>
                <p class="text-xs text-orange-600 mt-0.5">
                  Sua avaliação ajuda outros clientes e a loja a melhorar.
                </p>
              </div>
              <Link
                :href="`/orders/${order.id}/rate`"
                class="shrink-0 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm"
              >
                ★ Avaliar compra
              </Link>
            </div>

            <!-- ESTADO 3: Já avaliado → Mostrar avaliação -->
            <div
              v-else-if="order.review"
              class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-4"
            >
              <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-semibold text-gray-700">Sua avaliação</p>
                <div class="flex gap-3 text-xs">
                  <Link
                    :href="`/orders/${order.id}/rate`"
                    class="text-orange-500 hover:text-orange-600 font-medium"
                  >
                    Editar
                  </Link>
                  <button
                    @click="removeReview(order.review!.id)"
                    class="text-red-400 hover:text-red-600 font-medium"
                  >
                    Remover
                  </button>
                </div>
              </div>
              <StarRating :model-value="order.review.rating" readonly size="sm" />
              <p v-if="order.review.comment" class="text-sm text-gray-600 mt-2 italic">
                "{{ order.review.comment }}"
              </p>
              <p v-else class="text-xs text-gray-400 mt-1 italic">Sem comentário</p>
            </div>

          </div>

          <!-- Detalhes expandíveis -->
          <div v-if="expanded.has(order.id)" class="border-t border-gray-100 px-6 py-4 bg-gray-50">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
              Itens do pedido
            </h3>
            <div class="space-y-2">
              <div
                v-for="p in order.products"
                :key="p.id"
                class="flex items-center justify-between text-sm"
              >
                <span class="text-gray-700">
                  {{ p.name }}
                  <span class="text-gray-400 ml-1">× {{ p.quantity }}</span>
                </span>
                <span class="text-gray-600 font-medium">
                  {{ formatCurrency(p.price * p.quantity) }}
                </span>
              </div>
              <div class="border-t border-gray-200 pt-2 flex justify-between font-bold text-gray-900 text-sm mt-2">
                <span>Total</span>
                <span>{{ formatCurrency(order.total_price) }}</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AppLayout>
</template>