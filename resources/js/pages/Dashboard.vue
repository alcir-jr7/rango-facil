<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

type Store = {
  id: number;
  name: string;
  is_open: boolean;
  image?: string | null;
};

const props = defineProps<{
  stores: Store[];
}>();

const stores = props.stores;
const carouselRef = ref<HTMLElement | null>(null);
const isPaused = ref(false);
let scrollInterval: number | null = null;

const startAutoScroll = () => {

  scrollInterval = window.setInterval(() => {
    if (!isPaused.value && carouselRef.value) {
      const container = carouselRef.value;
      const maxScroll = container.scrollWidth - container.clientWidth;
    }
  }, 20);

};

const stopAutoScroll = () => {
  if (scrollInterval) {
    clearInterval(scrollInterval);
    scrollInterval = null;
  }
};

const handleMouseEnter = () => {
  isPaused.value = true;
};

const handleMouseLeave = () => {
  isPaused.value = false;
};

onMounted(() => {
  startAutoScroll();
});

onUnmounted(() => {
  stopAutoScroll();
});
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="[{ title: 'Rango Fácil', href: '/' }]">
    <div class="">
      
      <!-- Seção de Lojas -->
      <div class="py-8 px-4" style="background-color: rgba(255,255,255,255);">
        <div class="max-w-full mx-auto overflow-hidden">
          <div 
            ref="carouselRef"
            @mouseenter="handleMouseEnter"
            @mouseleave="handleMouseLeave"
            class="flex gap-8 overflow-x-auto pb-4 px-4 custom-scrollbar"
          >
            
            <template v-if="stores.length > 0">
              <!-- Duplicar as lojas para efeito infinito -->
              <template v-for="_ in 1" :key="_">
                <div
                  v-for="s in stores"
                  :key="`${s.id}-${_}`"
                  class="flex flex-col items-center flex-shrink-0"
                >
                  <!-- Logo circular da loja -->
                  <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-white shadow-lg border-4 border-orange-400 overflow-hidden flex items-center justify-center">
                      <img
                        v-if="s.image"
                        :src="`/storage/${s.image}`"
                        :alt="s.name"
                        class="w-full h-full object-cover"
                      />
                      <div v-else class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <span class="text-white text-3xl font-bold">{{ s.name.charAt(0) }}</span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Nome e status -->
                  <div class="flex items-center gap-2 mt-3">
                    <h3 class="text-base font-semibold text-gray-800">{{ s.name }}</h3>
                    <span 
                      :class="s.is_open ? 'text-green-600' : 'text-red-600'"
                      class="text-xl font-bold"
                    >
                      {{ s.is_open ? '✓' : '✗' }}
                    </span>
                  </div>
                </div>
              </template>
            </template>

            <div
              v-else
              class="text-center text-gray-600 py-8 w-full"
            >
              Nenhuma loja cadastrada.
            </div>

          </div>
        </div>
      </div>

              <!-- Grade de Produtos (placeholder) -->
          <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              
              <!-- Card estilo protótipo -->
              <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                
                <!-- Imagem -->
                <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                  <span class="text-gray-400 text-sm">Produto em breve</span>
                </div>

                <!-- Conteúdo -->
                <div class="p-4">
                  <p class="text-lg font-bold text-orange-600">R$ 0,00</p>
                  <p class="text-sm text-gray-700 mb-4">Nome do produto</p>

                  <button class="w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold py-2 rounded-lg transition">
                    Comprar
                  </button>
                </div>

              </div>

            </div>
          </div>

    


    </div>
  </AppLayout>
</template>

<style scoped>
/* Animações suaves */
.transform {
  transition: transform 0.2s ease-in-out;
}

/* Scrollbar customizada */
.custom-scrollbar {
  scroll-behavior: smooth;
}

.custom-scrollbar::-webkit-scrollbar {
  height: 12px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 243, 224, 0.5);
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: linear-gradient(to right, #fb923c, #f97316);
  border-radius: 10px;
  border: 2px solid rgba(255, 243, 224, 0.5);
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to right, #f97316, #ea580c);
}

/* Firefox */
.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #fb923c rgba(255, 243, 224, 0.5);
}
</style>