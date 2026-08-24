<script setup lang="ts"></script>

<template>
    <!-- Referenced directly from the public path (not a Vite import) per the
         asset-pipeline convention. No dark-mode variant exists for this mark;
         both brand colors clear WCAG's 3:1 non-text contrast floor against the
         dark surface, so it renders unmodified rather than being inverted.
         `class` passed at the call site merges onto this root element via
         Vue's default attribute fallthrough — no prop needed. -->
    <img src="/assets/logos/logo.png" alt="ONDA" width="1181" height="671" />
</template>
