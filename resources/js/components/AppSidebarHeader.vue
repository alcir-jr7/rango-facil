<script setup lang="ts">
import { ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { User, ShoppingCart } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

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

            <Link href="/settings/profile">
                <User class="w-6 h-6 cursor-pointer" />
            </Link>

            <ShoppingCart class="w-6 h-6 cursor-pointer" />
        </div>
    </header>
</template>
