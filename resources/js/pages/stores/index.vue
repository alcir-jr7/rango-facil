<script setup lang="ts">
import { create } from '@/actions/App/Http/Controllers/StoreController';
import { Badge } from '@/components/ui/badge';
import { Button, buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { toggleOpen } from '@/routes/stores';
import { Store, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

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
</script>

<template>
    <Head title="Stores" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <Link :href="create()">
                <Button class="cursor-pointer">Criar nova loja</Button>
            </Link>

            <div class="mt-6">
                <h2 class="mb-4 text-xl font-bold">Minhas Lojas</h2>

                <ul class="space-y-4">
                    <li
                        v-for="store in stores"
                        :key="store.id"
                        class="rounded-lg border transition hover:shadow-md"
                    >
                        <div class="flex items-center justify-between p-4">
                            <!-- Logo + Nome (LINK PARA SHOW) -->
                            <Link
                                :href="`/stores/${store.id}`"
                                class="flex items-center gap-4 hover:opacity-80"
                            >
                                <!-- Logo -->
                                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full border">
                                    <img
                                        v-if="store.image"
                                        :src="`/storage/${store.image}`"
                                        alt="Logo da loja"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full w-full items-center justify-center bg-gray-200 text-xs text-gray-500"
                                    >
                                        Sem logo
                                    </div>
                                </div>

                                <!-- Nome -->
                                <div class="flex flex-col">
                                    <span class="text-base font-semibold">
                                        {{ store.name }}
                                    </span>
                                </div>
                            </Link>
                            <!-- Status + Ações -->
                            <div class="flex items-center gap-4">
                                <Badge
                                    class="text-sm"
                                    :class="
                                        store.is_open
                                            ? 'text-success'
                                            : 'text-destructive'
                                    "
                                >
                                    {{ store.is_open ? 'Aberta' : 'Fechada' }}
                                </Badge>

                                <Link
                                    :href="toggleOpen(store.id)"
                                    class="flex w-32 justify-center text-white"
                                    :class="store.is_open
                                        ? buttonVariants({ variant: 'destructive' })
                                        : buttonVariants({ variant: 'success' })"
                                >
                                    {{ store.is_open ? 'Fechar Loja' : 'Abrir Loja' }}
                                </Link>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
