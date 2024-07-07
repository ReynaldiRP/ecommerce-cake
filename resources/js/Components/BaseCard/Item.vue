<template>
    <inertia-link :href="url">
        <figure>
            <img :src="imageUrl" alt="Shoes" />
        </figure>
        <div class="card-body">
            <h2 class="text-base font-light">{{ cakeName }}</h2>
            <p class="text-lg font-bold">{{ cakePrice }}</p>
            <div class="w-fit flex gap-2">
                <p class="text-sm font-light">{{ cakeFlavour }}</p>
                <span>|</span>
                <p class="text-sm font-light">{{ cakeToppings }}</p>
            </div>
        </div>
    </inertia-link>
</template>

<script setup>
defineProps({
    imageUrl: {
        type: String,
    },
    cakeName: {
        type: String,
    },
    cakePrice: {
        type: Number,
    },
    cakeFlavour: {
        type: String,
    },
    cakeToppings: {
        type: String,
    },
    url: {
        type: String,
    },
});
</script>
