<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps<{
  items: {
    id: number
    name: string
    price: number
    quantity: number
    subtotal: number
    image?: string | null
  }[]
  total: number
}>()

const formatCurrency = (value: number) =>
  value.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
</script>

<template>
  <Head title="Carrinho" />

  <AppLayout>
    <div class="max-w-4xl mx-auto px-6 py-10">
      <h1 class="text-2xl font-bold mb-6">Meu Carrinho</h1>

      <div v-if="items.length">
        <div
          v-for="item in items"
          :key="item.id"
          class="flex items-center gap-4 mb-6 border-b pb-4"
        >
          <img
            v-if="item.image"
            :src="`/storage/${item.image}`"
            class="w-20 h-20 object-cover rounded"
          />

          <div class="flex-1">
            <p class="font-semibold">{{ item.name }}</p>
            <p class="text-sm text-gray-500">
              {{ formatCurrency(item.price) }}
            </p>

            <div class="flex items-center gap-3 mt-2">
              <Link
                :href="`/cart/decrease/${item.id}`"
                method="post"
                as="button"
                preserve-scroll
                class="w-9  h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
              >
                <i class="bi bi-dash text-lg"></i>
              </Link>

              <span class="font-semibold">
                {{ item.quantity }}
              </span>

              <Link
                :href="`/cart/add/${item.id}`"
                method="post"
                as="button"
                preserve-scroll
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
              >
                <i class="bi bi-plus text-lg"></i>
              </Link>
            </div>
          </div>

          <div class="flex flex-col items-end gap-2">
            <span class="font-bold text-orange-600">
              {{ formatCurrency(item.subtotal) }}
            </span>

            <Link
              :href="`/cart/remove/${item.id}`"
              method="delete"
              as="button"
              preserve-scroll
              class="text-red-500 hover:text-red-700"
            >
              <i class="bi bi-trash3-fill text-lg"></i>
            </Link>
          </div>
        </div>

        <!-- TOTAL -->
        <div class="flex justify-between text-xl font-bold mt-6">
          <span>Total</span>
          <span class="text-orange-600">
            {{ formatCurrency(total) }}
          </span>
        </div>

        <!-- BOTÃO FECHAR PEDIDO -->
        <div class="mt-6 flex justify-center">
          <Link
            href="/checkout"
            class="bg-orange-500 text-white px-8 py-3 rounded-lg
                   font-semibold hover:opacity-90 transition"
          >
            Fechar pedido
          </Link>
        </div>
      </div>

      <div v-else class="text-center text-gray-500">
        Seu carrinho está vazio
      </div>
    </div>
  </AppLayout>
</template>