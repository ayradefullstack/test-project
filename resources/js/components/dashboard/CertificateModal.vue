<script setup lang="ts">
import {
    Award,
    CheckCircle2,
    Copy,
    Download,
    FileCheck2,
    Printer,
    QrCode,
    ShieldCheck,
    X,
} from '@lucide/vue';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import type { Work } from '@/components/dashboard/DashboardWorksTable.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const { t, locale } = useI18n();

const props = defineProps<{
    work: Work | null;
    open: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
}>();

const copied = ref(false);

const copyHash = async () => {
    if (!props.work?.hash) return;
    try {
        await navigator.clipboard.writeText(props.work.hash);
        copied.value = true;
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch {
        // fallback
    }
};

const handlePrint = () => {
    window.print();
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-2xl p-0 overflow-hidden rounded-2xl border border-onda-blue-500/30 shadow-2xl bg-card">
            <!-- Modal Top Bar -->
            <div class="flex items-center justify-between border-b border-border/80 bg-muted/40 px-5 py-3.5">
                <div class="flex items-center gap-2">
                    <Award class="size-4.5 text-onda-blue-600 dark:text-onda-blue-400" />
                    <DialogTitle class="text-sm font-bold text-foreground">
                        {{ t('dashboard.cert.heading') }}
                    </DialogTitle>
                </div>

                <div class="flex items-center gap-2">
                    <Button
                        size="sm"
                        variant="outline"
                        class="h-8 gap-1.5 text-xs rounded-lg cursor-pointer"
                        @click="handlePrint"
                    >
                        <Printer class="size-3.5" />
                        <span>{{ t('dashboard.cert.printBtn') }}</span>
                    </Button>
                </div>
            </div>

            <!-- Authentic Official Certificate Body -->
            <div v-if="work" class="p-6 sm:p-8 space-y-6 text-center print:p-0">
                <!-- Official Institutional Header -->
                <div class="space-y-1 border-b border-border/60 pb-5">
                    <p class="text-xs font-bold tracking-widest text-muted-foreground uppercase">
                        {{ t('dashboard.cert.officialTitle') }}
                    </p>
                    <p class="text-xs text-muted-foreground">
                        {{ t('dashboard.cert.ministry') }}
                    </p>
                    <h3 class="text-base sm:text-lg font-black text-onda-blue-700 dark:text-onda-blue-400 tracking-tight pt-1">
                        {{ t('dashboard.cert.ondaFull') }}
                    </h3>
                    <div class="pt-2 flex justify-center">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20 shadow-2xs">
                            <ShieldCheck class="size-3.5" />
                            {{ t('dashboard.cert.officialProof') }}
                        </span>
                    </div>
                </div>

                <!-- Certificate Metadata Grid -->
                <div class="rounded-xl border border-border/80 bg-muted/15 p-5 text-start space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-[11px] font-semibold text-muted-foreground uppercase tracking-wider">
                                {{ t('dashboard.cert.workTitle') }}
                            </span>
                            <p class="text-sm sm:text-base font-bold text-foreground mt-0.5">
                                {{ locale === 'ar' ? work.titleAr : work.title }}
                            </p>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold text-muted-foreground uppercase tracking-wider">
                                {{ t('dashboard.cert.author') }}
                            </span>
                            <p class="text-sm sm:text-base font-bold text-foreground mt-0.5">
                                {{ work.authorName }}
                            </p>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold text-muted-foreground uppercase tracking-wider">
                                {{ t('dashboard.table.colRef') }}
                            </span>
                            <p class="font-mono text-xs font-bold text-onda-blue-700 dark:text-onda-blue-400 mt-0.5">
                                {{ work.reference }}
                            </p>
                        </div>

                        <div>
                            <span class="text-[11px] font-semibold text-muted-foreground uppercase tracking-wider">
                                {{ t('dashboard.cert.depositDate') }}
                            </span>
                            <p class="text-xs font-medium text-foreground mt-0.5">
                                {{ work.date }} (14:32:08 UTC+1)
                            </p>
                        </div>
                    </div>

                    <!-- Cryptographic SHA-256 Checksum Container -->
                    <div class="border-t border-border/60 pt-3">
                        <span class="text-[11px] font-semibold text-muted-foreground uppercase tracking-wider">
                            {{ t('dashboard.cert.sha256') }}
                        </span>
                        <div class="mt-1 flex items-center justify-between gap-2 rounded-lg bg-background p-2.5 border border-border font-mono text-[11px] text-foreground">
                            <span class="truncate">{{ work.hash }}</span>
                            <Button
                                size="sm"
                                variant="ghost"
                                class="h-6 px-2 text-[10px] text-onda-blue-600 dark:text-onda-blue-400 shrink-0 cursor-pointer"
                                @click="copyHash"
                            >
                                <component :is="copied ? CheckCircle2 : Copy" class="size-3 me-1" />
                                <span>{{ copied ? 'Copié' : 'Copier' }}</span>
                            </Button>
                        </div>
                    </div>
                </div>

                <!-- QR Code Verification Footer -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-border/60 pt-4 text-start">
                    <div class="flex items-center gap-3">
                        <!-- Simulated SVG QR code graphic -->
                        <div class="size-16 rounded-lg bg-white p-1.5 border border-border shrink-0 shadow-xs flex items-center justify-center">
                            <QrCode class="size-13 text-gray-900" />
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-xs font-bold text-foreground">
                                {{ t('cert.instantVerify') }}
                            </p>
                            <p class="text-[11px] text-muted-foreground leading-relaxed max-w-xs">
                                {{ t('dashboard.cert.qrNotice') }}
                            </p>
                        </div>
                    </div>

                    <p class="text-[10px] text-muted-foreground text-center sm:text-end max-w-[200px] leading-relaxed">
                        {{ t('dashboard.cert.legalRef') }}
                    </p>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
