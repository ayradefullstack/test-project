<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <img
        src="/assets/logos/favicon.png"
        alt="ONDA"
        :class="['object-contain shrink-0', className]"
        v-bind="$attrs"
    />
</template>

