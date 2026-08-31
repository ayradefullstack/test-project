<script setup lang="ts">
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const { locale } = useI18n();

const isArabic = computed(() => locale.value === 'ar');
</script>

<template>
    <div class="flex items-center gap-2.5 min-w-0">
        <!-- ONDA Official Emblem -->
        <div
            class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-white p-1 shadow-xs border border-border/80 dark:bg-card/90"
        >
            <AppLogoIcon class="size-7" />
        </div>

        <!-- ONDA Typography -->
        <div class="grid flex-1 text-start leading-tight min-w-0">
            <span class="truncate font-black tracking-tight text-foreground text-sm font-sans flex items-center gap-1.5">
                ONDA
                <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded bg-onda-blue-500/10 text-onda-blue-700 dark:bg-onda-teal-500/20 dark:text-onda-teal-300">
                    DZ
                </span>
            </span>
            <span class="truncate text-[10px] font-medium text-muted-foreground">
                {{ isArabic ? 'ديوان حقوق المؤلف' : 'Droits d’Auteur' }}
            </span>
        </div>
    </div>
</template>

