<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">Topping</h2>
        <section class="flex items-center gap-4">
            <BaseCheckbox
                v-for="(toppings, index) in toppings"
                :key="index"
                text-color="#A6ADBB"
                :label="toppings.label"
            />
        </section>
    </section>
</template>

<script setup>
import BaseCheckbox from "@/Components/BaseCheckbox.vue";

defineProps({
    toppings: {
        type: Array,
    },
});
</script>
