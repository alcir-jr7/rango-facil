<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// pega a prop enviada pelo Inertia/Laravel (você declarou "store" no exemplo)
type Store = {
    id: number;
    name: string;
    is_open: boolean;
};

const props = defineProps<{
    stores?: Store[];
}>();

// cria um ref reativo baseado na prop (a prop é readonly)
const stores = ref<Store[]>(props.stores ?? []);

// loading / error para o polling
const loading = ref(false);
const error = ref<string | null>(null);

let intervalId: ReturnType<typeof setInterval> | null = null;

/**
 * Busca as lojas do backend.
 * Endpoint sugerido: GET /api/stores/statuses
 * (se preferir outro endpoint, altere a URL abaixo)
 */
async function fetchStores() {
    loading.value = true;
    error.value = null;
    try {
        const res = await axios.get('/api/stores/statuses');
        // espera { data: [ { id, name, status: { open/... } } ] } como anteriormente sugerido
        // mas também aceitamos { data: [ { id, name, is_open } ] } para compatibilidade
        const payload = res.data?.data ?? [];

        // normalize payload para o formato { id, name, is_open }
        const normalized = payload.map((p: any) => {
            // se backend usar status.open (objeto), converte para is_open
            const isOpen =
                typeof p.is_open !== 'undefined'
                    ? !!p.is_open
                    : !!(p.status?.open ?? p.status?.is_open ?? false);

            return {
                id: p.id,
                name: p.name,
                is_open: isOpen,
            };
        });

        stores.value = normalized;
    } catch (err: any) {
        console.error('Erro ao buscar lojas', err);
        error.value = err?.response?.data?.message ?? 'Erro ao buscar lojas';
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    // inicia polling a cada 15s (ajuste se quiser 30s)
    fetchStores();
    intervalId = setInterval(fetchStores, 15000);
});

onUnmounted(() => {
    if (intervalId) clearInterval(intervalId);
});

/** classes para badge ABERTA/FECHADA */
function badgeClasses(isOpen: boolean) {
    return [
        'inline-flex',
        'items-center',
        'px-3',
        'py-1',
        'rounded-full',
        'text-sm',
        'font-semibold',
        isOpen ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white',
        'shadow-sm',
    ].join(' ');
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <!-- Card: Lista de lojas -->
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4"
                >
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold">Lojas</h3>
                        <div class="flex items-center gap-2">
                            <button
                                @click="fetchStores"
                                class="text-sm px-3 py-1 rounded bg-slate-100 dark:bg-slate-800"
                                type="button"
                            >
                                Atualizar
                            </button>
                        </div>
                    </div>

                    <div v-if="loading" class="space-y-3">
                        <PlaceholderPattern />
                        <PlaceholderPattern />
                        <PlaceholderPattern />
                    </div>

                    <div v-else>
                        <div v-if="error" class="text-rose-500 mb-3">{{ error }}</div>

                        <div v-if="stores.length === 0" class="text-sm text-muted-foreground">
                            Nenhuma loja cadastrada.
                        </div>

                        <div v-else class="space-y-3">
                            <div
                                v-for="s in stores"
                                :key="s.id"
                                class="flex items-center justify-between gap-3 rounded-md border p-3"
                            >
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm font-medium truncate">{{ s.name }}</div>
                                        <span :class="badgeClasses(s.is_open)">{{ s.is_open ? 'ABERTA' : 'FECHADA' }}</span>
                                    </div>
                                </div>
                                <div class="text-xs text-muted-foreground text-right">
                                    <!-- Se quiser mostrar info extra, coloque aqui -->
                                    <div>ID: {{ s.id }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: mantém placeholder pattern (você pode substituir por métricas) -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>

                <!-- Card 3: resumo simples -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4"
                >
                    <h3 class="text-lg font-semibold mb-3">Resumo</h3>
                    <div v-if="stores.length === 0" class="text-sm text-muted-foreground">Sem dados</div>
                    <div v-else class="grid grid-cols-2 gap-3">
                        <div class="rounded-md border p-3">
                            <div class="text-sm text-muted-foreground">Total de lojas</div>
                            <div class="text-xl font-bold">{{ stores.length }}</div>
                        </div>
                        <div class="rounded-md border p-3">
                            <div class="text-sm text-muted-foreground">Lojas abertas</div>
                            <div class="text-xl font-bold">
                                {{ stores.filter(s => s.is_open).length }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área grande abaixo: mantive PlaceholderPattern enquanto não tiver algo específico -->
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4"
            >
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
