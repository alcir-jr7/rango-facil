<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();

import { usePage } from '@inertiajs/vue3';

const page = usePage();
const isLoginPage = page.url.includes('/login');

</script>

<template>
    <div class="flex min-h-svh items-center justify-center bg-muted p-6 md:p-10">

        <!-- CARD EXTERNO -->
        <div
        class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden"
        :class="isLoginPage ? 'h-[460px]' : 'h-[520px]'"
        >

            <!-- CARD LARANJA -->
            <div
                class="w-[40%] h-full bg-orange-500 text-white flex flex-col items-center justify-center p-8 rounded-l-2xl relative"
            >
                <Link
                    :href="home()"
                    class="absolute top-6 left-6 flex items-center gap-2 font-medium"
                >
                    <div class="flex h-9 w-9 items-center justify-center">
                        <AppLogoIcon class="size-9 fill-current text-white" />
                    </div>
                </Link>

                <template v-if="isLoginPage">
                    <h2 class="text-3xl font-bold mb-3">Faça seu cadastro</h2>
                    <p class="mb-5 text-base">Realize sua primeira compra 🤍🛒</p>
                    <Link
                        href="/register"
                        class="px-7 py-2.5 bg-white text-orange-500 font-bold rounded-xl shadow hover:bg-gray-100"
                    >
                        CADASTRAR
                    </Link>
                </template>

                <template v-else>
                    <h2 class="text-3xl font-bold mb-3">Já tem conta?</h2>
                    <p class="mb-5 text-base">Faça login para continuar ;)🤍</p>
                    <Link
                        href="/login"
                        class="px-7 py-2.5 bg-white text-orange-500 font-bold rounded-xl shadow hover:bg-gray-100"
                    >
                        ENTRAR
                    </Link>
                </template>
            </div>

            <!-- CARD BRANCO -->
            <div class="w-[60%] flex items-center justify-center">
                <Card
                class="w-full border-none shadow-none flex flex-col justify-center px-10"
                :class="isLoginPage ? 'h-[400px]' : 'h-[460px]'"
                >

                    <CardHeader class="text-center">
                        <CardTitle class="text-2xl">{{ title }}</CardTitle>
                        <CardDescription>{{ description }}</CardDescription>
                    </CardHeader>

                    <CardContent>
                        <slot />
                    </CardContent>
                </Card>
            </div>

        </div>
    </div>
</template>
