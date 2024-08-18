<template>
    <inertia-link :href="route('detail-product', { cakeId: cakeId })">
        <figure>
            <img
                :src="imageUrl"
                alt="Shoes"
                class="h-[180px] object-cover w-full rounded-t-lg"
            />
        </figure>
        <div class="card-body gap-1 text-base-300">
            <h2 class="text-base font-medium">
                {{ cakeName }}
                <span v-show="cakeSize" class="font-bold"
                    >({{ cakeSize }}cm)</span
                >
            </h2>
            <p class="text-lg font-bold">{{ cakePrice }}</p>
            <div class="w-fit flex gap-1">
                <p class="badge">{{ cakePersonalizationType }}</p>
            </div>
        </div>
    </inertia-link>
</template>

<script setup>
defineProps({
    imageUrl: {
        type: String,
        default: null,
    },
    cakeName: {
        type: String,
        default: null,
    },
    cakeSize: {
        type: Number,
        default: null,
    },
    cakePrice: {
        type: String || Number,
        default: null,
    },
    cakePersonalizationType: {
        type: String,
        default: null,
    },
    cakeId: {
        type: Number,
        default: null,
    },
});
</script>
