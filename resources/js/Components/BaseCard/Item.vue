<template>
    <inertia-link :href="route('detail-product', { cakeId: cakeId })">
        <figure>
            <img
                :src="imageUrl"
                alt="Shoes"
                class="h-[180px] object-cover w-full rounded-lg"
            />
        </figure>
        <div class="card-body gap-1 text-base-content">
            <h2 class="text-base font-medium">
                {{ cakeName }}
            </h2>
            <p class="text-lg font-bold">{{ cakePrice }}</p>
            <div class="flex flex-col gap-2">
                <div
                    class="flex gap-2 items-center badge"
                    :class="isCustomizedBadge()"
                >
                    <i
                        v-if="cakePersonalizationType == 'customized'"
                        class="fa-solid fa-cake-candles"
                    ></i>
                    <i v-else class="fa-solid fa-cookie"></i>
                    <p class="font-medium text-nowrap">
                        {{ cakePersonalizationType }}
                    </p>
                </div>
                <div class="badge badge-outline badge-light">
                    {{ cakeCategory }}
                </div>
            </div>
        </div>
    </inertia-link>
</template>

<script setup>
const props = defineProps({
    imageUrl: {
        type: String,
        default: null,
    },
    cakeName: {
        type: String,
        default: null,
    },
    cakeCategory: {
        type: String,
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

const isCustomizedBadge = () => {
    return props.cakePersonalizationType === "customized"
        ? "badge-secondary "
        : " badge-neutral";
};
</script>
