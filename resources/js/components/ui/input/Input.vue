<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { useVModel } from "@vueuse/core"
import { cn } from "@/lib/utils"

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes["class"]
}>()

const emits = defineEmits<{
  (e: "update:modelValue", payload: string | number): void
}>()

const modelValue = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <input
    v-model="modelValue"
    data-slot="input"
    :class="cn(
      'file:text-foreground placeholder:text-muted-foreground selection:bg-onda-blue-600 selection:text-white dark:bg-input/20 border-input h-10 w-full min-w-0 rounded-xl border bg-background/50 px-3.5 py-2 text-base md:text-sm shadow-xs transition-all duration-300 ease-out outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50',
      'hover:border-onda-blue-400/60 hover:shadow-[0_0_12px_rgba(27,102,157,0.14)]',
      'focus-visible:border-onda-blue-600 focus-visible:ring-4 focus-visible:ring-onda-blue-600/20 focus-visible:shadow-[0_0_18px_rgba(27,102,157,0.25)] dark:focus-visible:border-onda-blue-400 dark:focus-visible:ring-onda-blue-400/25',
      'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
      props.class,
    )"
  >
</template>
