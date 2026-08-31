<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from "@/lib/utils"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()
</script>

<template>
  <main
    data-slot="sidebar-inset"
    :class="cn(
      'bg-background relative flex w-full flex-1 flex-col transition-all duration-200 ease-linear',
      'md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ltr:ml-0 md:peer-data-[variant=inset]:rtl:mr-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ltr:ml-2 md:peer-data-[variant=inset]:peer-data-[state=collapsed]:rtl:mr-2',
      props.class,
    )"
  >
    <slot />
  </main>
</template>
