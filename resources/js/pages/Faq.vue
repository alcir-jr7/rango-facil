<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
</script>

<template> 
    <Head title="FAQ | Rango Fácil" />
    <section class="min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto px-6 py-20">
            <header class="mb-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-6">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-black mb-4">
                    Perguntas Frequentes
                </h1>
                <p class="text-gray-600">
                    Tire suas dúvidas sobre a landing page e o funcionamento da plataforma Rango Fácil.
                </p>
            </header>
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Sobre a Landing Page
                </h2>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            As imagens exibidas na landing page são reais?
                        </h3>
                        <p class="text-gray-600">
                            Não. As imagens exibidas na landing page são meramente ilustrativas e
                            têm o objetivo de demonstrar o layout e a proposta da plataforma.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            As lojas exibidas na landing page existem de verdade?
                        </h3>
                        <p class="text-gray-600">
                            Não necessariamente. As lojas, produtos, nomes e avaliações exibidos
                            na landing page são exemplos demonstrativos e não representam
                            estabelecimentos reais.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            É possível comprar algo pela landing page?
                        </h3>
                        <p class="text-gray-600">
                            Não. A landing page é apenas uma página de apresentação.
                            Para visualizar lojas reais e realizar compras, é necessário criar
                            uma conta e estar logado na plataforma.
                        </p>
                    </div>    
                </div>
            </section>
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Dúvidas Gerais
                </h2>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            Meus dados estão seguros na plataforma Rango Fácil?
                        </h3>
                        <p class="text-gray-600">
                            Sim. A segurança dos dados dos nossos usuários é uma prioridade.
                            Utilizamos medidas de segurança avançadas para proteger suas informações.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            O que é um pedido reservado?
                        </h3>
                        <p class="text-gray-600">
                            O pedido reservado permite que o cliente garanta o produto
                            por um período limitado. Caso não seja retirado dentro do prazo,
                            o pedido pode ser cancelado automaticamente.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            Como posso entrar em contato com o suporte?
                        </h3>
                        <p class="text-gray-600">
                            Você pode entrar em contato com o suporte através do nosso
                            formulário de contato disponível na seção "Contato" da landing page.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            O projeto está em desenvolvimento?
                        </h3>
                        <p class="text-gray-600">
                            Sim. O Rango Fácil está em constante evolução e pode receber
                            melhorias, ajustes visuais e novas funcionalidades.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg mb-2">
                            O Rango Fácil é um projeto acadêmico?
                        </h3>
                        <p class="text-gray-600">
                            Sim. O Rango Fácil é um projeto acadêmico com o objetivo de ser futuramente implementado e utilizado de forma real.
                        </p>
                    </div>
                </div>
            </section>
            <div class="mt-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 text-center shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-3">
                    Ainda tem dúvidas?
                </h3>
                <p class="text-orange-100 mb-6">
                    Nossa equipe está pronta para te ajudar
                </p>
                <a 
                    href="mailto:contatorangofacil@gmail.com" 
                    class="inline-flex items-center px-6 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-orange-50 transition-colors duration-200"
                >
                    Entre em contato
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</template>