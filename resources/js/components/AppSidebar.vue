<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Award,
    Building2,
    Coins,
    FileCheck2,
    FilePlus2,
    FolderKanban,
    Headphones,
    LayoutGrid,
    Scale,
    Sparkles,
} from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLogo from '@/components/AppLogo.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';

const { t, locale } = useI18n();

const isRtl = computed(() => locale.value === 'ar');

const mainNavItems = computed(() => [
    {
        title: t('sidebar.nav.overview'),
        href: dashboard(),
        icon: LayoutGrid,
        active: true,
    },
    {
        title: t('sidebar.nav.repertoire'),
        href: dashboard(),
        icon: FolderKanban,
        badge: '18',
        active: false,
    },
    {
        title: t('sidebar.nav.deposits'),
        href: dashboard(),
        icon: FilePlus2,
        badge: '2',
        active: false,
    },
    {
        title: t('sidebar.nav.royalties'),
        href: dashboard(),
        icon: Coins,
        active: false,
    },
    {
        title: t('sidebar.nav.certificates'),
        href: dashboard(),
        icon: Award,
        active: false,
    },
]);

const servicesNavItems = computed(() => [
    {
        title: t('sidebar.nav.tariffs'),
        href: dashboard(),
        icon: Scale,
    },
    {
        title: t('sidebar.nav.agencies'),
        href: dashboard(),
        icon: Building2,
    },
]);
</script>

<template>
    <Sidebar
        collapsible="icon"
        variant="inset"
        :side="isRtl ? 'right' : 'left'"
        class="border-sidebar-border/70"
    >
        <SidebarHeader class="border-b border-sidebar-border/60 pb-3">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="hover:bg-sidebar-accent/60">
                        <Link :href="dashboard()" class="flex items-center gap-3">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="py-2">
            <!-- Workspace Navigation Group -->
            <SidebarGroup>
                <SidebarGroupLabel class="text-[11px] font-semibold uppercase tracking-wider text-muted-foreground/70 text-start">
                    {{ t('sidebar.nav.main') }}
                </SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in mainNavItems" :key="item.title">
                        <SidebarMenuButton
                            as-child
                            :is-active="item.active"
                            :tooltip="item.title"
                            class="group relative font-medium data-[active=true]:bg-onda-blue-600/10 data-[active=true]:text-onda-blue-700 data-[active=true]:font-semibold dark:data-[active=true]:bg-onda-blue-500/20 dark:data-[active=true]:text-onda-blue-400 transition-all rounded-lg"
                        >
                            <Link :href="item.href" class="flex items-center gap-3 w-full text-start">
                                <component
                                    :is="item.icon"
                                    class="size-4 shrink-0 transition-transform group-hover:scale-110"
                                />
                                <span class="truncate">{{ item.title }}</span>
                                <span
                                    v-if="item.badge"
                                    class="ms-auto flex h-5 min-w-5 shrink-0 items-center justify-center rounded-full bg-onda-blue-600/10 px-1.5 font-mono text-[10px] font-bold text-onda-blue-700 dark:bg-onda-teal-500/20 dark:text-onda-teal-300"
                                >
                                    {{ item.badge }}
                                </span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>

            <!-- Services & Legal Group -->
            <SidebarGroup class="mt-2">
                <SidebarGroupLabel class="text-[11px] font-semibold uppercase tracking-wider text-muted-foreground/70 text-start">
                    {{ t('sidebar.nav.services') }}
                </SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in servicesNavItems" :key="item.title">
                        <SidebarMenuButton
                            as-child
                            :tooltip="item.title"
                            class="text-muted-foreground hover:text-foreground transition-all rounded-lg"
                        >
                            <Link :href="item.href" class="flex items-center gap-3 w-full text-start">
                                <component :is="item.icon" class="size-4 shrink-0" />
                                <span class="truncate">{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>

            <!-- Hotline Widget for Creators -->
            <div class="mx-3 mt-auto mb-2 rounded-xl border border-onda-blue-500/20 bg-gradient-to-br from-onda-blue-500/5 to-onda-teal-500/5 p-3 dark:from-onda-blue-950/40 dark:to-onda-teal-950/40">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="flex size-6 items-center justify-center rounded-md bg-onda-blue-600/10 text-onda-blue-600 dark:bg-onda-blue-500/20 dark:text-onda-blue-400">
                        <Headphones class="size-3.5" />
                    </div>
                    <span class="text-xs font-semibold text-foreground">
                        {{ t('sidebar.hotline.title') }}
                    </span>
                </div>
                <p class="text-xs font-mono font-bold text-onda-blue-700 dark:text-onda-blue-400 tracking-wider dir-ltr text-start">
                    {{ t('sidebar.hotline.number') }}
                </p>
                <p class="text-[10px] text-muted-foreground mt-0.5">
                    Dimanche – Jeudi (08:30 - 16:30)
                </p>
            </div>
        </SidebarContent>

        <SidebarFooter class="border-t border-sidebar-border/60 pt-2">
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

