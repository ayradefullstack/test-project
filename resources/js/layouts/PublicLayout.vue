<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu } from '@lucide/vue';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import LanguageSwitcher from '@/components/public/LanguageSwitcher.vue';
import OrgLogo from '@/components/public/OrgLogo.vue';
import ThemeToggle from '@/components/public/ThemeToggle.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { dashboard, home, login, logout, register } from '@/routes';

const { t } = useI18n();
const page = usePage();
const mobileMenuOpen = ref(false);
</script>

<template>
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:start-4 focus:z-50 focus:rounded-md focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-primary-foreground"
    >
        {{ t('nav.skipToContent') }}
    </a>

    <div class="flex min-h-screen flex-col bg-background text-foreground">
        <header class="sticky top-0 z-40 border-b border-border bg-background">
            <div
                class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
            >
                <Link
                    :href="home({ locale: page.props.locale })"
                    class="flex items-center"
                >
                    <OrgLogo class="h-8 w-auto sm:h-9" />
                </Link>

                <nav
                    class="hidden items-center gap-6 md:flex"
                    :aria-label="t('nav.menu')"
                >
                    <Link
                        :href="home({ locale: page.props.locale })"
                        class="text-sm font-medium text-foreground hover:text-seal"
                    >
                        {{ t('nav.home') }}
                    </Link>
                </nav>

                <div class="hidden items-center gap-2 md:flex">
                    <LanguageSwitcher />
                    <ThemeToggle />

                    <template v-if="page.props.auth.user">
                        <DropdownMenu>
                            <DropdownMenuTrigger
                                class="ms-2 inline-flex items-center rounded-md border border-border px-3 py-1.5 text-sm font-medium hover:bg-accent focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                                :aria-label="t('nav.userMenu')"
                            >
                                {{ page.props.auth.user.name }}
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem as-child>
                                    <Link :href="dashboard()">{{
                                        t('nav.dashboard')
                                    }}</Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link
                                        :href="logout()"
                                        method="post"
                                        as="button"
                                        class="w-full text-start"
                                    >
                                        {{ t('nav.signOut') }}
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </template>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="ms-2 text-sm font-medium hover:text-seal"
                        >
                            {{ t('nav.signIn') }}
                        </Link>
                        <Link
                            :href="register()"
                            class="inline-flex items-center rounded-md bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            {{ t('nav.createAccount') }}
                        </Link>
                    </template>
                </div>

                <Sheet v-model:open="mobileMenuOpen">
                    <SheetTrigger
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md hover:bg-accent focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none md:hidden"
                        :aria-label="t('nav.openMenu')"
                    >
                        <Menu class="size-5" />
                    </SheetTrigger>
                    <SheetContent
                        side="end"
                        :close-label="t('nav.closeMenu')"
                        class="flex w-4/5 flex-col gap-6 sm:max-w-xs"
                    >
                        <SheetHeader>
                            <SheetTitle class="text-start">{{
                                t('nav.menu')
                            }}</SheetTitle>
                        </SheetHeader>

                        <nav
                            class="flex flex-col gap-1"
                            :aria-label="t('nav.menu')"
                        >
                            <SheetClose as-child>
                                <Link
                                    :href="home({ locale: page.props.locale })"
                                    class="rounded-md px-3 py-2 text-sm font-medium hover:bg-accent"
                                >
                                    {{ t('nav.home') }}
                                </Link>
                            </SheetClose>
                        </nav>

                        <div class="flex items-center gap-2">
                            <LanguageSwitcher />
                            <ThemeToggle />
                        </div>

                        <div class="mt-auto flex flex-col gap-2">
                            <template v-if="page.props.auth.user">
                                <SheetClose as-child>
                                    <Link
                                        :href="dashboard()"
                                        class="rounded-md border border-border px-3 py-2 text-center text-sm font-medium hover:bg-accent"
                                    >
                                        {{ t('nav.dashboard') }}
                                    </Link>
                                </SheetClose>
                                <Link
                                    :href="logout()"
                                    method="post"
                                    as="button"
                                    class="rounded-md px-3 py-2 text-center text-sm font-medium hover:bg-accent"
                                >
                                    {{ t('nav.signOut') }}
                                </Link>
                            </template>
                            <template v-else>
                                <SheetClose as-child>
                                    <Link
                                        :href="login()"
                                        class="rounded-md border border-border px-3 py-2 text-center text-sm font-medium hover:bg-accent"
                                    >
                                        {{ t('nav.signIn') }}
                                    </Link>
                                </SheetClose>
                                <SheetClose as-child>
                                    <Link
                                        :href="register()"
                                        class="rounded-md bg-primary px-3 py-2 text-center text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                    >
                                        {{ t('nav.createAccount') }}
                                    </Link>
                                </SheetClose>
                            </template>
                        </div>
                    </SheetContent>
                </Sheet>
            </div>
        </header>

        <main id="main-content" class="flex-1">
            <slot />
        </main>

        <footer class="border-t border-border bg-background">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between"
                >
                    <OrgLogo class="h-8 w-auto" />

                    <nav
                        class="flex flex-col gap-2 text-sm"
                        :aria-label="t('nav.menu')"
                    >
                        <Link
                            :href="home({ locale: page.props.locale })"
                            class="text-muted-foreground hover:text-foreground"
                        >
                            {{ t('nav.home') }}
                        </Link>
                    </nav>
                </div>

                <p class="mt-8 max-w-2xl text-sm text-muted-foreground">
                    {{ t('footer.storageNotice') }}
                </p>

                <p class="mt-4 font-mono text-xs text-muted-foreground">
                    {{
                        t('footer.copyright', {
                            year: new Date().getFullYear(),
                        })
                    }}
                </p>
            </div>
        </footer>
    </div>
</template>
