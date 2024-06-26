<template>
    <Carousel :wrap-around="true">
        <Slide v-for="slide in 10" :key="slide">
            <!-- <img
                class="carousel__item"
                :src="image.link"
                alt="carousel image"
            /> -->
            <div class="carousel__item">{{ slide }}</div>
        </Slide>

        <template #addons>
            <Navigation />
        </template>
    </Carousel>
</template>

<script setup>
import { Carousel, Navigation, Slide } from "vue3-carousel";

import "vue3-carousel/dist/carousel.css";

const imageUrl = [
    {
        link: "assets/image/pastry.png",
    },
    {
        link: "assets/image/pastry.png",
    },
    {
        link: "assets/image/pastry.png",
    },
    {
        link: "assets/image/pastry.png",
    },
];
</script>

<style scoped>
.carousel__item {
    min-height: 300px;
    width: 100%;
    background-color: black;
    color: white;
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
    background-color: white;
}
</style>
