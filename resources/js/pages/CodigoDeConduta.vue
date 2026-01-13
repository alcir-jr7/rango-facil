<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

</script>

<template>
  <AppLayout>
    <Head title="Código de Conduta" />

    <main class="p-64 mx-auto text-black">
      <h1 class="text-3xl font-bold mb-6">Código de Conduta</h1>

      <p class="mb-4">
        O RangoFácil preza por um ambiente respeitoso, colaborativo e seguro para todos os usuários.
      </p>

      <ul class="list-disc list-inside mb-4">
        <li>Respeitar todos os membros da comunidade acadêmica.</li>
        <li>Não publicar conteúdos ofensivos ou enganosos.</li>
        <li>Utilizar a plataforma apenas para fins legítimos.</li>
      </ul>

      <p>
        O descumprimento dessas diretrizes pode resultar em sanções ou suspensão do acesso à plataforma.
      </p>
    </main>
  </AppLayout>
</template>
