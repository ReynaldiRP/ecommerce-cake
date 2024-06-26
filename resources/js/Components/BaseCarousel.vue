<template>
    <Splide
        :options="options"
        @splide:moved="onMoved"
        aria-label="My Favorite Images"
        class="mt-4"
    >
        <SplideSlide
            class="flex flex-col justify-start items-center gap-2"
            v-for="(image, index) in imageUrl"
            :key="index"
        >
            <img
                class="bg-base-200 rounded-lg min-h-[400px]"
                :src="image.link"
                :class="{
                    'bg-primary-color': activeSlideIndex === index,
                }"
                alt="image"
            />
            <p
                class="text-xl text-white"
                :class="{
                    'font-bold': activeSlideIndex === index,
                }"
            >
                {{ image.name }}
            </p>
        </SplideSlide>
    </Splide>
</template>

<script setup>
import { reactive, ref } from "vue";
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import "@splidejs/vue-splide/css";

const options = reactive({
    rewind: true,
    fixedHeight: "450px",
    autoWidth: true,
    focus: "center",
    trimSpace: false,
    drag: true,
    pagination: false,
});

const imageUrl = [
    {
        link: "assets/image/pastry.png",
        name: "Pastry",
    },
    {
        link: "assets/image/hero-image.png",
        name: "Wedding Cake",
    },
    {
        link: "assets/image/home-image-cake.png",
        name: "Birthday Cake",
    },
    {
        link: "assets/image/pink-cake.png",
        name: "Birthday Cake",
    },
];

const activeSlideIndex = ref(0);
const onMoved = (Splide, newIndex, prevIndex, destIndex) => {
    activeSlideIndex.value = newIndex;
    console.log(newIndex);
};
</script>
<style scoped></style>
