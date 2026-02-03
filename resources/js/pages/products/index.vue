<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import type { BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Produtos',
        href: '/products',
    },
]

interface Store {
    id: number
    name: string
}

interface Product {
    id: number
    name: string
    description?: string
    image_path?: string | null
    price: number
    min_price?: number | null
    store: Store
}

interface Props {
    products: Product[]
    store_id?: number | null
    showAll: boolean
}

defineProps<Props>()

const formatCurrency = (value: number) => {
    return value.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    })
}

const comprarAgora = (productId: number) => {
    router.post(`/cart/add/${productId}`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            router.visit('/cart')
        },
    })
}
</script>

<template>
    <Head title="Produtos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen">
            <section class="max-w-7xl mx-auto pt-8 pb-6">
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-3xl p-12 shadow-lg relative overflow-hidden min-h-[280px] flex items-center">
                    <div class="relative z-10 max-w-2xl">
                        <h1 class="text-white text-5xl font-bold mb-3">
                            {{ showAll ? 'Todos os Produtos' : 'Produtos da Loja' }}
                        </h1>
                        <p class="text-white/90 text-lg mb-6 max-w-2xl">
                            Explore todos os produtos disponíveis no sistema e encontre o que você procura.
                        </p>
                    </div>

                    <div class="absolute right-12 top-1/2 -translate-y-1/2 hidden lg:block">
                        <i class="bi bi-bag text-white/20 text-[200px]"></i>
                    </div>

                    <div class="absolute right-20 bottom-0 w-64 h-64 bg-orange-600/20 rounded-full blur-3xl"></div>
                </div>
            </section>

            <section class="max-w-7xl mx-auto pb-16">
                <div v-if="products.length === 0" class="text-center py-20">
                    <i class="bi bi-box-seam text-gray-300 text-7xl mb-4 block"></i>
                    <p class="text-gray-500 text-lg">
                        Nenhum produto encontrado
                    </p>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition-all overflow-hidden group"
                    >
                        <div class="relative">
                            <div class="h-48 bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center p-6 relative overflow-hidden">
                                <img
                                    v-if="product.image_path"
                                    :src="`/storage/${product.image_path}`"
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
                                        {{ product.name }}
                                    </h3>

                                    <!-- Info da Loja (se showAll) -->
                                    <p
                                        v-if="showAll"
                                        class="text-xs text-gray-500 mb-2 flex items-center gap-1"
                                    >
                                        <i class="bi bi-shop text-orange-500"></i>
                                        <Link
                                            :href="`/stores/${product.store.id}`"
                                            class="font-medium hover:text-orange-600 transition"
                                        >
                                            {{ product.store.name }}
                                        </Link>
                                    </p>

                                    <div class="flex items-center gap-1 text-orange-400">
                                        <i class="bi bi-star-fill text-sm"></i>
                                        <i class="bi bi-star-fill text-sm"></i>
                                        <i class="bi bi-star-fill text-sm"></i>
                                        <i class="bi bi-star-fill text-sm"></i>
                                        <i class="bi bi-star-half text-sm"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-2xl font-bold text-gray-800">
                                        {{ formatCurrency(product.price) }}
                                    </p>
                                    <p v-if="product.min_price" class="text-sm text-gray-400 line-through">
                                        {{ formatCurrency(product.min_price) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <button
                                    @click="comprarAgora(product.id)"
                                    class="flex-1 bg-orange-500 text-white py-2 rounded-xl hover:bg-orange-600 transition"
                                >
                                    Comprar
                                </button>
                                <Link
                                    :href="`/cart/add/${product.id}`"
                                    method="post"
                                    as="button"
                                    preserve-scroll
                                    @success="router.reload({ only: ['cartCount'] })"
                                    class="hover:opacity-80 transition"
                                >
                                    <i class="bi bi-cart-plus-fill text-3xl text-orange-500"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>