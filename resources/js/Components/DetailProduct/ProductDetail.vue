<template>
    <section class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold">{{ cake.name }}</h1>
        <h2 class="text-2xl font-bold">
            {{ formatPrice(cake.base_price + cake.cake_size.price) }}
        </h2>
        <p class="text-lg text-justify">
            {{ cakeDescription }}
        </p>
    </section>
</template>

<script setup>
const props = defineProps({
    cake: {
        type: Object,
    },
    cakeDescription: {
        type: String,
    },
});

const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};
</script>
