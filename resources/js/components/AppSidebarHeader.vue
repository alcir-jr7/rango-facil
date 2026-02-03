<script setup lang="ts">
    import { ref } from 'vue';
    import { SidebarTrigger } from '@/components/ui/sidebar';
    import { User, ShoppingCart, Star, Store } from 'lucide-vue-next';
    import { Link, usePage, router } from '@inertiajs/vue3';
    import type { BreadcrumbItemType } from '@/types';
    import { ArrowLeft, Settings, LogOut } from 'lucide-vue-next';
    import { logout } from '@/routes';
    
    const handleLogout = () => {
    router.flushAll()
    }

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
        <div class="flex items-center gap-3">
            <button @click="goBack"
                class="mr-4 flex items-center justify-center rounded-full p-2 hover:bg-orange-600 transition" aria-label="Voltar">
                <ArrowLeft class="w-6 h-6 text-gray-700" />
            </button>

            <Link href="/dashboard" class="flex items-center gap-4">
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
            </Link>
        </div>

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
            
            <div class="relative group">
                <div
                    class="w-10 h-10 bg-orange-500 hover:bg-orange-600
                        rounded-full flex items-center justify-center
                        cursor-pointer"
                >
                    <User class="w-6 h-6 text-white" />
                </div>
                <div
                    class="absolute right-0 mt-2 w-48
                        bg-white border border-gray-100
                        rounded-xl shadow-lg
                        opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible
                        transition-all duration-200 z-50"
                >
                    <Link
                        href="/settings/profile"
                        class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        <Settings class="w-4 h-4" />
                        Configurações
                    </Link>

                    <Link
                        :href="logout()"
                        @click="handleLogout"
                        as="button"
                        data-test="logout-button"
                        class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors"
                    >
                        <LogOut class="w-4 h-4" />
                        Sair
                    </Link>
                </div>
            </div>
        </div>
    </header>
</template>
