<template>
    <inertia-link :href="url">
        <figure>
            <img :src="imageUrl" alt="Shoes" />
        </figure>
        <div class="card-body gap-0 text-base-300">
            <h2 class="text-base font-medium">{{ cakeName }}</h2>
            <p class="text-lg font-bold">{{ cakePrice }}</p>
            <div class="w-fit flex gap-1">
                <p class="badge">{{ cakePersonalizationType }}</p>
                <p class="badge">{{ cakeCategory }}</p>
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
    cakePersonalizationType: {
        type: String,
    },
    cakeCategory: {
        type: String,
    },
    url: {
        type: String,
    },
});
</script>
