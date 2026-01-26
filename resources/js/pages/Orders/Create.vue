<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
  user: {
    name: string
    email: string
    phone_number: string
  }
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
            v-model="form.cpf"
            type="text"
            placeholder="Digite seu CPF"
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
