<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button, buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import type { Product } from '@/types';


// Breadcrumbs no mesmo formato do professor
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '#',
    },
];


interface Props {
    products: Array<Product>;
    store_id: number;
}


defineProps<Props>();
</script>


<template>
    <Head title="Products" />


    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">




            <Link
                :href="`/products/create?store_id=${store_id}`"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Criar novo produto
            </Link>




            <div class="mt-6">
                <h2 class="mb-4 text-xl font-bold">Produtos da Loja</h2>


                <ul class="space-y-4">
                    <li
                        v-for="product in products"
                        :key="product.id"
                        class="rounded-lg border transition hover:shadow-md"
                    >
                        <div class="flex items-start justify-between">
                            <!-- Conteúdo -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">
                                    {{ product.name }}
                                </h3>


                                <Badge class="text-sm">
                                    R$ {{ product.price }}
                                </Badge>
                            </div>


                            <!-- Botões -->
                            <div class="flex mt-4 mr-4 space-x-2">


                                <!-- Editar Produto -->
                                <Link
                                    :href="`/products/${product.id}/edit?store_id=${store_id}`"
                                    class="flex w-32 cursor-pointer justify-center text-white"
                                    :class="buttonVariants({ variant: 'success' })"
                                >
                                    <div class="flex items-center">Editar</div>
                                </Link>


                                <!-- Excluir Produto -->
                                <Link
                                    :href="`/products/${product.id}/delete?store_id=${store_id}`"
                                    class="flex w-32 cursor-pointer justify-center text-white"
                                    :class="buttonVariants({ variant: 'destructive' })"
                                >
                                    <div class="flex items-center">Excluir</div>
                                </Link>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
