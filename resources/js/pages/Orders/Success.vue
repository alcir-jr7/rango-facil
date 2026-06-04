<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Pedido Realizado" />
  <AppLayout>
    <div class="max-w-lg mx-auto px-6 py-16 text-center">
      <div class="text-7xl mb-6">🎉</div>
      <h1 class="text-3xl font-bold text-gray-900 mb-3">Pedido realizado!</h1>
      <p class="text-gray-500 mb-8">
        Seu pagamento foi processado. Acompanhe o status do pedido e confirme o
        recebimento quando ele chegar.
      </p>
      <Link
        href="/orders"
        class="bg-orange-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition inline-block"
      >
        Ver meus pedidos
      </Link>
    </div>
  </AppLayout>
</template>
