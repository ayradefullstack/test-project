<script setup lang="ts">
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import { ChevronDown, Search, Check, X } from '@lucide/vue';

export interface SelectOption {
    value: string | number;
    label: string;
    labelAr?: string;
    labelFr?: string;
    subtitle?: string;
    badge?: string;
    flagUrl?: string;
    searchTerms?: string;
}

const props = withDefaults(
    defineProps<{
        modelValue?: string | number | null;
        options: SelectOption[];
        placeholder?: string;
        searchPlaceholder?: string;
        emptyText?: string;
        name?: string;
        id?: string;
        disabled?: boolean;
        required?: boolean;
        tabindex?: number;
        variant?: 'blue' | 'teal';
    }>(),
    {
        modelValue: '',
        placeholder: 'Sélectionner...',
        searchPlaceholder: 'Rechercher...',
        emptyText: 'Aucun résultat trouvé',
        name: '',
        id: '',
        disabled: false,
        required: false,
        tabindex: 0,
        variant: 'blue',
    }
);

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number): void;
    (e: 'change', value: string | number): void;
}>();

const isOpen = ref(false);
const searchQuery = ref('');
const searchInputRef = ref<HTMLInputElement | null>(null);
const containerRef = ref<HTMLDivElement | null>(null);
const highlightedIndex = ref(-1);

// Find selected option
const selectedOption = computed(() => {
    return props.options.find((opt) => String(opt.value) === String(props.modelValue)) || null;
});

// Normalized search matching (case-insensitive, accent-tolerant, Arabic-tolerant)
const normalizeString = (str: string): string => {
    return str
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();
};

const filteredOptions = computed(() => {
    const q = normalizeString(searchQuery.value);
    if (!q) {
        return props.options;
    }

    return props.options.filter((opt) => {
        const rawTexts = [
            opt.label,
            opt.labelAr || '',
            opt.labelFr || '',
            opt.subtitle || '',
            opt.badge || '',
            opt.searchTerms || '',
            String(opt.value || ''),
        ].join(' ');

        return normalizeString(rawTexts).includes(q) || rawTexts.toLowerCase().includes(searchQuery.value.toLowerCase());
    });
});

const toggleDropdown = () => {
    if (props.disabled) return;
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        searchQuery.value = '';
        highlightedIndex.value = -1;
        nextTick(() => {
            searchInputRef.value?.focus();
        });
    }
};

const closeDropdown = () => {
    isOpen.value = false;
    searchQuery.value = '';
    highlightedIndex.value = -1;
};

const selectOption = (opt: SelectOption) => {
    emit('update:modelValue', opt.value);
    emit('change', opt.value);
    closeDropdown();
};

const clearSearch = () => {
    searchQuery.value = '';
    searchInputRef.value?.focus();
};

// Keyboard navigation
const onKeyDown = (e: KeyboardEvent) => {
    if (props.disabled) return;

    if (!isOpen.value) {
        if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
            e.preventDefault();
            toggleDropdown();
        }
        return;
    }

    const maxIndex = filteredOptions.value.length - 1;

    switch (e.key) {
        case 'ArrowDown':
            e.preventDefault();
            highlightedIndex.value = highlightedIndex.value < maxIndex ? highlightedIndex.value + 1 : 0;
            break;
        case 'ArrowUp':
            e.preventDefault();
            highlightedIndex.value = highlightedIndex.value > 0 ? highlightedIndex.value - 1 : maxIndex;
            break;
        case 'Enter':
            e.preventDefault();
            if (highlightedIndex.value >= 0 && filteredOptions.value[highlightedIndex.value]) {
                selectOption(filteredOptions.value[highlightedIndex.value]);
            }
            break;
        case 'Escape':
            e.preventDefault();
            closeDropdown();
            break;
    }
};

