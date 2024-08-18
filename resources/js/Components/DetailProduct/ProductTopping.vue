<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">Topping</h2>
        <section class="grid grid-cols-2 lg:grid-cols-4 items-center gap-4">
            <BaseCheckbox
                v-for="(toppings, index) in toppings"
                :key="index"
                text-color="#A6ADBB"
                :label="toppings.name"
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
