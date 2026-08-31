<script setup lang="ts">
import {
    Award,
    BookOpen,
    Check,
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    Clapperboard,
    Clock,
    CodeXml,
    Copy,
    Download,
    Eye,
    FileCheck2,
    Filter,
    Music,
    Search,
    ShieldCheck,
} from '@lucide/vue';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

const { t, locale } = useI18n();

export interface Work {
    id: string;
    title: string;
    titleAr: string;
    category: 'music' | 'literature' | 'cinema' | 'software';
    reference: string;
    date: string;
    year: number;
    hash: string;
    status: 'approved' | 'pending' | 'draft' | 'distributed';
    fileSize: string;
    authorName: string;
}

const works = ref<Work[]>([
    {
        id: '1',
        title: 'Symphonie des Aurès (Opus 4)',
        titleAr: 'سيمفونية الأوراس (المصنف 4)',
        category: 'music',
        reference: 'DZ-2026-MUS-0814',
        date: '24 Août 2026',
        year: 2026,
        hash: 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',
        status: 'approved',
        fileSize: '142.8 MB (FLAC Master)',
        authorName: 'Mohamed Benali',
    },
    {
        id: '2',
        title: 'Récits de la Casbah : Mémoire Vivante',
        titleAr: 'حكايات القصبة: ذاكرة حية',
        category: 'literature',
        reference: 'DZ-2026-LIT-0791',
        date: '18 Août 2026',
        year: 2026,
        hash: '8f434346648f6b96df89dda901c5176b10a6d83961dd3c1ac88b59b2dc327aa4',
        status: 'approved',
        fileSize: '18.4 MB (PDF Archive)',
        authorName: 'Mohamed Benali',
    },
    {
        id: '3',
        title: "L'Épopée du Tassili (Documentaire 4K)",
        titleAr: 'ملحمة الطاسيلي (وثائقي 4K)',
        category: 'cinema',
        reference: 'DZ-2026-AV-0652',
        date: '12 Août 2026',
        year: 2026,
        hash: 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb',
        status: 'pending',
        fileSize: '4.2 GB (ProRes Master)',
        authorName: 'Mohamed Benali',
    },
    {
        id: '4',
        title: 'Algorithme Numismatique DZ-Auth v2',
        titleAr: 'خوارزمية المصادقة النقدية DZ-Auth v2',
        category: 'software',
        reference: 'DZ-2026-DEV-0410',
        date: '04 Août 2026',
        year: 2026,
        hash: '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce',
        status: 'approved',
        fileSize: '32.1 MB (Source Archive)',
        authorName: 'Mohamed Benali',
    },
    {
        id: '5',
        title: 'Qassida Al-Watan : Suite Vocale et Cordes',
        titleAr: 'قصيدة الوطن: متتالية صوتية ووتريات',
        category: 'music',
        reference: 'DZ-2026-MUS-0389',
        date: '28 Juillet 2026',
        year: 2026,
        hash: '4b227777d4dd1fc61c6f884f48641d02b4d121d3fd328cb08b5531fcacdabf8a',
        status: 'distributed',
        fileSize: '95.2 MB (WAV 24bit)',
        authorName: 'Mohamed Benali',
    },
    {
        id: '6',
        title: 'Gouvernance Numérique et Propriété Intellectuelle',
        titleAr: 'الحوكمة الرقمية والملكية الفكرية',
        category: 'literature',
        reference: 'DZ-2026-LIT-0219',
        date: '15 Juillet 2026',
        year: 2026,
        hash: 'ef2d127de37b942baad06145e54b0c619a1f22327b2ebbcfbec78f5564afe39d',
        status: 'draft',
        fileSize: '12.0 MB (Manuscript)',
        authorName: 'Mohamed Benali',
    },
]);

const searchQuery = ref('');
const selectedStatus = ref<string>('all');
const copiedHashId = ref<string | null>(null);

const emit = defineEmits<{
    (e: 'view-certificate', work: Work): void;
    (e: 'open-deposit'): void;
}>();

const filteredWorks = computed(() => {
    return works.value.filter((item) => {
        const matchesSearch =
            searchQuery.value.trim() === '' ||
            item.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.titleAr.includes(searchQuery.value) ||
            item.reference.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.hash.toLowerCase().includes(searchQuery.value.toLowerCase());

        const matchesStatus =
            selectedStatus.value === 'all' || item.status === selectedStatus.value;

        return matchesSearch && matchesStatus;
    });
});

const copyHash = async (id: string, hash: string) => {
    try {
        await navigator.clipboard.writeText(hash);
        copiedHashId.value = id;
        setTimeout(() => {
            copiedHashId.value = null;
        }, 2000);
    } catch {
        // clipboard fallback
    }
};

