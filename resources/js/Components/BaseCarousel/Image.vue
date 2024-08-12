<template>
    <SplideSlide v-for="(cake, index) in cakes" :key="index">
        <inertia-link
            class="flex flex-col justify-start items-center gap-2"
            :href="route('detail-product', { cakeId: cake.id })"
        >
            <img
                class="bg-base-200 rounded-lg h-[400px]"
                :src="
                    cake.image_url
                        ? cake.image_url
                        : 'assets/image/default-img.jpg'
                "
                :class="{
                    'bg-primary-color': activeSlideIndex === index,
                }"
                alt="image"
            />
            <p
                class="text-2xl text-white"
                :class="{
                    'font-bold': activeSlideIndex === index,
                }"
            >
                {{ cake.name }}
                <span class="font-bold text-primary-color"
                    >({{ cake.size }}Cm)
                </span>
            </p>
        </inertia-link>
    </SplideSlide>
</template>

<script setup>
import { SplideSlide } from "@splidejs/vue-splide";

const props = defineProps({
    cakes: {
        type: Object,
    },
    activeSlideIndex: {
        type: Number,
    },
});
</script>
