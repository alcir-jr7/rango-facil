<script setup lang="ts">
    import { ref } from 'vue';
    import { SidebarTrigger } from '@/components/ui/sidebar';
    import { User, ShoppingCart, Star, Store } from 'lucide-vue-next';
    import { Link, usePage, router } from '@inertiajs/vue3';
    import type { BreadcrumbItemType } from '@/types';
    import { ArrowLeft } from 'lucide-vue-next';
    
    const page = usePage()
    const cartCount = page.props.cartCount as number
    const trigger = ref();

    withDefaults(
        defineProps<{
            breadcrumbs?: BreadcrumbItemType[];
        }>(),
        {
            breadcrumbs: () => [],
        },
    );

    const goBack = () => {
        window.history.back();
    };
</script>

<template>
    <header
        class="flex h-20 shrink-0 items-center justify-between border-b px-8 bg-white border-gray-100"
    >
        <SidebarTrigger ref="trigger" class="hidden" />
    <button @click="goBack"
        class="mr-4 flex items-center justify-center rounded-full p-2 hover:bg-orange-600 transition" aria-label="Voltar">
        <ArrowLeft class="w-6 h-6 text-gray-700" />
    </button>

        <Link href="/dashboard">
            <div class="flex items-center gap-4">
                <img 
                    src="/rangofacil.png" 
                    class="h-12 cursor-pointer" 
                    alt="Logo Rango Fácil"
                    @click="trigger?.$el?.click()"  
                />
                <div class="hidden md:block">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Rango Fácil
                    </h1>
                    <p class="text-sm text-gray-500">
                        Olá, {{ $page.props.auth.user.name.split(' ')[0] }}
                    </p>
                </div>
            </div>
        </Link>

        <div class="flex items-center gap-6 text-black">
            <Link href="/stores" class="flex items-center gap-2 cursor-pointer z-50 hover:text-orange-500">
                <Store class="w-6 h-6" />
            </Link>

            <Link href="/favorites" class="cursor-pointer z-50">
                <Star class="w-6 h-6 hover:text-orange-500" />
            </Link>

            <Link href="/cart" class="relative cursor-pointer z-50 p-2">
                <ShoppingCart class="w-6 h-6 hover:text-orange-500"/>
                <span
                    v-if="cartCount > 0"
                    class="absolute -top-1 -right-1
                           bg-orange-500 text-white
                           text-xs font-bold
                           min-w-[20px] h-5 rounded-full
                           flex items-center justify-center px-1.5"
                    >
                    {{ cartCount }}
                </span>
            </Link>

            <Link href="/settings/profile" class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 bg-orange-500 hover:bg-orange-600 rounded-full flex items-center justify-center">
                    <User class="w-6 h-6 text-white"/>
                </div>
            </Link>
        </div>
    </header>
</template>
