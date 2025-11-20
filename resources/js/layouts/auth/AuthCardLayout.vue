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
</script>

<template>
    <div class="flex min-h-svh items-center justify-center bg-muted p-6 md:p-10">

        <div class="flex w-full max-w-5xl h-[500px] bg-white rounded-2xl shadow-xl overflow-hidden">

            <div class="w-1/2 bg-orange-500 text-white flex flex-col items-center justify-center p-10">
                
                <Link :href="home()" class="absolute top-6 left-6 flex items-center gap-2 font-medium">
                    <div class="flex h-9 w-9 items-center justify-center">
                        <AppLogoIcon class="size-9 fill-current text-white" />
                    </div>
                </Link>

                <h2 class="text-3xl font-bold mb-4">Faça seu cadastro</h2>
                <p class="mb-6 text-lg">Realize sua primeira compra ;)</p>

                <Link
                    :href="'/register'"
                    class="px-8 py-3 bg-white text-orange-500 font-bold rounded-xl shadow hover:bg-gray-100"
                >
                    CADASTRAR
                </Link>
            </div>

            <div class="w-1/1 flex items-center justify-center p-10">

                <Card class="w-full border-none shadow-none">
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
