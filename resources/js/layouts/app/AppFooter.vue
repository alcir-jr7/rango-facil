<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const isOpen = ref(false)
const hideButton = ref(false)

const toggleFooter = () => {
  isOpen.value = !isOpen.value
}

const handleScroll = () => {
  const scrollPosition = window.innerHeight + window.scrollY
  const pageHeight = document.documentElement.scrollHeight

  if (scrollPosition >= pageHeight - 10) {
    isOpen.value = true
    hideButton.value = true
  } else {
    hideButton.value = false
    isOpen.value = false
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <button
        v-show="!hideButton"
        @click="toggleFooter"
        :class="[
            'fixed bottom-4 right-4 z-50 w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition',
            isOpen ? 'bg-white' : 'bg-orange-500'
        ]"
        >
        <i
            :class="[
            'text-2xl transition-colors',
            isOpen ? 'bi bi-chevron-down text-orange-600' : 'bi bi-chevron-up text-white'
            ]"
        ></i>
    </button>


  <transition name="slide-up">
    <footer
      v-show="isOpen"
      class="fixed bottom-0 left-0 w-full
             bg-orange-500 text-white py-4 z-40"
    >
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

        <div>
          <h4 class="font-bold text-white mb-4">Sobre</h4>
          <ul class="space-y-2">
            <li>
              <Link href="https://github.com/alcir-jr7/rango-facil.git">
                Projeto
              </Link>
            </li>
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

        <div>
          <h4 class="font-bold text-white mb-4">Contato</h4>
          <p>Brasil</p>
          <p>
            <a
                href="mailto:contatorangofacil@gmail.com"
                class="hover:underline"
            >
                contatorangofacil@gmail.com
            </a>
          </p>
          <div class="flex gap-4 items-center mt-3">
            <a href="#" class="hover:opacity-80 transition">
              <i class="bi bi-instagram text-xl"></i>
            </a>
            <a href="#" class="hover:opacity-80 transition">
              <i class="bi bi-linkedin text-xl"></i>
            </a>
            <a
              href="https://github.com/alcir-jr7/rango-facil"
              target="_blank"
              class="hover:opacity-80 transition"
            >
              <i class="bi bi-github text-xl"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </transition>
</template>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.slide-up-enter-from,
.slide-up-leave-to {
  transform: translateY(100%);
  opacity: 0;
}
</style>
