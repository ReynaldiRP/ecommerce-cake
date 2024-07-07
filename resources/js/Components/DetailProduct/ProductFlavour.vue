<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">Flavour</h2>
        <section class="flex items-center gap-4">
            <BaseRadio text-size="1rem" :data="data" />
        </section>
    </section>
</template>

<script setup>
import BaseRadio from "@/Components/BaseRadio.vue";

defineProps({
    data: {
        type: Array,
    },
});
</script>
