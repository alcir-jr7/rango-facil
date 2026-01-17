<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="RangoFácil" />

  <div class="min-h-screen bg-gradient-to-b from-white via-white to-orange-200">
    <!-- ================= HEADER ================= -->
    <div class="bg-orange-500 border-b border-orange-500">
      <header
        class="flex items-center justify-between
               px-6 md:px-10
               py-4 md:py-6"
      >
        <div class="flex items-center gap-2">
          <img
            src="/rangofacil.png"
            class="h-9 md:h-11 cursor-pointer"
            alt="Logo RangoFácil"
          />
          <h1 class="text-white font-bold text-base md:text-lg">
            RangoFácil
          </h1>
        </div>

        <div class="flex items-center gap-4">
          <Link
            href="/login"
            class="text-white font-bold text-sm md:text-base"
          >
            Entrar
          </Link>

          <Link
            href="/register"
            class="bg-white text-orange-500
                   font-bold
                   px-3 md:px-4
                   py-2
                   rounded
                   text-sm md:text-base"
          >
            Cadastrar
          </Link>
        </div>
      </header>
    </div>

    <!-- ================= HERO ================= -->
    <section
      class="mt-10
             px-6 md:px-10
             flex flex-col md:flex-row
             items-center justify-between
             gap-12"
    >
      <!-- TEXTO -->
      <div
        class="max-w-xl
               text-center md:text-left
               md:-mt-14 lg:-mt-20"
      >
        <h2
          class="font-bold mb-5
                 text-4xl sm:text-5xl
                 md:text-8xl lg:text-70xl"
        >
          Seu rango
          <span class="text-[#4E342E]">sem</span>
          complicação!
        </h2>

        <p
          class="text-base sm:text-lg
                 text-gray-800
                 mb-8
                 font-bold"
        >
          Descubra refeições rápidas, acessíveis e perto de você.
        </p>

        <Link
          href="/register"
          class="inline-block
                 bg-orange-500 text-white
                 px-6 sm:px-8
                 py-3
                 rounded
                 text-base sm:text-lg
                 font-bold
                 hover:bg-orange-600
                 transition"
        >
          Começar agora
        </Link>
      </div>

      <!-- IMAGEM -->
      <div
        class="flex justify-center md:justify-end
               w-full md:w-auto
               md:-mt-12 lg:-mt-24"
      >
        <img
          src="/coxinha.png"
          class="w-full
                 max-w-xs sm:max-w-sm
                 md:max-w-lg lg:max-w-xl xl:max-w-4xl
                 h-auto
                 drop-shadow-xl
                 select-none"
          alt="Imagem de uma coxinha"
        />
      </div>
    </section>
  </div>
</template>
