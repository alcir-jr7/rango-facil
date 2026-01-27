<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
  user: {
    name: string
    email: string
    phone_number: string
  }
  total: number
}>()

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  phone_number: props.user.phone_number,
  cpf: '',
  payment_method: 'pix',
})

function submit() {
  form.post('/orders/checkout')
}

function formatCurrency(value: number) {
  return value.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  })
}

function maskCPF(e: Event) {
  const input = e.target as HTMLInputElement

  let value = input.value.replace(/\D/g, '')
  value = value.slice(0, 11)

  value = value.replace(/^(\d{3})(\d)/, '$1.$2')
  value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
  value = value.replace(
    /^(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})$/,
    '$1.$2.$3-$4'
  )
  input.value = value
  form.cpf = value
}
</script>

<template>
  <Head title="Finalizar pedido" />

  <AppLayout>
    <div class="max-w-3xl mx-auto px-6 py-10">
      <h1 class="text-2xl font-bold mb-6">
        Finalizar pedido
      </h1>

      <form
        @submit.prevent="submit"
        class="bg-white rounded-xl shadow p-6 space-y-5"
      >
        <!-- NOME -->
        <div>
          <label class="block text-sm font-medium">Nome</label>
          <input
            v-model="form.name"
            disabled
            class="w-full mt-1 rounded-lg border-gray-300 bg-gray-100"
          />
        </div>

        <!-- EMAIL -->
        <div>
          <label class="block text-sm font-medium">Email</label>
          <input
            v-model="form.email"
            disabled
            class="w-full mt-1 rounded-lg border-gray-300 bg-gray-100"
          />
        </div>

        <!-- TELEFONE -->
        <div>
          <label class="block text-sm font-medium">Telefone</label>
          <input
            v-model="form.phone_number"
            type="text"
            class="w-full mt-1 rounded-lg border-gray-300"
          />
        </div>

        <!-- CPF -->
        <div>
          <label class="block text-sm font-medium">CPF</label>
          <input
            type="text"
            placeholder="000.000.000-00"
            :value="form.cpf"
            @input="maskCPF"
            class="w-full mt-1 rounded-lg border-gray-300"
          />
          <span v-if="form.errors.cpf" class="text-sm text-red-500">
            {{ form.errors.cpf }}
          </span>
        </div>

        <!-- FORMA DE PAGAMENTO -->
        <div>
          <label class="block text-sm font-medium mb-2">
            Forma de pagamento
          </label>

          <div class="flex gap-6">
            <label class="flex items-center gap-2">
              <input
                type="radio"
                value="pix"
                v-model="form.payment_method"
              />
              PIX
            </label>

            <label class="flex items-center gap-2">
              <input
                type="radio"
                value="card"
                v-model="form.payment_method"
              />
              Cartão
            </label>
          </div>
        </div>
        <div class="flex justify-between items-center mb-6 bg-gray-50 border rounded-lg p-4">
          <span class="text-sm text-gray-600">
            Total a pagar
          </span>
          <span class="text-lg font-bold text-gray-900">
            {{ formatCurrency(props.total) }}
          </span>
        </div>
        <!-- BOTÕES -->
        <div class="flex justify-end gap-4 pt-4">
          <a
            href="/cart"
            class="px-5 py-2 rounded-lg border text-gray-700"
          >
            Voltar
          </a>

          <button
            type="submit"
            class="px-6 py-2 rounded-lg bg-orange-500 text-white
                   font-semibold hover:opacity-90 transition"
          >
            Continuar
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
