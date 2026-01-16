<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
<div class="min-h-screen bg-gradient-to-b from-white via-white to-orange-200">
    <!-- Header -->
    <div class="bg-orange-500 border-b border-orange-500">
        <header class="flex justify-between items-center px-10 py-6">
            <div class="flex items-center gap-2">
            <img 
                src="/rangofacil.png" 
                class="h-11 cursor-pointer" 
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
    <section class="mt-10 px-10 flex items-center justify-between">
        <div class="max-w-xl">
            <h2 class="text-8xl font-bold mb-5">
            Seu rango <span class="text-[#4E342E]">sem</span> complicação!
            </h2>
            <p class="text-lg text-gray-800 mb-7 font-bold">
            Descubra refeições rápidas, acessíveis e perto de você.
            </p>
            <Link
            href="/register"
            class="inline-block bg-orange-500 text-white px-8 py-3 rounded text-lg text-bold hover:bg-orange-600 transition"
            >
            Começar agora
            </Link>
        </div>
        <div>
            <img 
            src="/coxinha.png" 
            class="h-130 -rotate-8 drop-shadow-xl select-none"
            alt="Imagem de uma coxinha"
            />
        </div>
    </section>
  </div>
</template>
