<script setup lang="ts">
const props = defineProps({
  title: String || import.meta.env.VITE_APP_NAME || 'Simplis'
});
</script>

<template>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold logo-text-element"
            >{{ props.title }}</span
        >
    </div>
</template>
