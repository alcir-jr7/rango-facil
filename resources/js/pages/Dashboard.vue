<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

function updateCartCount() {
  router.reload({
    only: ['cartCount'],
  })
}

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
  min_price?: number | string | null
  price_cents?: number | null
  image_path?: string | null
}

const props = defineProps<{
  stores: Store[]
  products: Product[]
}>()

const formatCurrency = (value?: number | string | null) => {
  return Number(value || 0).toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
}

const formatPrice = (p: Product) => formatCurrency(p.price)

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

const comprarAgora = async (productId: number) => {
  try {
    const response = await axios.post('/pagamento/criar', {
      product_id: productId,
    })

    // redireciona para o Mercado Pago
    window.location.href = response.data.init_point
  } catch (error: any) {
  console.log(error.response)
  alert(error.response?.status + ' - ' + error.response?.data?.message)
  }
}
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <div class="min-h-screen bg-orange-50/30">

      <section class="max-w-7xl mx-auto px-6 pt-8 pb-6">
        <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-3xl p-8 flex items-center gap-90 shadow-lg relative overflow-hidden">
          <!-- Texto -->
          <div class="z-10 max-w-md">
            <h2 class="text-white text-6xl font-bold mb-2">
              Experiência em cada mordida
            </h2>
            <p class="text-white text-lg">
              Combos irresistíveis, preços especiais e entrega rápida. Peça agora e mate sua fome com estilo!
            </p>
          </div>
          <!-- Imagem -->
          <div class="relative z-10 hidden md:block -ml-6">
            <img 
              src="/hambúrguer.png"
              alt="Hambúrguer delicioso"
              class="w-64 scale-150 drop-shadow-xl rotate-[-8deg]"
            />
          </div>
          <!-- Efeito blur -->
          <div class="absolute right-8 bottom-0 w-48 h-48 bg-orange-600/20 rounded-full blur-3xl"></div>
        </div>
      </section>

      <!--TODAS AS LOJAS -->
      <section class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-gray-800">
            Lojas Parceiras
          </h2>
          <Link 
            href="/stores"
            class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1 transition"
          >
            Ver todas
            <i class="bi bi-arrow-right"></i>
          </Link>
        </div>

        <div class="flex gap-6 overflow-x-auto pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
          <div
            v-for="s in stores.slice(0, 6)"
            :key="s.id"
            class="flex-shrink-0 w-40"
          >
            <!-- CARD PRINCIPAL -->
            <div class="relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
              
              <!-- Badge de Status (canto superior direito) -->
              <div class="absolute top-3 right-3 z-10">
                <div 
                  class="w-3 h-3 rounded-full shadow-lg ring-2 ring-white"
                  :class="s.is_open ? 'bg-green-500' : 'bg-red-500'"
                  :title="s.is_open ? 'Aberta' : 'Fechada'"
                ></div>
              </div>

              <!-- Botão Favorito (canto superior esquerdo) -->
              <Link
                :href="`/stores/${s.id}/favorite`"
                :method="s.is_favorited ? 'delete' : 'post'"
                as="button"
                preserve-scroll
                class="absolute top-3 left-3 z-10 transition-transform hover:scale-110"
              >
                <i 
                  class="text-xl drop-shadow-md"
                  :class="s.is_favorited 
                    ? 'bi bi-star-fill text-orange-500' 
                    : 'bi bi-star text-gray-400 hover:text-orange-500'"
                ></i>
              </Link>

              <!-- Link para a loja -->
              <Link
                :href="`/stores/${s.id}`"
                class="block p-5"
              >
                <!-- Logo da Loja -->
                <div class="flex justify-center mb-4">
                  <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-md">
                    <img
                      v-if="s.image"
                      :src="`/storage/${s.image}`"
                      :alt="s.name"
                      class="w-16 h-16 object-cover rounded-xl"
                    />
                    <div
                      v-else
                      class="text-orange-500 text-3xl font-bold"
                    >
                      {{ s.name.charAt(0) }}
                    </div>
                  </div>
                </div>

                <!-- Nome da Loja -->
                <h3 class="text-sm font-bold text-gray-800 text-center line-clamp-2 min-h-[40px] mb-2">
                  {{ s.name }} -
                  <i class="bi bi-shop text-orange-500"></i>
                </h3>
              </Link>
            </div>
          </div>
        </div>
      </section>

      <!-- 🛒 PRODUTOS -->
      <section class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-gray-800">
            Produtos
          </h2>
        </div>

        <div
          v-if="products.length"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          <div
            v-for="p in products"
            :key="p.id"
            class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition-all overflow-hidden group"
          >
          <div class="relative">
            <div class="h-48 bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center p-6 relative overflow-hidden">
              <img
                v-if="p.image_path"
                :src="`/storage/${p.image_path}`"
                class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300"
              />
              <span v-else class="text-gray-400 text-sm">
                Produto em breve
              </span>
            </div>
          </div>

          <div class="p-5">
            <div class="flex items-start justify-between mb-3">
              <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-800 mb-1">
                  {{ p.name }}
                </h3>
                <div class="flex items-center gap-1 text-orange-400">
                  <i class="bi bi-star-fill text-sm"></i>
                  <i class="bi bi-star-fill text-sm"></i>
                  <i class="bi bi-star-fill text-sm"></i>
                  <i class="bi bi-star-fill text-sm"></i>
                  <i class="bi bi-star-half text-sm"></i>
                </div>
              </div>
            </div>
            
            <div class="flex items-center justify-between">
              <div>
                <p class="text-2xl font-bold text-gray-800">
                  {{ formatCurrency(p.price) }}
                </p>
                <p v-if="p.min_price" class="text-sm text-gray-400 line-through">
                  {{ formatCurrency(p.min_price) }}
                </p>
              </div>
            </div>

            <div class="flex items-center justify-center gap-5">
              <button
                @click="comprarAgora(p.id)"
                class="w-full bg-orange-500 text-white py-2 rounded-xl hover:bg-orange-600 transition"
              >
                Comprar
              </button>
              <Link
                :href="`/cart/add/${p.id}`"
                method="post"
                as="button"
                preserve-scroll
                @success="router.reload({ only: ['cartCount'] })"
                class="hover:opacity-80 transition"
              >
                <i class="bi bi-cart-plus-fill text-3xl"></i>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- PLACEHOLDER -->
      <div
        v-else
        class="grid grid-cols-1 md:grid-cols-3 gap-6"
      >
        <div class="bg-white rounded-3xl shadow-sm p-6 text-center">
          <div class="h-48 bg-gray-100 rounded-2xl mb-4 flex items-center justify-center">
            <p class="text-gray-400">Produto em breve</p>
          </div>
          <p class="text-orange-600 font-bold mt-2">R$ 0,00</p>
        </div>
      </div>
    </section>

  </div>
</AppLayout>
</template>