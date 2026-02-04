<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import type { BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lojas',
        href: '/stores',
    },
]

interface Store {
    id: number
    name: string
    image?: string | null
    is_open?: boolean
}

interface Props {
    stores: Store[]
}

defineProps<Props>()
</script>

<template>
    <Head title="Todas as lojas | Rango Fácil" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-gray-50">
            <!-- Header -->
            <section class="max-w-7xl mx-auto pt-8 pb-6 px-4 sm:px-6">
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-3xl p-12 shadow-lg relative overflow-hidden min-h-[280px] flex items-center">
                    <div class="relative z-10 max-w-2xl">
                        <h1 class="text-white text-5xl font-bold mb-3">
                            Todas as Lojas
                        </h1>
                        <p class="text-white/90 text-lg">
                            Explore todas as lojas parceiras do Rango Fácil.
                        </p>
                    </div>

                    <div class="absolute right-12 top-1/2 -translate-y-1/2 hidden lg:block">
                        <i class="bi bi-shop text-white/20 text-[200px]"></i>
                    </div>
                </div>
            </section>

            <!-- Listagem -->
            <section class="max-w-7xl mx-auto pb-16 px-4 sm:px-6">
                <div v-if="stores.length === 0" class="text-center py-20">
                    <i class="bi bi-shop text-gray-300 text-7xl mb-4 block"></i>
                    <p class="text-gray-500 text-lg">
                        Nenhuma loja encontrada
                    </p>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <Link
                        v-for="store in stores"
                        :key="store.id"
                        :href="`/stores/${store.id}`"
                        class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group relative"
                    >
                        <!-- Banner -->
                        <div class="relative h-44 overflow-hidden">
                            <div 
                                v-if="store.image"
                                class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-500"
                                :style="`background-image: url('/storage/${store.image}')`"
                            >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            </div>

                            <div 
                                v-else
                                class="absolute inset-0 bg-gradient-to-br from-orange-100 via-orange-50 to-orange-100 flex items-center justify-center"
                            >
                                <i class="bi bi-shop text-orange-300 text-6xl"></i>
                            </div>

                            <!-- Status -->
                            <div class="absolute top-3 right-3 z-10">
                                <span 
                                    v-if="store.is_open"
                                    class="bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg flex items-center gap-1"
                                >
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    Aberto
                                </span>
                                <span 
                                    v-else
                                    class="bg-gray-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg"
                                >
                                    Fechado
                                </span>
                            </div>
                        </div>

                        <!-- Conteúdo -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors">
                                {{ store.name }}
                            </h3>

                            <div class="mt-4 bg-orange-50 group-hover:bg-orange-500 rounded-xl py-2.5 flex items-center justify-center gap-2 transition-all duration-300">
                                <span class="text-orange-600 group-hover:text-white font-semibold text-sm">
                                    Ver cardápio
                                </span>
                                <i class="bi bi-arrow-right text-orange-600 group-hover:text-white transition-all"></i>
                            </div>
                        </div>
                    </Link>
                </div>
            </section>
        </div>
    </AppLayout>
</template>