const getCategoryIcon = (category: Work['category']) => {
    switch (category) {
        case 'music':
            return Music;
        case 'literature':
            return BookOpen;
        case 'cinema':
            return Clapperboard;
        case 'software':
            return CodeXml;
    }
};

const getCategoryBadgeClass = (category: Work['category']) => {
    switch (category) {
        case 'music':
            return 'bg-blue-500/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400 border-blue-500/20';
        case 'literature':
            return 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 border-amber-500/20';
        case 'cinema':
            return 'bg-purple-500/10 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400 border-purple-500/20';
        case 'software':
            return 'bg-onda-teal-500/10 text-onda-teal-600 dark:bg-onda-teal-500/20 dark:text-onda-teal-400 border-onda-teal-500/20';
    }
};

const getStatusBadge = (status: Work['status']) => {
    switch (status) {
        case 'approved':
            return {
                label: t('dashboard.table.statusApproved'),
                class: 'bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 border-emerald-500/20',
                pulse: true,
                pulseClass: 'bg-emerald-500',
            };
        case 'pending':
            return {
                label: t('dashboard.table.statusPending'),
                class: 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 border-amber-500/20',
                pulse: true,
                pulseClass: 'bg-amber-500',
            };
        case 'draft':
            return {
                label: t('dashboard.table.statusDraft'),
                class: 'bg-muted text-muted-foreground border-border',
                pulse: false,
                pulseClass: '',
            };
        case 'distributed':
            return {
                label: t('dashboard.table.statusDistributed'),
                class: 'bg-onda-blue-500/10 text-onda-blue-600 dark:bg-onda-blue-500/20 dark:text-onda-blue-400 border-onda-blue-500/20',
                pulse: true,
                pulseClass: 'bg-onda-blue-500',
            };
    }
};
</script>

