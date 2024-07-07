<template>
    <SplideSlide
        class="flex flex-col justify-start items-center gap-2"
        v-for="(image, index) in imageUrl"
        :key="index"
    >
        <img
            class="bg-base-200 rounded-lg min-h-[200px] md:min-h-[300px] lg:min-h-[400px]"
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
});
</script>
