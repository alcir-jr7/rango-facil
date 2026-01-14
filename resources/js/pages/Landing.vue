<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="bg-white min-h-screen">
    <!-- Header -->
    <div class="bg-orange-500 border-b border-orange-500">
        <header class="flex justify-between items-center px-10 py-6">
            <div class="flex items-center gap-2">

            <img 
                src="/rangofacil.png" 
                class="h-8 cursor-pointer" 
                alt="Logo RangoFácil"
            />

            <h1 class="text-white font-bold text-lg">
                RangoFácil
            </h1>
        </div>
        <div class="space-x-4">
            <Link href="/login" class="text-white font-bold">Entrar</Link>
            <Link href="/register" class="bg-white text-orange-500 font-bold px-4 py-2 rounded">
            Cadastrar
            </Link>
        </div>
        </header>
    </div>
    <!-- Hero -->
    <section class="text-center mt-20">
      <h2 class="text-4xl font-bold mb-4">
        Seu rango, sem complicação
      </h2>
      <p class="text-lg text-gray-600 mb-6">
        Descubra refeições rápidas, acessíveis e perto de você.
      </p>
      <Link
        href="/register"
        class="bg-orange-500 text-white px-8 py-3 rounded text-lg"
      >
        Começar agora
      </Link>
    </section>
  </div>
</template>
