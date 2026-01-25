<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Confirmar Pedido" />

  <AppLayout>
    <div class="max-w-4xl mx-auto px-6 py-12">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          Confirmar Pedido
        </h1>
        <p class="text-gray-600">
          Revise as informações antes de finalizar
        </p>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">
            Resumo do Pedido
          </h2>
        </div>

        <!-- Content -->
        <div class="px-6 py-8 space-y-6">
          <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-medium text-gray-900 mb-1">
                Pronto para finalizar?
              </h3>
              <p class="text-gray-600 leading-relaxed">
                Ao confirmar, seu pedido será processado com todos os itens atualmente no carrinho. 
                Você receberá uma confirmação por e-mail com os detalhes da sua compra.
              </p>
            </div>
          </div>

          <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-sm font-medium text-amber-900 mb-1">
                Importante
              </p>
              <p class="text-sm text-amber-800">
                Após a confirmação, o carrinho será esvaziado automaticamente e não será possível desfazer esta ação.
              </p>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
          <Link
            href="/cart"
            class="px-6 py-2.5 rounded-lg border border-gray-300
                   text-gray-700 font-medium hover:bg-white hover:border-gray-400 
                   transition-all duration-200 focus:outline-none focus:ring-2 
                   focus:ring-gray-400 focus:ring-offset-2"
          >
            ← Voltar ao Carrinho
          </Link>

          <Link
            href="/orders"
            method="post"
            as="button"
            class="px-8 py-2.5 rounded-lg bg-green-600 text-white
                   font-semibold hover:bg-green-700 shadow-sm hover:shadow
                   transition-all duration-200 focus:outline-none focus:ring-2 
                   focus:ring-green-500 focus:ring-offset-2"
          >
            Confirmar Pedido
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>