<script setup lang="ts">
  import { Head } from '@inertiajs/vue3'
  import { ref } from 'vue'

  const teamMembers = [
    {
      name: 'Alcir Silva',
      role: 'Desenvolvedor Full Stack',
      course: 'Informática para Internet',
      image: '/devs/alcir.png',
      social: {
        github: 'https://github.com/alcir-jr7',
        linkedin: 'https://www.linkedin.com/in/alcir-jr',
        instagram: 'https://www.instagram.com/alcir_jr7/'
      }
    },
    {
      name: 'Karolayne Firmino',
      role: 'Designer UI/UX & Dev Front-End',
      course: 'Informática para Internet',
      image: '/devs/karol.png',
      social: {
        github: 'https://github.com/Firmino03',
        linkedin: 'https://www.linkedin.com/in/karolayne-firmino/',
        instagram: 'https://www.instagram.com/karolayne_firmino/'
      }
    },
    {
      name: 'Marília Gabriela',
      role: 'Designer UI/UX & Dev Full Stack',
      course: 'Informática para Internet',
      image: '/devs/marilia.png',
      social: {
        github: 'https://github.com/maryllia-g',
        linkedin: 'https://www.linkedin.com/in/mariliacardoso/',
        instagram: 'https://www.instagram.com/marylia_gabriela_/'
      }
    },
    {
      name: 'Mikaias Marinho',
      role: 'Desenvolvedor Full Stack',
      course: 'Informática para Internet',
      image: '/devs/mikaias.png',
      social: {
        github: 'https://github.com/MikaSantos01',
        linkedin: 'https://www.linkedin.com/in/mikaias-marinho-b13a8325a/',
        instagram: 'https://www.instagram.com/mika_santos12/'
      }
    },
    {
      name: 'Rui Barbosa',
      role: 'Designer UI/UX',
      course: 'Informática para Internet',
      image: '/devs/rui.png',
      social: {
        github: 'https://github.com/rui827',
        linkedin: 'https://www.linkedin.com/in/rui-barbosa-6aa6481b7/',
        instagram: 'https://www.instagram.com/ruii.barbosa/'
      }
    },
    {
      name: 'Yara Regina',
      role: 'Desenvolvedora Full Stack',
      course: 'Informática para Internet',
      image: '/devs/yara.png',
      social: {
        github: 'https://github.com/yayamat',
        linkedin: 'https://www.linkedin.com/in/yara-regina-dino-da-silva-76213a360/',
        instagram: 'https://www.instagram.com/yaya_regina/'
      }
    }
  ]

  const missions = [
    {
      icon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
      title: 'Facilitar o acesso',
      description: 'Proporcionar aos consumidores uma experiência simples e eficiente, permitindo a localização rápida de produtos e vendedores no campus.'
    },
    {
      icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
      title: 'Potencializar vendas',
      description: 'Oferecer aos alunos empreendedores uma plataforma digital que contribua para a profissionalização da divulgação de seus produtos.'
    },
    {
      icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
      title: 'Fortalecer a comunidade',
      description: 'Estimular o comércio interno, promovendo integração, apoio mútuo e desenvolvimento sustentável no ambiente acadêmico.'
    }
  ]
</script>

