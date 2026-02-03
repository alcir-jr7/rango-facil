<script setup lang="ts">
import { create } from '@/actions/App/Http/Controllers/StoreController';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { toggleOpen } from '@/routes/stores';
import { Store, type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Stores',
        href: '#',
    },
];

interface Props {
    stores: Array<Store>;
}

defineProps<Props>();

// Função para excluir loja
const deleteStore = (storeId: number) => {
    if (confirm('Tem certeza que deseja excluir esta loja? Esta ação não pode ser desfeita.')) {
        router.delete(`/stores/${storeId}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Mensagem de sucesso será exibida via flash message
            },
        });
    }
};
</script>

<template>
    <Head title="Stores" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-orange-50/30">
            <section class="max-w-7xl mx-auto px-6 pt-8 pb-6">
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-3xl p-8 shadow-lg relative overflow-hidden">
                    <div class="z-10 relative">
                        <h1 class="text-white text-5xl font-bold mb-3">
                            Gerenciar Minhas Lojas
                        </h1>
                        <p class="text-white/90 text-lg mb-6 max-w-2xl">
                            Crie, edite e gerencie suas lojas. Controle o status de funcionamento e acompanhe seu negócio em tempo real.
                        </p>
                        <Link :href="create()">
                            <Button class="bg-white text-orange-500 hover:bg-orange-50 font-semibold px-6 py-3 rounded-xl shadow-md">
                                <i class="bi bi-plus-circle-fill mr-2"></i>
                                Criar Nova Loja
                            </Button>
                        </Link>
                    </div>
                    <div class="absolute right-8 top-1/2 -translate-y-1/2 hidden md:block">
                        <i class="bi bi-shop text-white/50 text-[160px]"></i>
                    </div>
                    <div class="absolute right-8 bottom-0 w-64 h-64 bg-orange-600/20 rounded-full blur-3xl"></div>
                </div>
            </section>

            <div class=" mt-10 mb-4 flex flex-col">
                <h1 class="text-3xl font-bold text-gray-800">Minhas Lojas</h1>
                <p class="text-gray-500">Gerencie suas lojas e produtos</p>
            </div>

            <!-- Lista de Lojas -->
            <div v-if="stores.length === 0" class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <p class="text-gray-500 text-lg mb-4">Você ainda não tem nenhuma loja</p>
                <Link :href="create()">
                    <Button class="bg-orange-500 hover:bg-orange-600">
                        Criar Primeira Loja
                    </Button>
                </Link>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="store in stores"
                    :key="store.id"
                    class="group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100"
                >
                    <!-- Botão de Excluir com ícone de lixeira -->
                    <button
                        @click="deleteStore(store.id)"
                        class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors shadow-md z-10"
                        title="Excluir loja"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                    <!-- Indicador de Status (movido para o lado esquerdo) -->
                    <div class="absolute top-4 left-4 z-10">
                        <div 
                            :class="[
                                'w-3 h-3 rounded-full shadow-lg',
                                store.is_open ? 'bg-green-500 animate-pulse' : 'bg-red-500'
                            ]"
                            :title="store.is_open ? 'Loja Aberta' : 'Loja Fechada'"
                        ></div>
                    </div>

                    <!-- Card Content -->
                    <Link
                        :href="`/stores/${store.id}`"
                        class="block p-6 hover:bg-gray-50 transition-colors"
                    >
                        <!-- Logo -->
                        <div class="flex justify-center mb-4">
                            <div class="relative">
                                <div class="h-24 w-24 rounded-full border-4 border-orange-500 overflow-hidden bg-white shadow-lg">
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
                        <h3 class="text-center text-xl font-bold text-gray-800 mb-2 group-hover:text-orange-500 transition-colors">
                            {{ store.name }}
                        </h3>

                        <!-- Stats -->
                        <div class="flex items-center justify-center gap-4 text-sm text-gray-500 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span>Produtos</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>4.9</span>
                            </div>
                        </div>
                    </Link>

                    <!-- Ações -->
                    <div class="px-6 pb-6 pt-2 border-t border-gray-100">
                        <div class="flex gap-2">
                            <!-- Botão Editar -->
                            <Link
                                :href="`/stores/${store.id}/edit`"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="text-sm font-medium">Editar</span>
                            </Link>

                            <!-- Botão Abrir/Fechar -->
                            <Link
                                :href="toggleOpen(store.id)"
                                method="post"
                                as="button"
                                preserve-scroll
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-all shadow-sm"
                                :class="store.is_open
                                    ? 'bg-red-500 hover:bg-red-600 text-white'
                                    : 'bg-green-500 hover:bg-green-600 text-white'"
                            >
                                <svg 
                                    v-if="store.is_open"
                                    class="w-4 h-4" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <svg 
                                    v-else
                                    class="w-4 h-4" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                
                                <span>{{ store.is_open ? 'Fechar' : 'Abrir' }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>