<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>

<template>
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

            <div>
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
            <div>
                <h4 class="font-bold text-white mb-4">Contato</h4>
                <p>Brasil</p>
                <p>contato@rangofacil.com</p>
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
