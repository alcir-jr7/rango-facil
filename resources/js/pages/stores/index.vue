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
                        <div class="flex items-start justify-between">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">
                                    {{ store.name }}
                                </h3>
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
                            </div>

                            <Link
                                :href="toggleOpen(store.id)"
                                class="mt-4 mr-4 flex w-32 cursor-pointer justify-center text-white"
                                :class="
                                    store.is_open
                                        ? buttonVariants({
                                              variant: 'destructive',
                                          })
                                        : buttonVariants({ variant: 'success' })
                                "
                            >
                                <div class="flex items-center">
                                    {{
                                        store.is_open
                                            ? 'Fechar Loja'
                                            : 'Abrir Loja'
                                    }}
                                </div>
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
