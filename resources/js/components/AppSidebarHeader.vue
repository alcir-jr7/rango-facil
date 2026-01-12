<script setup lang="ts">
import { ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { User, ShoppingCart, Star } from 'lucide-vue-next';
import { Link, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

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
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center justify-between border-b border-sidebar-border/70 px-6 md:px-4 bg-orange-500"
    >
        <SidebarTrigger ref="trigger" class="hidden" />

        <div class="flex items-center gap-2">

            <img 
                src="/rangofacil.png" 
                class="h-8 cursor-pointer" 
                alt="Logo RangoFácil"
                @click="trigger?.$el?.click()"  
            />

            <h1 class="text-white font-bold text-lg">
                RangoFácil
            </h1>
        </div>

        <div class="flex items-center gap-4 text-white">

            <span class="font-medium">
                {{ $page.props.auth.user.name.split(' ')[0] }}
            </span>

            <Link href="/favorites" class="cursor-pointer z-50">
                <Star class="w-6 h-6 hover:text-yellow-300" />
            </Link>

            <Link href="/settings/profile" class="cursor-pointer z-50">
                <User class="w-6 h-6" />
            </Link>

            <Link href="/cart" class="cursor-pointer z-50">
                <ShoppingCart class="w-6 h-6" />
                <span
                    v-if="cartCount > 0"
                    class="absolute top-1 right-1
                           bg-red-600 text-white
                           text-xs font-bold
                           w-5 h-5 rounded-full
                           flex items-center justify-center"
                    >
                    {{ cartCount }}
                </span>
            </Link>
        </div>
    </header>
</template>
