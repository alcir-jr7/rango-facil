<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

type Store = {
  id: number;
  name: string;
  is_open: boolean;
  description?: string;
};

const props = defineProps<{
  stores?: Store[];
}>();

// reativo baseado na prop (se enviada via Inertia)
const stores = ref<Store[]>(props.stores ?? []);

const loading = ref(false);
const error = ref<string | null>(null);
let intervalId: ReturnType<typeof setInterval> | null = null;

async function fetchStores() {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get('/api/stores/statuses');
    const payload = res.data?.data ?? [];

    const normalized: Store[] = payload.map((p: any) => {
      const isOpen =
        typeof p.is_open !== 'undefined'
          ? !!p.is_open
          : !!(p.status?.open ?? p.status?.is_open ?? false);

      return {
        id: p.id,
        name: p.name,
        is_open: isOpen,
        description: p.description ?? undefined,
      } as Store;
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
  fetchStores();
  intervalId = setInterval(fetchStores, 15000);
});

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId);
});

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

  <AppLayout :breadcrumbs="[{ title: 'Dashboard', href: '/' }]">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <!-- GRID PRINCIPAL: cada loja será um CARD quadrado separado -->
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <!-- loading placeholders -->
        <template v-if="loading">
          <div class="col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <PlaceholderPattern v-for="n in 6" :key="n" />
          </div>
        </template>

        <!-- erro geral -->
        <div v-else-if="error" class="col-span-3 text-rose-500">
          {{ error }}
        </div>

        <!-- sem lojas -->
        <div v-else-if="stores.length === 0" class="col-span-3 text-sm text-muted-foreground">
          Nenhuma loja cadastrada.
        </div>

        <!-- cada loja vira um card separado (quadrado) -->
        <template v-else>
          <div v-for="s in stores" :key="s.id" class="col-span-1">
            <div class="card-square rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card dark:bg-card-dark shadow-sm">
              <div class="card-inner p-4 flex flex-col justify-between">
                <div class="flex flex-col gap-2">
                  <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold truncate">{{ s.name }}</h3>
                    <span :class="badgeClasses(s.is_open)">
                      {{ s.is_open ? 'ABERTA' : 'FECHADA' }}
                    </span>
                  </div>

                  <p class="text-sm text-muted-foreground truncate">
                    {{ s.description ?? `ID: ${s.id}` }}
                  </p>
                </div>

                <!-- rodapé simples (sem botão Ver) -->
                <div class="text-xs text-muted-foreground text-right">ID: {{ s.id }}</div>
              </div>
            </div>
          </div>
        </template>
      </div>

      <!-- Linha abaixo com dois cards de controle (ex.: métricas) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <PlaceholderPattern />
        </div>

        <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
          <h3 class="text-lg font-semibold mb-3">Resumo</h3>

          <div v-if="stores.length === 0" class="text-sm text-muted-foreground">Sem dados</div>

          <div v-else class="grid grid-cols-2 gap-3">
            <div class="rounded-md border p-3">
              <div class="text-sm text-muted-foreground">Total de lojas</div>
              <div class="text-xl font-bold">{{ stores.length }}</div>
            </div>
            <div class="rounded-md border p-3">
              <div class="text-sm text-muted-foreground">Lojas abertas</div>
              <div class="text-xl font-bold">{{ stores.filter(s => s.is_open).length }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Área grande -->
      <div class="relative min-h-[60vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4">
        <PlaceholderPattern />
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* card-square cria um quadrado real sem depender do plugin aspect-ratio do Tailwind */
.card-square {
  position: relative;
  overflow: hidden;
}

/* cria o bloco quadrado baseado em padding-top:100% */
.card-square::before {
  content: "";
  display: block;
  padding-top: 100%;
}

/* conteúdo absoluto preenchendo o quadrado */
.card-inner {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

/* cores neutrais que seguem variáveis do tema (se quiser, ajuste em CSS global) */
.bg-card {
  background-color: var(--card, #ffffff);
}
.dark .bg-card {
  background-color: var(--card-dark, #0f1724);
}

/* trunca texto descritivo em 2 linhas (opcional) */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
