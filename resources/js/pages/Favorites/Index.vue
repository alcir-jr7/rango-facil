<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

type Store = {
    id: number;
    name: string;
    is_open: boolean;
    image?: string | null;
};

const page = usePage();

/**
 * Espera receber do backend:
 * favorites: Store[]
 */
const initialFavorites = (page.props.favorites as Store[]) || [];
const removedIds = ref<number[]>([]);

// Filtra os favoritos removendo os IDs que foram clicados
const favorites = computed(() => {
    return initialFavorites.filter(store => !removedIds.value.includes(store.id));
});

// Função para remover dos favoritos
const unfavorite = (storeId: number) => {
    // Remove imediatamente da UI
    removedIds.value.push(storeId);
    
    // Faz a requisição no backend
    router.delete(`/stores/${storeId}/favorite`, {
        preserveScroll: true,
        onError: () => {
            // Se der erro, volta o item
            removedIds.value = removedIds.value.filter(id => id !== storeId);
        }
    });
};
</script>

<template>
    <Head title="Favoritos" />

    <AppLayout>
        <div class="min-h-screen bg-gradient-to-br from-orange-50 to-white p-6">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Lojas Favoritas</h1>
                        <p class="text-gray-500 mt-1">{{ favorites.length }} {{ favorites.length === 1 ? 'loja favorita' : 'lojas favoritas' }}</p>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="favorites.length === 0" class="text-center py-16">
                    <p class="text-gray-500 text-lg">Você ainda não tem lojas favoritas</p>
            </div>

            <!-- Grid de Lojas Favoritas -->
            <div
                v-else
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
            >
                <div
                    v-for="store in favorites"
                    :key="store.id"
                    class="group relative bg-white rounded-2xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-1"
                >
                    <!-- Botão Favorito (canto superior esquerdo) -->
                    <button
                        @click.prevent.stop="unfavorite(store.id)"
                        class="absolute top-3 left-3 z-10 transition-transform hover:scale-110"
                        title="Remover dos favoritos"
                    >
                        <i class="bi bi-star-fill text-orange-500 text-xl drop-shadow-md"></i>
                    </button>

                    <!-- Indicador de Status -->
                    <div class="absolute top-4 right-4 z-10">
                        <div 
                            :class="[
                                'w-3 h-3 rounded-full shadow-lg',
                                store.is_open ? 'bg-green-500 animate-pulse' : 'bg-red-500'
                            ]"
                            :title="store.is_open ? 'Loja Aberta' : 'Loja Fechada'"
                        ></div>
                    </div>

                    <!-- Card Content (clicável) -->
                    <Link
                        :href="`/stores/${store.id}`"
                        class="block"
                    >
                        <!-- Logo -->
                        <div class="flex justify-center mb-4">
                            <div class="relative">
                                <div class="h-24 w-24 rounded-full border-4 border-orange-500 overflow-hidden bg-white shadow-lg group-hover:border-orange-600 transition-colors">
                                    <img
                                        v-if="store.image"
                                        :src="`/storage/${store.image}`"
                                        :alt="store.name"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full w-full items-center justify-center bg-gradient-to-br from-orange-100 to-orange-200 text-3xl font-bold text-orange-500"
                                    >
                                        {{ store.name.charAt(0).toUpperCase() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nome da Loja -->
                        <h3 class="text-center text-lg font-bold text-gray-800 group-hover:text-orange-500 transition-colors line-clamp-2">
                            {{ store.name }}
                        </h3>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>