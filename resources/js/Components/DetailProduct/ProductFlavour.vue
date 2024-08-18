<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">Flavour</h2>
        <section class="grid grid-cols-2 lg:grid-cols-4 items-center gap-4">
            <BaseRadio
                text-size="1rem"
                v-for="(flavour, index) in flavours"
                :key="index"
                text-color="#A6ADBB"
                :label="flavour?.name"
            />
        </section>
    </section>
</template>

<script setup>
import BaseRadio from "@/Components/BaseRadio.vue";

defineProps({
    flavours: {
        type: Array,
    },
});
</script>
