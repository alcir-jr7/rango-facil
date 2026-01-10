<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { ref } from 'vue'

interface Product {
  id: number
  name: string
  description?: string
  price: number | string
  min_price?: number | string
  image?: string
  image_path?: string
  is_popular?: boolean
}

interface Store {
  id: number
  name: string
  image?: string
  is_open: boolean
  auto_confirm_orders?: boolean
  owner_id: number
  followers_count?: number
  following_count?: number
  products_count?: number
  rating?: number
  opened_at?: string
  products?: Product[]
}

const props = defineProps<{
  store: Store
  products?: Product[]
  authUserId?: number | null
}>()

const activeTab = ref<'home' | 'myStores' | 'dashboard'>('home')

const isOwner = props.authUserId === props.store.owner_id

const allProducts = props.products || props.store.products || []
const popularProducts = allProducts.filter(p => p.is_popular)

const formatDate = (date?: string) => {
  if (!date) return 'Não informado'
  return new Date(date).toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

const deleteProduct = (productId: number) => {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    router.delete(`/products/${productId}`, {
      preserveScroll: true,
      preserveState: false,
      onSuccess: () => {
        // Produto excluído com sucesso - permanece na mesma página
      }
    })
  }
}

const getImagePath = (product: Product) => {
  const imagePath = product.image || product.image_path
  if (!imagePath) return null
  return imagePath.startsWith('http') ? imagePath : `/storage/${imagePath}`
}
</script>

