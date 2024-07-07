<template>
    <section class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold">{{ cakeName }}</h1>
        <h2 class="text-2xl font-bold">Rp {{ cakePrice }}</h2>
        <p class="text-lg text-justify">
            {{ cakeDescription }}
        </p>
    </section>
</template>

<script setup>
defineProps({
    cakeName: {
        type: String,
    },
    cakePrice: {
        type: Number,
    },
    cakeDescription: {
        type: String,
    },
});
</script>
