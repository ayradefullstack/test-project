<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Code, FileText, Music, Video } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import { register } from '@/routes';

const { t } = useI18n();

const categories = [
    { key: 'deposit.categories.text', Icon: FileText },
    { key: 'deposit.categories.audio', Icon: Music },
    { key: 'deposit.categories.video', Icon: Video },
    { key: 'deposit.categories.software', Icon: Code },
];

const steps = [
    { titleKey: 'howItWorks.step1.title', descriptionKey: 'howItWorks.step1.description' },
    { titleKey: 'howItWorks.step2.title', descriptionKey: 'howItWorks.step2.description' },
    { titleKey: 'howItWorks.step3.title', descriptionKey: 'howItWorks.step3.description' },
];

const guarantees = [
    'guarantees.fileSize',
    'guarantees.resumable',
    'guarantees.storage',
    'guarantees.checksum',
];
</script>

<template>
    <Head title="ONDA" />

    <!-- HERO
         "Date it" (وثِّق تاريخه) is deliberately conservative: a deposit receipt
         documents when a work was submitted, it does not itself grant or
         register the underlying copyright (which exists automatically on
         creation in most Berne-derived systems, Algeria's included). Confirm
         the precise legal effect of an ONDA deposit with legal/ONDA counsel
         before this copy ships — TODO(legal). -->
    <section class="mx-auto max-w-4xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <h1 class="text-4xl font-semibold text-balance sm:text-5xl">
            {{ t('hero.title') }}
        </h1>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-muted-foreground">
            {{ t('hero.subtitle') }}
        </p>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <Link
                :href="register()"
                class="inline-flex items-center justify-center rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                {{ t('hero.primaryCta') }}
            </Link>
            <a
                href="#how-it-works"
                class="inline-flex items-center justify-center rounded-md border border-border px-5 py-2.5 text-sm font-medium hover:bg-accent"
            >
                {{ t('hero.secondaryCta') }}
            </a>
        </div>
    </section>

    <!-- WHAT YOU CAN DEPOSIT -->
    <section class="border-t border-border bg-card">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold">{{ t('deposit.heading') }}</h2>
            <p class="mt-2 max-w-2xl text-muted-foreground">
                {{ t('deposit.intro') }}
            </p>

            <div class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-4">
                <div
                    v-for="category in categories"
                    :key="category.key"
                    class="flex flex-col items-center gap-3 rounded-lg border border-border p-6 text-center"
                >
                    <component :is="category.Icon" class="size-6 text-seal" />
                    <span class="text-sm font-medium">{{ t(category.key) }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS
         A continuous horizontal path with a connecting line, rather than
         three stacked cards — the numbering is a real sequence here (create
         account -> upload -> receive receipt), so it earns its place. -->
    <section id="how-it-works" class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">{{ t('howItWorks.heading') }}</h2>

        <ol class="mt-10 flex flex-col gap-10 md:flex-row md:items-start md:gap-6">
            <li
                v-for="(step, index) in steps"
                :key="step.titleKey"
                class="relative flex flex-1 flex-col items-center gap-3 text-center"
            >
                <div
                    v-if="index < steps.length - 1"
                    class="absolute top-5 hidden h-px w-full bg-border md:block"
                    style="inset-inline-start: 50%"
                    aria-hidden="true"
                />
                <span
                    class="relative z-10 flex size-10 shrink-0 items-center justify-center rounded-full bg-primary font-mono text-sm text-primary-foreground"
                >
                    {{ index + 1 }}
                </span>
                <h3 class="font-medium">{{ t(step.titleKey) }}</h3>
                <p class="max-w-xs text-sm text-muted-foreground">
                    {{ t(step.descriptionKey) }}
                </p>
            </li>
        </ol>
    </section>

    <!-- WHAT WE GUARANTEE -->
    <section class="border-t border-border bg-card">
        <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold">{{ t('guarantees.heading') }}</h2>

            <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                <li
                    v-for="key in guarantees"
                    :key="key"
                    class="rounded-lg border border-border p-5 text-sm"
                >
                    {{ t(key) }}
                </li>
            </ul>
        </div>
    </section>

    <!-- CLOSING ACTION -->
    <section class="mx-auto max-w-2xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">{{ t('closing.heading') }}</h2>
        <Link
            :href="register()"
            class="mt-6 inline-flex items-center justify-center rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90"
        >
            {{ t('closing.cta') }}
        </Link>
    </section>
</template>