<template>
    <div class="rounded-2xl border border-border/80 bg-card shadow-xs overflow-hidden">
        <!-- Table Header & Filter Toolbar -->
        <div class="border-b border-border/70 p-4 sm:p-5 space-y-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-foreground tracking-tight flex items-center gap-2">
                        <FileCheck2 class="size-5 text-onda-blue-600 dark:text-onda-blue-400" />
                        {{ t('dashboard.table.title') }}
                    </h2>
                    <p class="text-xs text-muted-foreground mt-0.5">
                        {{ t('dashboard.table.subtitle') }}
                    </p>
                </div>

                <!-- Search Input -->
                <div class="relative w-full sm:w-72">
                    <Search class="absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="searchQuery"
                        type="text"
                        :placeholder="t('dashboard.table.searchPlaceholder')"
                        class="h-9.5 ps-9 text-xs rounded-xl input-premium"
                    />
                </div>
            </div>

            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                <button
                    type="button"
                    :class="[
                        'px-3 py-1.5 rounded-lg font-medium transition-all shrink-0 cursor-pointer',
                        selectedStatus === 'all'
                            ? 'bg-onda-blue-600 text-white font-semibold shadow-xs dark:bg-onda-blue-500 dark:text-gray-950'
                            : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                    @click="selectedStatus = 'all'"
                >
                    {{ t('dashboard.table.allStatus') }} ({{ works.length }})
                </button>
                <button
                    type="button"
                    :class="[
                        'px-3 py-1.5 rounded-lg font-medium transition-all shrink-0 cursor-pointer',
                        selectedStatus === 'approved'
                            ? 'bg-onda-blue-600 text-white font-semibold shadow-xs dark:bg-onda-blue-500 dark:text-gray-950'
                            : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                    @click="selectedStatus = 'approved'"
                >
                    {{ t('dashboard.table.statusApproved') }} (3)
                </button>
                <button
                    type="button"
                    :class="[
                        'px-3 py-1.5 rounded-lg font-medium transition-all shrink-0 cursor-pointer',
                        selectedStatus === 'pending'
                            ? 'bg-onda-blue-600 text-white font-semibold shadow-xs dark:bg-onda-blue-500 dark:text-gray-950'
                            : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                    @click="selectedStatus = 'pending'"
                >
                    {{ t('dashboard.table.statusPending') }} (1)
                </button>
                <button
                    type="button"
                    :class="[
                        'px-3 py-1.5 rounded-lg font-medium transition-all shrink-0 cursor-pointer',
                        selectedStatus === 'distributed'
                            ? 'bg-onda-blue-600 text-white font-semibold shadow-xs dark:bg-onda-blue-500 dark:text-gray-950'
                            : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                    @click="selectedStatus = 'distributed'"
                >
                    {{ t('dashboard.table.statusDistributed') }} (1)
                </button>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="border-b border-border/70 bg-muted/40 text-muted-foreground font-semibold">
                        <th class="py-3.5 px-4 text-start font-medium">{{ t('dashboard.table.colTitle') }}</th>
                        <th class="py-3.5 px-4 text-start font-medium hidden md:table-cell">{{ t('dashboard.table.colRef') }}</th>
                        <th class="py-3.5 px-4 text-start font-medium hidden sm:table-cell">{{ t('dashboard.table.colDate') }}</th>
                        <th class="py-3.5 px-4 text-start font-medium hidden lg:table-cell">{{ t('dashboard.table.colHash') }}</th>
                        <th class="py-3.5 px-4 text-start font-medium">{{ t('dashboard.table.colStatus') }}</th>
                        <th class="py-3.5 px-4 text-end font-medium">{{ t('dashboard.table.colActions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    <tr
                        v-for="work in filteredWorks"
                        :key="work.id"
                        class="hover:bg-accent/40 transition-colors group"
                    >
                        <!-- Title & Domain -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div
                                    :class="[
                                        'flex size-9 shrink-0 items-center justify-center rounded-xl border',
                                        getCategoryBadgeClass(work.category),
                                    ]"
                                >
                                    <component :is="getCategoryIcon(work.category)" class="size-4" />
                                </div>
                                <div class="min-w-0 space-y-0.5">
                                    <p class="font-semibold text-foreground truncate max-w-[220px] sm:max-w-xs md:max-w-md">
                                        {{ locale === 'ar' ? work.titleAr : work.title }}
                                    </p>
                                    <p class="text-[11px] text-muted-foreground">
                                        {{ work.fileSize }} • {{ work.year }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <!-- Reference Number -->
                        <td class="py-3.5 px-4 hidden md:table-cell">
                            <span class="font-mono text-xs font-semibold text-foreground/90 bg-muted/60 px-2 py-1 rounded-md">
                                {{ work.reference }}
                            </span>
                        </td>

                        <!-- Date -->
                        <td class="py-3.5 px-4 hidden sm:table-cell text-muted-foreground whitespace-nowrap">
                            {{ work.date }}
                        </td>

                        <!-- SHA-256 Checksum -->
                        <td class="py-3.5 px-4 hidden lg:table-cell">
                            <button
                                type="button"
                                class="flex items-center gap-1.5 font-mono text-[11px] text-muted-foreground hover:text-foreground bg-muted/40 hover:bg-muted px-2 py-1 rounded-md transition-colors cursor-pointer"
                                :title="work.hash"
                                @click="copyHash(work.id, work.hash)"
                            >
                                <span class="truncate max-w-[120px]">{{ work.hash.slice(0, 12) }}...{{ work.hash.slice(-6) }}</span>
                                <component
                                    :is="copiedHashId === work.id ? Check : Copy"
                                    :class="[
                                        'size-3 shrink-0',
                                        copiedHashId === work.id ? 'text-emerald-600 dark:text-emerald-400' : 'text-muted-foreground',
                                    ]"
                                />
                            </button>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span
                                :class="[
                                    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border',
                                    getStatusBadge(work.status).class,
                                ]"
                            >
                                <span
                                    v-if="getStatusBadge(work.status).pulse"
                                    :class="['size-1.5 rounded-full animate-pulse', getStatusBadge(work.status).pulseClass]"
                                />
                                {{ getStatusBadge(work.status).label }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-end whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <Button
                                    size="sm"
                                    variant="ghost"
                                    class="h-8 gap-1.5 px-2 text-xs font-semibold text-onda-blue-600 hover:text-onda-blue-700 hover:bg-onda-blue-500/10 dark:text-onda-blue-400 cursor-pointer"
                                    @click="emit('view-certificate', work)"
                                >
                                    <Award class="size-3.5" />
                                    <span class="hidden sm:inline">{{ t('dashboard.table.viewCert') }}</span>
                                </Button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="filteredWorks.length === 0">
                        <td colspan="6" class="py-12 text-center text-muted-foreground">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <Search class="size-8 text-muted-foreground/50" />
                                <p class="text-sm font-medium">{{ t('dashboard.table.noWorks') }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination bar -->
        <div class="border-t border-border/70 px-4 py-3 flex items-center justify-between text-xs text-muted-foreground">
            <span>{{ t('dashboard.table.page', { page: 1, total: 1 }) }}</span>
            <div class="flex items-center gap-1">
                <Button variant="outline" size="sm" class="h-7 text-xs rounded-lg" disabled>
                    <ChevronLeft class="size-3 rtl:rotate-180" />
                    <span class="hidden sm:inline">{{ t('dashboard.table.prev') }}</span>
                </Button>
                <Button variant="outline" size="sm" class="h-7 text-xs rounded-lg" disabled>
                    <span class="hidden sm:inline">{{ t('dashboard.table.next') }}</span>
                    <ChevronRight class="size-3 rtl:rotate-180" />
                </Button>
            </div>
        </div>
    </div>
</template>
