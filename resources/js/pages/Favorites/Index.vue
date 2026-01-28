<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';

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
const favorites = (page.props.favorites as Store[]) || [];
</script>

<template>
    <Head title="Favoritos" />

    <AppLayout>
        <div class="px-4 py-6">
            <h1 class="text-2xl font-bold text-orange-600 mb-6">
                ⭐ Lojas Favoritas
            </h1>

            <div v-if="favorites.length === 0" class="text-gray-500">
                Você ainda não favoritou nenhuma loja.
            </div>

            <div
                v-else
                class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6"
            >
                <Link
                    v-for="store in favorites"
                    :key="store.id"
                    :href="`/stores/${store.id}`"
                    class="flex flex-col items-center text-center hover:opacity-80 transition"
                >
                    <!-- Logo -->
                    <div class="w-32 h-32 rounded-full border-4 border-orange-400 overflow-hidden bg-white shadow">
                        <img
                            v-if="store.image"
                            :src="`/storage/${store.image}`"
                            class="w-full h-full object-cover"
                        />
                        <div
                            v-else
                            class="w-full h-full bg-orange-400 flex items-center justify-center text-white text-2xl font-bold"
                        >
                            {{ store.name.charAt(0) }}
                        </div>
                    </div>

                    <!-- Nome -->
                    <span class="mt-2 font-medium">
                        {{ store.name }}
                    </span>

                    <!-- Status -->
                    <span
                        :class="store.is_open ? 'text-green-600' : 'text-red-600'"
                        class="text-sm"
                    >
                        {{ store.is_open ? 'Aberta' : 'Fechada' }}
                    </span>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
