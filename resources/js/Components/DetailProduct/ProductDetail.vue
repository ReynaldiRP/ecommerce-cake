<template>
    <section class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold">
            {{ cake.name }}
        </h1>
        <section>
            <section v-if="cake.discount">
                <p class="text-2xl font-bold text-red-500">
                    {{ formatPrice(cake.totalCakePrice) }}
                </p>
                <div class="flex gap-1 items-center">
                    <p class="text-xl font-light line-through">
                        {{ formatPrice(cake.base_price) }}
                    </p>
                    <span class="text-lg text-red-400"
                        >({{ cake.discount.discount_percentage }}%)</span
                    >
                </div>
            </section>
            <p v-else class="text-2xl font-bold">
                {{ formatPrice(cake.totalCakePrice) }}
            </p>
        </section>
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
    formatPrice: {
        type: Function,
    },
});
</script>
