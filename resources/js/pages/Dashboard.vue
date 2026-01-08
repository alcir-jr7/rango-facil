<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

/* =====================
   TIPOS
===================== */
type Store = {
  id: number
  name: string
  is_open: boolean
  image?: string | null
  is_favorited: number
}

type Product = {
  id: number
  name: string
  price?: number | string | null
  valor?: number | string | null
  preco?: number | string | null
  price_cents?: number | null
  image?: string | null
}

/* =====================
   PROPS
===================== */
const props = defineProps<{
  stores: Store[]
  products: Product[]
}>()

/* =====================
   PREÇO
===================== */
const formatPrice = (p: Product) => {
  const value =
    p.price ??
    p.valor ??
    p.preco ??
    (p.price_cents ? p.price_cents / 100 : 0)

  return Number(value || 0).toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
}

/* =====================
   CARROSSEL
===================== */
const carouselRef = ref<HTMLElement | null>(null)
const isPaused = ref(false)
let interval: number | null = null

const startScroll = () => {
  interval = window.setInterval(() => {
    if (!isPaused.value && carouselRef.value) {
      carouselRef.value.scrollLeft += 0.6
    }
  }, 20)
}

const stopScroll = () => {
  if (interval) clearInterval(interval)
}

onMounted(startScroll)
onUnmounted(stopScroll)
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <div class="space-y-14">

      <!-- 🏪 TODAS AS LOJAS -->
      <section class="bg-orange-100 py-10">
        <h2 class="text-xl font-bold mb-6 px-6">
          Todas as Lojas
        </h2>

        <div
          ref="carouselRef"
          @mouseenter="isPaused = true"
          @mouseleave="isPaused = false"
          class="flex gap-10 overflow-x-auto px-6 custom-scrollbar"
        >
          <div
            v-for="s in stores"
            :key="s.id"
            class="flex flex-col items-center flex-shrink-0 w-40"
          >
            <div class="w-32 h-32 rounded-full border-4 border-orange-400 overflow-hidden bg-white shadow">
              <img
                v-if="s.image"
                :src="`/storage/${s.image}`"
                class="w-full h-full object-cover"
              />
              <div
                v-else
                class="w-full h-full bg-orange-400 flex items-center justify-center text-white text-2xl font-bold"
              >
                {{ s.name.charAt(0) }}
              </div>
            </div>

            <h3 class="mt-3 font-semibold text-center">
              {{ s.name }}
            </h3>

            <span
              class="text-sm font-bold"
              :class="s.is_open ? 'text-green-600' : 'text-red-600'"
            >
              {{ s.is_open ? 'Aberta' : 'Fechada' }}
            </span>

            <Link
              v-if="!s.is_favorited"
              :href="`/stores/${s.id}/favorite`"
              method="post"
              as="button"
              preserve-scroll
              class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-600 font-semibold"
            >
              ☆ Favoritar
            </Link>

            <Link
              v-else
              :href="`/stores/${s.id}/favorite`"
              method="delete"
              as="button"
              preserve-scroll
              class="mt-2 px-3 py-1 rounded-lg bg-orange-500 text-white font-semibold"
            >
              ★ Favorito
            </Link>
          </div>
        </div>
      </section>

      <!-- 🛒 PRODUTOS -->
      <section class="max-w-6xl mx-auto px-6 pb-16">
        <h2 class="text-xl font-bold mb-6">
          Produtos
        </h2>

        <div
          v-if="products.length"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          <div
            v-for="p in products"
            :key="p.id"
            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition"
          >
            <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
              <img
                v-if="p.image"
                :src="`/storage/${p.image}`"
                class="w-full h-full object-cover"
              />
              <span v-else class="text-gray-400">
                Produto em breve
              </span>
            </div>

            <div class="p-4">
              <p class="text-lg font-bold text-orange-600">
                {{ formatPrice(p) }}
              </p>
              <p class="text-sm text-gray-700 mb-4">
                {{ p.name }}
              </p>
              <button class="w-full bg-orange-500 text-white py-2 rounded-lg">
                Comprar
              </button>
            </div>
          </div>
        </div>

        <!-- PLACEHOLDER -->
        <div
          v-else
          class="grid grid-cols-1 md:grid-cols-3 gap-6"
        >
          <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <p class="text-gray-400">Produto em breve</p>
            <p class="text-orange-600 font-bold mt-2">R$ 0,00</p>
            <button class="mt-4 w-full bg-orange-500 text-white py-2 rounded-lg">
              Comprar
            </button>
          </div>
        </div>
      </section>

    </div>
  </AppLayout>
</template>

<style scoped>
.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #fb923c transparent;
}
.custom-scrollbar::-webkit-scrollbar {
  height: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #fb923c;
  border-radius: 10px;
}
</style>