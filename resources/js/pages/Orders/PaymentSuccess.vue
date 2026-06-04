<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const props = defineProps<{
  isLocal: boolean
}>()

// Em produção com back_urls funcionando o pedido já foi criado.
// Em local, cria ao carregar a página automaticamente via fetch.
onMounted(async () => {
  if (props.isLocal) {
    try {
      await fetch('/pagamento/confirmar-local', { method: 'GET', redirect: 'manual' })
    } catch {}
  }
})
</script>

<template>
  <Head title="Pagamento Aprovado" />
  <AppLayout>
    <div class="min-h-[60vh] flex items-center justify-center px-6">
      <div class="max-w-md w-full text-center">

        <!-- Ícone de sucesso -->
        <div class="flex justify-center mb-6">
          <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          Pagamento aprovado!
        </h1>
        <p class="text-gray-500 mb-8">
          Seu pedido foi registrado com sucesso. Quando receber,
          confirme o recebimento e deixe sua avaliação.
        </p>

        <!-- CTA principal -->
        <Link
          href="/orders"
          class="block w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-6 rounded-2xl transition text-lg mb-3"
        >
          Ver meus pedidos
        </Link>

        <Link
          href="/dashboard"
          class="block w-full bg-white hover:bg-gray-50 text-gray-600 font-medium py-3 px-6 rounded-2xl border border-gray-200 transition"
        >
          Voltar ao início
        </Link>

      </div>
    </div>
  </AppLayout>
</template>