// Click outside detection
const handleClickOutside = (e: MouseEvent) => {
    if (containerRef.value && !containerRef.value.contains(e.target as Node)) {
        closeDropdown();
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

watch(
    () => props.modelValue,
    () => {
        // Reset search if value changes externally
    }
);
</script>

<template>
    <div ref="containerRef" class="relative w-full text-start" @keydown="onKeyDown">
        <!-- Hidden Native Input for Native/Inertia Form Submissions -->
        <input
            v-if="name"
            type="hidden"
            :name="name"
            :id="id"
            :value="modelValue ?? ''"
            :required="required"
        />

        <!-- Trigger Button -->
        <button
            type="button"
            :tabindex="tabindex"
            :disabled="disabled"
            @click="toggleDropdown"
            class="input-premium flex h-11 w-full items-center justify-between gap-2 px-3.5 text-sm text-foreground transition-all duration-300 select-none cursor-pointer focus:outline-none"
            :class="[
                isOpen ? 'ring-2 ring-onda-blue-600/30 border-onda-blue-600 dark:border-onda-blue-500' : '',
                disabled ? 'opacity-50 cursor-not-allowed bg-muted/40' : 'bg-background hover:border-onda-blue-500/40',
                variant === 'teal' ? 'input-premium-teal' : 'input-premium'
            ]"
            :aria-expanded="isOpen"
            aria-haspopup="listbox"
        >
            <div class="flex items-center gap-2.5 truncate">
                <img
                    v-if="selectedOption?.flagUrl"
                    :src="selectedOption.flagUrl"
                    :alt="selectedOption.label"
                    class="size-4 shrink-0 rounded-xs object-cover border border-border/40 shadow-xs"
                    loading="lazy"
                />
                <span v-if="selectedOption" class="truncate font-medium text-foreground">
                    {{ selectedOption.label }}
                </span>
                <span v-else class="truncate text-muted-foreground">
                    {{ placeholder }}
                </span>
            </div>

            <div class="flex items-center gap-1.5 flex-shrink-0 text-muted-foreground">
                <span v-if="selectedOption?.badge" class="rounded-md bg-onda-blue-500/10 px-1.5 py-0.5 text-xs font-semibold text-onda-blue-600 dark:text-onda-blue-400">
                    {{ selectedOption.badge }}
                </span>
                <ChevronDown
                    class="size-4 text-muted-foreground/70 transition-transform duration-300"
                    :class="{ 'rotate-180 text-onda-blue-600 dark:text-onda-blue-400': isOpen }"
                />
            </div>
        </button>

        <!-- Dropdown Menu / Combobox Popover -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform scale-95 opacity-0 -translate-y-1"
            enter-to-class="transform scale-100 opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="transform scale-100 opacity-100 translate-y-0"
            leave-to-class="transform scale-95 opacity-0 -translate-y-1"
        >
            <div
                v-if="isOpen"
                class="absolute left-0 right-0 z-50 mt-1.5 max-h-80 w-full overflow-hidden rounded-2xl border border-border/80 bg-card/95 p-1.5 shadow-2xl backdrop-blur-xl ring-1 ring-black/5 dark:border-white/10 dark:bg-card/95"
            >
                <!-- Embedded Search Bar -->
                <div class="relative mb-1 px-1.5 pt-1">
                    <Search class="absolute top-1/2 -translate-y-1/2 start-4 size-4 text-muted-foreground/70" />
                    <input
                        ref="searchInputRef"
                        v-model="searchQuery"
                        type="text"
                        :placeholder="searchPlaceholder"
                        class="h-9 w-full rounded-xl border border-border/70 bg-background/80 ps-9 pe-8 text-xs text-foreground placeholder:text-muted-foreground focus:border-onda-blue-600 focus:outline-none focus:ring-2 focus:ring-onda-blue-600/20 dark:border-white/10"
                        @click.stop
                    />
                    <button
                        v-if="searchQuery"
                        type="button"
                        @click.stop="clearSearch"
                        class="absolute top-1/2 -translate-y-1/2 end-3 flex size-5 items-center justify-center rounded-full text-muted-foreground hover:bg-muted hover:text-foreground"
                    >
                        <X class="size-3" />
                    </button>
                </div>

                <!-- Scrollable Options List -->
                <div class="max-h-56 overflow-y-auto space-y-0.5 p-0.5 custom-scrollbar" role="listbox">
                    <button
                        v-for="(opt, index) in filteredOptions"
                        :key="opt.value"
                        type="button"
                        role="option"
                        :aria-selected="String(opt.value) === String(modelValue)"
                        @click.stop="selectOption(opt)"
                        @mouseenter="highlightedIndex = index"
                        class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-xs transition-colors duration-150 select-none cursor-pointer"
                        :class="[
                            String(opt.value) === String(modelValue)
                                ? 'bg-onda-blue-600/10 font-semibold text-onda-blue-700 dark:bg-onda-blue-500/20 dark:text-onda-blue-300'
                                : highlightedIndex === index
                                  ? 'bg-muted/70 text-foreground'
                                  : 'text-foreground hover:bg-muted/50'
                        ]"
                    >
                        <div class="flex items-center gap-2.5 truncate pe-2 text-start">
                            <img
                                v-if="opt.flagUrl"
                                :src="opt.flagUrl"
                                :alt="opt.label"
                                class="size-4 shrink-0 rounded-xs object-cover border border-border/40 shadow-xs"
                                loading="lazy"
                            />
                            <div class="flex flex-col items-start gap-0.5 truncate">
                                <span class="truncate">{{ opt.label }}</span>
                                <span v-if="opt.subtitle" class="text-[10px] text-muted-foreground">
                                    {{ opt.subtitle }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <span v-if="opt.badge" class="rounded bg-muted px-1.5 py-0.5 text-[10px] font-medium text-muted-foreground">
                                {{ opt.badge }}
                            </span>
                            <Check
                                v-if="String(opt.value) === String(modelValue)"
                                class="size-3.5 text-onda-blue-600 dark:text-onda-blue-400"
                            />
                        </div>
                    </button>

                    <!-- Empty Results State -->
                    <div
                        v-if="filteredOptions.length === 0"
                        class="py-6 text-center text-xs text-muted-foreground flex flex-col items-center justify-center gap-1.5"
                    >
                        <Search class="size-5 text-muted-foreground/40 stroke-1" />
                        <span>{{ emptyText }}</span>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(150, 150, 150, 0.25);
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(150, 150, 150, 0.4);
}
</style>
