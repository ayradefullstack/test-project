<script setup lang="ts">
import {
    Bell,
    CheckCircle2,
    Clock,
    FileCheck2,
    Info,
    ShieldCheck,
    Wallet,
} from '@lucide/vue';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

const { t } = useI18n();

interface Notification {
    id: string;
    title: string;
    description: string;
    time: string;
    read: boolean;
    type: 'royalty' | 'deposit' | 'security' | 'announcement';
}

const notifications = ref<Notification[]>([
    {
        id: '1',
        title: 'Virement de redevances exécuté',
        description: 'Un virement de 184,500 DZD a été crédité au titre des droits audiovisuels T2-2026.',
        time: 'Il y a 10 min',
        read: false,
        type: 'royalty',
    },
    {
        id: '2',
        title: 'Attestation de dépôt validée',
        description: 'Votre œuvre "Symphonie des Aurès" a été certifiée avec succès (Réf: DZ-2026-MUS-0814).',
        time: 'Il y a 2 heures',
        read: false,
        type: 'deposit',
    },
    {
        id: '3',
        title: 'Horodatage souverain sécurisé',
        description: 'Vérification cryptographique SHA-256 confirmée sur les serveurs institutionnels.',
        time: 'Hier',
        read: true,
        type: 'security',
    },
    {
        id: '4',
        title: 'Campagne de déclaration 2026',
        description: 'La session annuelle de dépôt et régularisation des œuvres littéraires est ouverte.',
        time: 'Il y a 2 jours',
        read: true,
        type: 'announcement',
    },
]);

const unreadCount = computed(
    () => notifications.value.filter((n) => !n.read).length,
);

const markAllAsRead = () => {
    notifications.value.forEach((n) => {
        n.read = true;
    });
};

const getIcon = (type: Notification['type']) => {
    switch (type) {
        case 'royalty':
            return Wallet;
        case 'deposit':
            return FileCheck2;
        case 'security':
            return ShieldCheck;
        default:
            return Info;
    }
};

const getIconColor = (type: Notification['type']) => {
    switch (type) {
        case 'royalty':
            return 'bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400';
        case 'deposit':
            return 'bg-onda-blue-500/10 text-onda-blue-600 dark:bg-onda-blue-500/20 dark:text-onda-blue-400';
        case 'security':
            return 'bg-indigo-500/10 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400';
        default:
            return 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400';
    }
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                size="icon"
                class="relative h-9 w-9 rounded-lg text-foreground hover:bg-accent focus-visible:ring-2 focus-visible:ring-ring"
                :aria-label="t('dashboard.notifications.title')"
            >
                <Bell class="size-4" />
                <span
                    v-if="unreadCount > 0"
                    class="absolute -top-0.5 -end-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-onda-blue-600 px-1 text-[10px] font-bold text-white shadow-xs dark:bg-onda-teal-500 dark:text-gray-950 animate-pulse"
                >
                    {{ unreadCount }}
                </span>
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent
            align="end"
            class="w-80 sm:w-96 rounded-xl p-0 shadow-xl border border-border/80 bg-popover/95 backdrop-blur-md"
        >
            <div class="flex items-center justify-between border-b border-border/60 px-4 py-3">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-semibold text-foreground">
                        {{ t('dashboard.notifications.title') }}
                    </h4>
                    <Badge
                        v-if="unreadCount > 0"
                        variant="secondary"
                        class="text-[10px] px-1.5 py-0 h-4 font-mono font-semibold bg-onda-blue-500/10 text-onda-blue-600 dark:text-onda-blue-400 border-onda-blue-500/20"
                    >
                        {{ unreadCount }}
                    </Badge>
                </div>
                <button
                    v-if="unreadCount > 0"
                    @click="markAllAsRead"
                    class="text-xs text-onda-blue-600 hover:text-onda-blue-700 dark:text-onda-blue-400 dark:hover:text-onda-blue-300 font-medium transition-colors cursor-pointer"
                >
                    {{ t('dashboard.notifications.markAllRead') }}
                </button>
            </div>

            <div class="max-h-[380px] overflow-y-auto divide-y divide-border/40 p-1">
                <div
                    v-for="item in notifications"
                    :key="item.id"
                    :class="[
                        'flex items-start gap-3 p-3 rounded-lg transition-colors cursor-pointer',
                        item.read
                            ? 'hover:bg-accent/50 opacity-75 hover:opacity-100'
                            : 'bg-onda-blue-500/5 hover:bg-onda-blue-500/10 dark:bg-onda-blue-950/30 dark:hover:bg-onda-blue-950/50',
                    ]"
                    @click="item.read = true"
                >
                    <div
                        :class="[
                            'flex size-8 shrink-0 items-center justify-center rounded-lg',
                            getIconColor(item.type),
                        ]"
                    >
                        <component :is="getIcon(item.type)" class="size-4" />
                    </div>

                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex items-center justify-between gap-1">
                            <p class="text-xs font-semibold text-foreground truncate">
                                {{ item.title }}
                            </p>
                            <span class="shrink-0 text-[10px] text-muted-foreground flex items-center gap-1">
                                <Clock class="size-2.5" />
                                {{ item.time }}
                            </span>
                        </div>
                        <p class="text-[11px] text-muted-foreground leading-relaxed line-clamp-2">
                            {{ item.description }}
                        </p>
                    </div>

                    <span
                        v-if="!item.read"
                        class="size-1.5 rounded-full bg-onda-blue-600 dark:bg-onda-teal-400 shrink-0 self-center"
                    />
                </div>
            </div>

            <div class="border-t border-border/60 p-2 text-center bg-muted/20">
                <p class="text-[11px] text-muted-foreground">
                    {{ t('dashboard.sovereignBadge') }}
                </p>
            </div>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
