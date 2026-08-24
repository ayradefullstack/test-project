<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Globe } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import type { SupportedLocale } from '@/i18n';
import { home } from '@/routes';

const { t } = useI18n();
const page = usePage();

const languages: { code: SupportedLocale; key: string }[] = [
    { code: 'ar', key: 'common.language.ar' },
    { code: 'fr', key: 'common.language.fr' },
    { code: 'en', key: 'common.language.en' },
];
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger
            class="inline-flex h-9 w-9 items-center justify-center rounded-md text-foreground hover:bg-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            :aria-label="t('common.languageSwitcher')"
        >
            <Globe class="size-4" />
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem v-for="lang in languages" :key="lang.code" as-child>
                <Link
                    :href="home({ locale: lang.code })"
                    :aria-current="page.props.locale === lang.code ? 'page' : undefined"
                    class="w-full aria-[current=page]:font-semibold aria-[current=page]:text-seal"
                >
                    {{ t(lang.key) }}
                </Link>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
