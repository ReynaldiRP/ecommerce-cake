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
        <Carousel />
    </section>
</template>

<script setup>
import Carousel from "@/Components/BaseCarousel.vue";
</script>
