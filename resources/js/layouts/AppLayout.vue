<script setup lang="ts">
import FullscreenPreloader from '@/components/public/FullscreenPreloader.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
    <!-- Fullscreen ONDA Logo & Orbital Spinner Loading Screen -->
    <FullscreenPreloader :min-duration="600" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>

