<script setup lang="ts">
  import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Rango Fácil" />
<!-- ================= HERO ================= -->
  <section class="min-h-screen bg-[#FFF3C4]">
    <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">

      <!-- Logo + Nome -->
      <div class="flex items-center gap-3">
        <img
          src="/rangofacil.png"
          alt="RangoFácil"
          class="w-10 h-10 object-contain"
        />
        <h1 class="font-bold text-xl text-orange-600">
          Rango Fácil
        </h1>
      </div>
      <!-- Navegação -->
      <nav class="hidden md:flex gap-8 text-sm font-medium text-gray-700">
        <a href="#produtos" class="hover:text-orange-500">Produtos</a>
        <a href="#lojas" class="hover:text-orange-500">Lojas</a>
        <a href="#sobre" class="hover:text-orange-500">Sobre</a>
        <a href="#contato" class="hover:text-orange-500">Contato</a>
      </nav>
      <!-- Ações -->
      <div class="flex items-center gap-6">
        <Link href="/login" class="text-sm font-semibold hover:text-orange-500">
          Login
        </Link>
        <Link
          href="/register"
          class="bg-orange-500 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-orange-600 transition"
        >
          Cadastrar
        </Link>
      </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center mt-10">
      <!-- IMAGEM -->
      <div class="relative flex justify-center">
        <div class="absolute inset-y-0 left-0 w-1/2 bg-orange-400 rounded-r-[80px]"></div>
        <img
          src="/coxinha.png"
          class="relative z-8 w-68 md:w-88 drop-shadow-2xl"
          alt="Comida"
        />
      </div>

      <!-- TEXTO -->
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight mb-6">
          Seu rango com<br />
          <span class="text-orange-500">sabor</span> e praticidade
        </h2>
        <p class="text-gray-600 max-w-md mb-8">
          Encontre comidas deliciosas, rápidas e acessíveis perto de você.
        </p>
        <Link
          href="/register"
          class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-600 transition"
        >
          Começar agora
        </Link>
      </div>
    </div>
  </section>

  <!-- ================= FEATURES ================= -->
  <section class="bg-white py-16 shadow">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10 text-center">
      <div>
        <div class="text-orange-500 text-4xl mb-4">🛒</div>
        <h3 class="font-bold mb-2">Fácil de pedir</h3>
        <p class="text-gray-500 text-sm">Poucos cliques para matar sua fome.</p>
      </div>
      <div>
        <div class="text-orange-500 text-4xl mb-4">⚡</div>
        <h3 class="font-bold mb-2">Entrega rápida</h3>
        <p class="text-gray-500 text-sm">Restaurantes perto de você.</p>
      </div>
      <div>
        <div class="text-orange-500 text-4xl mb-4">⭐</div>
        <h3 class="font-bold mb-2">Qualidade</h3>
        <p class="text-gray-500 text-sm">Avaliações reais de clientes.</p>
      </div>
    </div>
  </section>

  <!-- ================= POPULARES ================= -->
  <section  id="produtos" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-center text-3xl font-bold mb-14">
        Mais <span class="text-orange-500">populares</span>
      </h3>

      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/pastel-frito.png" class="rounded-xl mb-4" />
          <h4 class="font-bold">Pastel</h4>
          <span class="text-sm text-orange-500">⭐ 4.7</span>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Comprar
          </Link>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/hambúrguer.png" class="rounded-xl mb-4" />
          <h4 class="font-bold">Hambúrguer</h4>
          <span class="text-sm text-orange-500">⭐ 4.8</span>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Comprar
          </Link>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/pizza.png" class="rounded-xl mb-4" />
          <h4 class="font-bold">Pizza</h4>
          <span class="text-sm text-orange-500">⭐ 4.9</span>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Comprar
          </Link>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= LOJAS ================= -->
  <section id="lojas" class="bg-[#FFF3C4] py-24">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-center text-3xl font-bold mb-14">
        Lojas <span class="text-orange-500">perto de você</span>
      </h3>

      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/lanchonete.png" class="rounded-xl mb-4 h-36 w-full object-cover" />
          <h4 class="font-bold">Silva Lanchonete</h4>
          <p class="text-sm text-gray-500">Lanches • Salgados</p>
          <span class="text-sm text-orange-500">⭐ 4.8</span>
        </Link>

        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/pastel.png" class="rounded-xl mb-4 h-36 w-full object-cover" />
          <h4 class="font-bold">Pastelando</h4>
          <p class="text-sm text-gray-500">Pastéis • Bebidas</p>
          <span class="text-sm text-orange-500">⭐ 4.7</span>
        </Link>

        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/buger-house.png" class="rounded-xl mb-4 h-36 w-full object-cover" />
          <h4 class="font-bold">Burger House</h4>
          <p class="text-sm text-gray-500">Hambúrgueres</p>
          <span class="text-sm text-orange-500">⭐ 4.9</span>
        </Link>

        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/pizzaria.png" class="rounded-xl mb-4 h-36 w-full object-cover" />
          <h4 class="font-bold">Pizza Boa</h4>
          <p class="text-sm text-gray-500">Pizzas • Massas</p>
          <span class="text-sm text-orange-500">⭐ 4.6</span>
        </Link>
      </div>
    </div>
  </section>

  <!-- ================= FOOTER ================= -->
  <footer class="bg-orange-600 text-white py-4">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10 text-sm">
      <div>
        <div class="flex items-center gap-1 mb-1">
          <img
              src="/rangofacil.png"
              alt="RangoFácil"
              class="w-10 h-10 object-contain"
          />
          <h4 class="font-bold text-white text-lg">
              Rango Fácil
          </h4>
        </div>
        <p class="px-11">Sabor perto de você.</p>
      </div>

      <div id="sobre">
        <h4 class="font-bold text-white mb-4">Sobre</h4>
        <ul class="space-y-2">
          <li><Link href="https://github.com/alcir-jr7/rango-facil.git">Projeto</Link></li>
          <li><Link href="/privacidade">Privacidade</Link></li>
          <li><Link href="/quem-somos">Quem Somos</Link></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-white mb-4">Ajuda</h4>
        <ul class="space-y-2">
        <li>FAQ</li>
        <li>Avisos</li>
        </ul>
      </div>
      <div id="contato">
        <h4 class="font-bold text-white mb-4">Contato</h4>
        <p>Brasil</p>
        <p>
          <a href="mailto:contatorangofacil@gmail.com" class="hover:underline">
            contatorangofacil@gmail.com
          </a>
        </p>
        <!-- Redes sociais --> 
        <div class="flex gap-4 items-center"> 
          <a href="#" target="_blank" class="hover:opacity-80 transition"> 
              <i class="bi bi-instagram text-xl"></i>
            </a> 
          <a href="#" target="_blank" class="hover:opacity-80 transition"> 
              <i class="bi bi-linkedin text-xl"></i> 
          </a> 
          <a href="https://github.com/alcir-jr7/rango-facil" target="_blank" class="hover:opacity-80 transition"> 
              <i class="bi bi-github text-xl"></i> 
          </a> 
        </div>
      </div>
    </div>
  </footer>
</template>
