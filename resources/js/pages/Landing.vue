<script setup lang="ts">
  import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Rango Fácil" />

  <section class="min-h-screen bg-[#FFF3C4]">
    <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
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
      <nav class="hidden md:flex gap-8 text-sm font-medium text-gray-700">
        <a href="#produtos" class="hover:text-orange-500">Produtos</a>
        <a href="#lojas" class="hover:text-orange-500">Lojas</a>
        <a href="#sobre" class="hover:text-orange-500">Sobre</a>
        <a href="#avisos" class="hover:text-orange-500">Avisos</a>
        <a href="#contato" class="hover:text-orange-500">Contato</a>
      </nav>
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
      <div class="relative flex justify-center">
        <div class="absolute inset-y-0 left-0 w-1/2 bg-orange-400 rounded-r-[80px]"></div>
        <img
          src="/coxinha.png"
          class="relative z-8 w-68 md:w-88 drop-shadow-2xl"
          alt="Comida"
        />
      </div>
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
        <p class="text-gray-500 text-sm">O mais perto de você.</p>
      </div>
      <div>
        <div class="text-orange-500 text-4xl mb-4">⭐</div>
        <h3 class="font-bold mb-2">Qualidade</h3>
        <p class="text-gray-500 text-sm">Avaliações reais de clientes.</p>
      </div>
    </div>
  </section>

  <section  id="produtos" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-center text-3xl font-bold mb-14 text-black">
        Mais Populares
      </h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/pastel-frito.png" class="rounded-xl mb-4" />
          <h4 class="font-bold text-xl mb-2 text-gray-900">Pastel Artesanal</h4>
          <p class="text-sm text-gray-600 mb-3">Massa crocante e recheios variados</p>
          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">A partir de R$ 15,00</span>
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.7 (1.5k avaliações)</span>
          </div>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Pedir Agora
          </Link>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/hambúrguer.png" class="rounded-xl mb-4" />
          <h4 class="font-bold text-xl mb-2 text-gray-900">Hambúrguer Gourmet</h4>
          <p class="text-sm text-gray-600 mb-3">Carne premium e ingredientes de qualidades</p>
          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">A partir de R$ 25,00</span>
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.9 (5.5k avaliações)</span>
          </div>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Pedir Agora
          </Link>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
          <img src="/pizza.png" class="rounded-xl mb-4" />
          <h4 class="font-bold text-xl mb-2 text-gray-900">Pizza Tradicional</h4>
          <p class="text-sm text-gray-600 mb-3">Massa fina e sabores irresistíveis</p>
          <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-500">A partir de R$ 45,00</span>
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.9 (3.5k avaliações)</span>
          </div>
          <Link href="/register" class="mt-4 w-full block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600 transition duration-300 hover:scale-105">
          Pedir Agora
          </Link>
        </div>
      </div>
    </div>
  </section>

  <section id="lojas" class="bg-[#FFF3C4] py-24">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-center text-3xl font-bold mb-14 text-black">
        Lojas perto de você
      </h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/lanchonete.png" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500" />
          <h4 class="font-bold text-lg mb-2 text-gray-900">Silva Lanchonete</h4>
          <p class="text-sm text-gray-500">Lanches • Salgados</p>
          <div class="flex items-center justify-center gap-2 mb-2">
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.8</span>
            <span class="text-xs text-gray-400">(958 avaliações)</span>
          </div>
        </Link>
        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/pastel.png" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500" />
          <h4 class="font-bold text-lg mb-2 text-gray-900">Pastelando</h4>
          <p class="text-sm text-gray-500">Pastéis • Bebidas</p>
          <div class="flex items-center justify-center gap-2 mb-2">
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.7</span>
            <span class="text-xs text-gray-400">(837 avaliações)</span>
          </div>
        </Link>
        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/buger-house.png" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500" />
          <h4 class="font-bold text-lg mb-2 text-gray-900">Burger House</h4>
          <p class="text-sm text-gray-500">Hambúrgueres • Batatas</p>
          <div class="flex items-center justify-center gap-2 mb-2">
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.9</span>
            <span class="text-xs text-gray-400">(1.027 avaliações)</span>
          </div>
        </Link>
        <Link href="/register" class="bg-white rounded-2xl shadow p-5 text-center block cursor-pointer hover:shadow-xl hover:-translate-y-2 transition duration-300">
          <img src="/pizzaria.png" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500" />
          <h4 class="font-bold text-lg mb-2 text-gray-900">Pizzaria Milanno</h4>
          <p class="text-sm text-gray-500">Pizzas • Massas • Sobremesas</p>
          <div class="flex items-center justify-center gap-2 mb-2">
            <span class="text-sm text-orange-500 font-semibold">⭐ 4.6</span>
            <span class="text-xs text-gray-400">(727 avaliações)</span>
          </div>
        </Link>
      </div>
    </div>
  </section>

  <section class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <h3 class="text-4xl font-bold mb-6 text-gray-800">Pronto para <span class="text-orange-500">começar?</span></h3>
      <p class="text-xl mb-10 opacity-90 text-gray-600">
        Cadastre-se agora e faça seu primeiro pedido!
      </p>
      <Link
        href="/register"
        class="inline-block bg-orange-500 text-white px-12 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300"
      >
        Criar Minha Conta Grátis
      </Link>
    </div>
  </section>

  <footer class="bg-orange-500 text-white py-4">
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
          <li><a href="https://github.com/alcir-jr7/rango-facil" target="_blank"
              rel="noopener noreferrer" class="hover:underline">Sobre o Projeto</a></li>
          <li><Link href="/privacidade" class="hover:underline">Política de Privacidade</Link></li>
          <li><Link href="/quem-somos" class="hover:underline">Quem Somos</Link></li>
        </ul>
      </div>
      <div id="avisos">
        <h4 class="font-bold text-white mb-4">Ajuda</h4>
        <ul class="space-y-2">
          <li><Link href="/codigo-conduta" class="hover:underline">Código de Conduta</Link></li>
          <li><Link href="/faq" class="hover:underline">Perguntas Frequentes</Link></li>
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
    <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-orange-100 text-center text-sm text-white">
      <p>© 2026 Rango Fácil. Todos os direitos reservados.</p>
    </div>
  </footer>
</template>