<template>
  <AppLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Header da Loja -->
      <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-6">
          <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
            <!-- Logo da Loja -->
            <div class="relative">
              <div class="w-32 h-32 rounded-full border-4 border-orange-500 overflow-hidden bg-white shadow-lg">
                <img
                  v-if="store.image"
                  :src="`/storage/${store.image}`"
                  :alt="store.name"
                  class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-4xl font-bold text-orange-500">
                  {{ store.name.charAt(0).toUpperCase() }}
                </div>
              </div>
            </div>

            <!-- Informações da Loja -->
            <div class="flex-1">
              <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ store.name }}</h1>

              <!-- Stats Grid -->
              <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                <!-- Produtos -->
                <div class="flex items-center gap-2">
                  <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                  <div>
                    <p class="text-sm text-gray-500">Produtos:</p>
                    <p class="font-semibold text-orange-500">{{ allProducts.length || 0 }}</p>
                  </div>
                </div>

                <!-- Avaliação -->
                <div class="flex items-center gap-2">
                  <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <div>
                    <p class="text-sm text-gray-500">Avaliação:</p>
                    <p class="font-semibold text-orange-500">{{ store.rating || '4.9' }}</p>
                  </div>
                </div>
              </div>

              <!-- Aberto desde -->
              <div class="flex items-center gap-2 mt-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-gray-600">
                  Aberto desde: <span class="text-orange-500 font-semibold">{{ formatDate(store.opened_at) }}</span>
                </p>
              </div>
            </div>

            <!-- Botões de Ação (só para o dono) -->
            <div v-if="isOwner" class="flex flex-col gap-2">
              <Link :href="`/stores/${store.id}/edit`">
                <Button variant="outline" class="w-full">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Editar Loja
                </Button>
              </Link>
              
              <Link :href="`/products/create?store_id=${store.id}`">
                <Button class="w-full bg-orange-500 hover:bg-orange-600">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Adicionar Produto
                </Button>
              </Link>

              <Link :href="`/stores/${store.id}/toggle-open`" method="post" as="button">
                <Button 
                  :variant="store.is_open ? 'destructive' : 'success'" 
                  class="w-full"
                >
                  {{ store.is_open ? 'Fechar Loja' : 'Abrir Loja' }}
                </Button>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs de Navegação -->
      <div class="bg-white border-b">
        <div class="container mx-auto px-4">
          <div class="flex gap-8">
            <button
              @click="activeTab = 'home'"
              :class="[
                'py-4 border-b-2 font-medium transition-colors',
                activeTab === 'home' 
                  ? 'border-orange-500 text-orange-500' 
                  : 'border-transparent text-gray-500 hover:text-gray-700'
              ]"
            >
              Meus produtos
            </button>
          </div>
        </div>
      </div>

      <!-- Conteúdo -->
      <div class="container mx-auto px-4 py-8">
        <!-- Produtos Populares -->
        <div v-if="popularProducts.length > 0" class="mb-12">
          <div class="flex items-center gap-2 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Populares</h2>
            <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>

          <div class="flex gap-4 overflow-x-auto pb-4">
            <div
              v-for="product in popularProducts"
              :key="product.id"
              class="flex-shrink-0 w-64"
            >
              <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 overflow-hidden">
                  <img
                    v-if="getImagePath(product)"
                    :src="getImagePath(product)!"
                    :alt="product.name"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Meus Produtos -->
        <div>
          <h2 class="text-2xl font-bold text-gray-800 mb-6">Meus Produtos</h2>

          <div v-if="allProducts.length === 0" class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-gray-500 text-lg mb-4">Nenhum produto cadastrado ainda</p>
            <Link v-if="isOwner" :href="`/products/create?store_id=${store.id}`">
              <Button class="bg-orange-500 hover:bg-orange-600">
                Adicionar Primeiro Produto
              </Button>
            </Link>
          </div>

          <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="product in allProducts"
              :key="product.id"
              class="bg-orange-500 text-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition relative"
            >
              <!-- Botão de Excluir com ícone de lixeira (só para o dono) -->
              <button
                v-if="isOwner"
                @click="deleteProduct(product.id)"
                class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors shadow-md z-10"
                title="Excluir produto"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>

              <!-- Imagem do Produto -->
              <div class="h-38 bg-white rounded-xl overflow-hidden m-2 flex items-center justify-center">
                <img
                  v-if="getImagePath(product)"
                  :src="getImagePath(product)!"
                  :alt="product.name"
                  class="w-full h-full object-cover"
                  @error="(e) => {
                    const target = e.target as HTMLImageElement;
                    target.style.display = 'none';
                  }"
                />
                <span v-else class="text-gray-400">
                  Produto em breve
                </span>
              </div>

              <div class="p-2">
                <!-- Nome do Produto -->
                <p class="text-xl text-white font-black flex items-center justify-center mb-2">
                  {{ product.name }}
                </p>

                <!-- Preço -->
                <p class="text-lg text-white flex items-center justify-center mb-3">
                  R$ {{ typeof product.price === 'number' ? product.price.toFixed(2).replace('.', ',') : product.price }}
                </p>

                <!-- Preço Mínimo (se existir) -->
                <p
                  v-if="product.min_price"
                  class="text-sm text-white mb-3 text-center"
                >
                  A partir de R$ {{ typeof product.min_price === 'number' ? product.min_price.toFixed(2).replace('.', ',') : product.min_price }}
                </p>

                <!-- Botões de Ação -->
                <div class="flex items-center justify-center gap-3">
                  <!-- Para o dono -->
                  <template v-if="isOwner">
                    <Link :href="`/products/${product.id}/edit`" class="flex-1">
                      <button class="w-full bg-white text-orange-500 py-2 rounded-xl hover:opacity-80 transition font-semibold">
                        Editar
                      </button>
                    </Link>
                  </template>

                  <!-- Para visitantes -->
                  <template v-else>
                    <button class="w-full bg-white text-orange-500 py-2 rounded-xl hover:opacity-80 transition font-semibold">
                      Comprar
                    </button>
                    <a href="#" class="hover:opacity-80 transition">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                      </svg>
                    </a>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Scroll horizontal suave */
.overflow-x-auto {
  scrollbar-width: thin;
  scrollbar-color: #fb923c #f3f4f6;
}

.overflow-x-auto::-webkit-scrollbar {
  height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f3f4f6;
  border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #fb923c;
  border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #f97316;
}
</style>