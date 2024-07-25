<template>
    <SplideSlide v-for="(image, index) in imageUrl" :key="index">
        <inertia-link
            class="flex flex-col justify-start items-center gap-2"
            :href="link"
        >
            <img
                class="bg-base-200 rounded-lg h-[400px]"
                :src="image.link"
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
                {{ image.name }}
            </p>
        </inertia-link>
    </SplideSlide>
</template>

<script setup>
import { SplideSlide } from "@splidejs/vue-splide";

const props = defineProps({
    imageUrl: {
        type: Array,
    },
    activeSlideIndex: {
        type: Number,
    },
    link: {
        type: String,
        default: null,
    },
});
</script>
