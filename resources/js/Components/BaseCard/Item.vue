<template>
    <inertia-link :href="url">
        <figure>
            <img :src="imageUrl" alt="Shoes" />
        </figure>
        <div class="card-body gap-1 text-base-300">
            <h2 class="text-base font-medium">
                {{ cakeName }}
                <span v-show="cakeSize" class="font-bold"
                    >({{ cakeSize }}cm)</span
                >
            </h2>
            <p class="text-lg font-bold">Rp{{ cakePrice }}</p>
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
    cakeSize: {
        type: Number,
        default: null,
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
