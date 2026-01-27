<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  payment_method: 'pix' | 'card'
  cpf: string
  total: number
}>()

const form = useForm({
  card_number: '',
  card_name: '',
  card_cvc: '',
  card_expiry: '',
})

const pixKey =
  '00020126580014BR.GOV.BCB.PIX0136123e4567-e89b-12d3-a456-426614174000520400005303986540'
const copied = ref(false)

function pagar() {
  form.post('/orders/pay')
}

function copiarPix() {
  navigator.clipboard.writeText(pixKey)
  copied.value = true
  setTimeout(() => (copied.value = false), 2000)
}

function formatCardNumber(e: Event) {
  const input = e.target as HTMLInputElement
  let value = input.value.replace(/\s/g, '')
  value = value.replace(/(\d{4})/g, '$1 ').trim()
  form.card_number = value
}

function formatExpiry(e: Event) {
  const input = e.target as HTMLInputElement
  let value = input.value.replace(/\D/g, '')
  if (value.length >= 2) {
    value = value.slice(0, 2) + '/' + value.slice(2, 4)
  }
  form.card_expiry = value
}

function formatCurrency(value: number) {
  return value.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
}
</script>

<template>
  <Head title="Pagamento" />

  <AppLayout>
    <div class="max-w-2xl mx-auto px-6 py-12">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Finalizar Pagamento</h1>
        <p class="text-gray-600 mt-2">Complete os dados para finalizar sua compra</p>
      </div>

      <!-- ================= PIX ================= -->
      <div
        v-if="payment_method === 'pix'"
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden"
      >
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
          <h2 class="text-xl font-semibold text-white">
            Pagamento via PIX
          </h2>
        </div>

        <div class="p-8">
          <div class="flex justify-between items-center mb-6 bg-gray-50 border rounded-lg p-4">
            <span class="text-sm text-gray-600">
              Total a pagar
            </span>
            <span class="text-lg font-bold text-gray-900">
              {{ formatCurrency(props.total) }}
            </span>
          </div>
          <div class="bg-orange-50 rounded-xl p-6 mb-6 text-center">
            <p class="text-sm text-orange-700 mb-4">
              Escaneie o QR Code com o app do seu banco
            </p>

            <img
              src="/qrcode.jpeg"
              alt="QR Code PIX"
              class="mx-auto w-64 h-64 object-contain"
            />
          </div>

          <div class="space-y-3">
            <button
              @click="copiarPix"
              type="button"
              class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 rounded-lg transition"
            >
              {{ copied ? 'Chave copiada!' : 'Copiar chave PIX' }}
            </button>

            <button
              @click="pagar"
              type="button"
              class="w-full bg-orange-100 hover:bg-orange-200 text-orange-700 font-medium py-3 rounded-lg transition"
            >
              Já realizei o pagamento
            </button>
          </div>

          <p class="text-xs text-gray-500 mt-4 text-center">
            Pagamento demonstrativo. Nenhuma cobrança real será feita.
          </p>
        </div>
      </div>

      <!-- ================= CARTÃO ================= -->
      <form
        v-else
        @submit.prevent="pagar"
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden"
      >
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
          <h2 class="text-xl font-semibold text-white">
            Pagamento com Cartão
          </h2>
        </div>

        <div class="p-8 space-y-5">
          <div class="flex justify-between items-center mb-6 bg-gray-50 border rounded-lg p-4">
            <span class="text-sm text-gray-600">
              Total a pagar
            </span>
            <span class="text-lg font-bold text-gray-900">
              {{ formatCurrency(props.total) }}
            </span>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Número do cartão
            </label>
            <input
              v-model="form.card_number"
              @input="formatCardNumber"
              placeholder="0000 0000 0000 0000"
              maxlength="19"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none transition"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nome no cartão
            </label>
            <input
              v-model="form.card_name"
              placeholder="Nome como está no cartão"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none uppercase transition"
              required
            />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Validade
              </label>
              <input
                v-model="form.card_expiry"
                @input="formatExpiry"
                placeholder="MM/AA"
                maxlength="5"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none transition"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                CVV
              </label>
              <input
                v-model="form.card_cvc"
                placeholder="123"
                maxlength="4"
                type="password"
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none transition"
                required
              />
            </div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-400 text-white font-medium py-3 rounded-lg transition mt-6"
          >
            {{ form.processing ? 'Processando...' : 'Confirmar Pagamento' }}
          </button>

          <p class="text-xs text-gray-500 text-center mt-4">
            Nenhum dado de cartão é armazenado. Pagamento apenas demonstrativo.
          </p>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
