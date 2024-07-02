<template>
    <section
        class="h-screen flex flex-col items-center gap-6 text-primary-color"
    >
        <div class="grid grid-cols-1 gap-2 px-14 place-items-center">
            <h1 class="font-bold text-xl lg:text-2xl">
                Try Our Customize Cake
            </h1>
            <p
                class="w-full md:w-3/4 lg:w-1/2 font-light text-lg lg:text-xl text-justify lg:text-center"
            >
                Select from a wide range of flavors and mix-and-match your
                favorite toppings to design a cake that's uniquely yours.
            </p>
        </div>
        <Splide
            :options="options"
            @splide:moved="onMoved"
            @splide:click="onClick"
            aria-label="My Favorite Images"
        >
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
        </Splide>
    </section>
</template>

<script setup>
import { reactive, ref, defineComponent } from "vue";
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import "@splidejs/vue-splide/css";

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

const options = reactive({
    rewind: true,
    fixedHeight: 450,
    width: "100%",
    perPage: 3,
    focus: "center",
    padding: "5%",
    gap: "1rem",
    drag: true,
    pagination: false,
    paginationDirection: "ttb",
    arrows: true,
    lazyload: true,
    breakpoints: {
        1024: {
            perPage: 2,
            gap: "3rem",
        },
        640: {
            perPage: 1,
        },
    },
});

const activeSlideIndex = ref(0);
const splideIndex = ref(null);

const onMoved = (Splide, newIndex, prevIndex, destIndex) => {
    activeSlideIndex.value = newIndex;
};

const onClick = (Splide, Slide, e) => {
    splideIndex.value = Slide;
};
</script>
