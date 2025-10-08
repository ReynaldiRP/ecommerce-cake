<template>
    <section class="flex flex-col gap-3">
        <h1 class="text-lg" :class="customClass">{{ filteringName }}</h1>
        <slot></slot>
    </section>
</template>

<script setup>
defineProps({
    filteringName: {
        type: String,
        default: null,
    },
    customClass: {
        type: String,
        default: null,
    }
});
</script>