<template>
  <Head title="Sobre o Projeto | Rango Fácil" />
  <section class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
      <header class="mb-20 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl mb-8 shadow-lg">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
          Sobre o Projeto <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">Rango Fácil</span>
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
          Uma iniciativa acadêmica desenvolvida no IFPE Campus Igarassu, unindo
          tecnologia, empreendedorismo estudantil e impacto social.
        </p>
      </header>

      <section class="mb-20">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-12">
          <div class="flex items-center mb-8">
            <div class="flex-shrink-0 w-12 h-12 bg-orange-100 rounded-xl flex items-center  justify-center mr-4">
              <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
              Nossa História
            </h2>
          </div>      
          <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
            <p>O <strong class="text-orange-600">Rango Fácil</strong> surgiu a partir de uma ideia inicial proposta pelo <strong>professor Ramon Mota</strong>, no contexto de um projeto de <strong>pesquisa e extensão</strong> desenvolvido no IFPE - Campus Igarassu.
            </p>
            <p>
              A proposta nasceu da observação do cotidiano acadêmico, especialmente da
              dificuldade enfrentada por estudantes para encontrar opções de alimentação
              prática, acessível e organizada durante os intervalos das aulas.
            </p>
            <p>
              Paralelamente, identificou-se um cenário crescente de empreendedorismo estudantil,
              no qual alunos de diferentes cursos produzem e comercializam alimentos como forma
              de complementar sua renda e custear seus estudos.
            </p>
            <p>
              Nesse contexto, o Rango Fácil foi concebido como uma solução tecnológica capaz de
              conectar consumidores e vendedores, oferecendo uma plataforma digital para
              divulgação, organização e fortalecimento do comércio interno no ambiente acadêmico.
            </p>
            <p class="border-l-4 border-orange-500 pl-6 italic bg-orange-50 py-4 rounded-r-lg">
              Atualmente, o projeto está sendo usado pelos alunos como
              <strong>Projeto de Conclusão de Curso</strong> de Informática para Internet
              e será apresentado oficialmente durante a <strong>Demo Week</strong>,
              evento promovido pelo Instituto Federal de Pernambuco - Campus Igarassu.
            </p>
          </div>
        </div>
      </section>

      <section class="mb-20">
        <div class="text-center mb-12">
          <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
            Nossa Missão
          </h2>
          <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            Transformar a experiência de alimentação no ambiente acadêmico através da tecnologia
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div
            v-for="(mission, index) in missions"
            :key="index"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
          >
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-md">
              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="mission.icon" />
              </svg>
            </div>
            <h3 class="font-bold text-xl mb-3 text-gray-900">
              {{ mission.title }}
            </h3>
            <p class="text-gray-600 leading-relaxed">
              {{ mission.description }}
            </p>
          </div>
        </div>
      </section>

      <section class="mb-20">
        <div class="text-center mb-16">
          <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
            Equipe de Desenvolvimento
          </h2>
          <p class="text-gray-600 text-lg max-w-4xl mx-auto leading-relaxed">
            O Rango Fácil é desenvolvido por uma equipe multidisciplinar de estudantes do
            curso de Informática para Internet, que atuam de forma colaborativa na
            construção de uma solução tecnológica alinhada às necessidades da comunidade acadêmica.
          </p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(member, index) in teamMembers"
            :key="index"
            class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
          >
            <div class="relative inline-block mb-6">
              <img
                :src="member.image"
                :alt="member.name"
                class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-orange-100 group-hover:border-orange-300 transition-colors duration-300 shadow-lg"
              />
              <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-1">{{ member.name }}</h3>
            <p class="text-sm text-orange-600 font-medium mb-1">{{ member.role }}</p>
            <p class="text-sm text-gray-500 mb-6">{{ member.course }}</p>
            <div class="flex justify-center gap-3">
              <a
                :href="member.social.github"
                target="_blank"
                rel="noopener noreferrer"
                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-500 hover:text-white transition-all duration-300 hover:scale-110"
              >
                <i class="bi bi-github text-lg"></i>
              </a>
              <a
                :href="member.social.linkedin"
                target="_blank"
                rel="noopener noreferrer"
                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-500 hover:text-white transition-all duration-300 hover:scale-110"
              >
                <i class="bi bi-linkedin text-lg"></i>
              </a>
              <a
                :href="member.social.instagram"
                target="_blank"
                rel="noopener noreferrer"
                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-500 hover:text-white transition-all duration-300 hover:scale-110"
              >
                <i class="bi bi-instagram text-lg"></i>
              </a>
            </div>
          </div>
        </div>
      </section>

      <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-3xl p-10 sm:p-12 text-center shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
        <div class="relative z-10">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
          </div>
          <h3 class="text-3xl sm:text-4xl font-bold text-white mb-4">
            Pesquisa, Extensão e Inovação
          </h3>
          <p class="text-orange-50 text-lg max-w-3xl mx-auto leading-relaxed">
            O Rango Fácil representa a integração entre ensino, pesquisa e extensão,
            evidenciando o potencial da tecnologia como ferramenta de transformação
            social dentro do IFPE Campus Igarassu.
          </p>
        </div>
      </div>
    </div>
  </section>
</template>