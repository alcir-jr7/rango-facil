<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';
import AppFooter from './AppFooter.vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">

        <!-- SIDEBAR CUSTOMIZADA   
        <div class="bg-orange-500">
            <AppSidebar />
        </div>
        -->
        <!-- CONTEÚDO FULL WIDTH -->
        <AppContent 
            variant="sidebar" 
            class="overflow-x-hidden bg-white pb-28 relative w-full"
        >
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />

            <!-- Área expansiva -->
            <div class="w-full px-6">
                <slot />
            </div>

            <AppFooter class="absolute bottom-0 left-0 right-0" />
        </AppContent>

    </AppShell>
</template>
