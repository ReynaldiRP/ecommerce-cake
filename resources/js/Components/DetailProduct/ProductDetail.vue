<template>
    <section class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold">
            {{ cake.name
            }}<span v-show="cake.cake_size?.size">
                ({{ cake.cake_size?.size }}Cm)</span
            >
        </h1>
        <h2 class="text-2xl font-bold">
            {{ formatPrice(cake.totalCakePrice) }}
        </h2>
        <p class="text-lg text-justify">
            {{ cake.description }}
        </p>
    </section>
</template>

<script setup>
const props = defineProps({
    cake: {
        type: Object,
    },
});

/**
 * Formats a given price into a currency string using the Indonesian Rupiah currency format.
 *
 * @param {number} price - The price to be formatted.
 * @return {string} The formatted currency string.
 */
const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};
</script>
