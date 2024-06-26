<template>
    <section
        class="h-screen flex flex-col justify-evenly items-center text-primary-color"
    >
        <div class="grid grid-cols-1 gap-4 px-14 place-items-center">
            <h1 class="font-bold text-xl lg:text-2xl">
                Try Our Customize Cake
            </h1>
            <p class="w-1/2 font-light text-lg lg:text-xl text-justify">
                Select from a wide range of flavors and mix-and-match your
                favorite toppings to design a cake that's uniquely yours.
                Whether it's for a birthday, wedding, or any special occasion,
                our customization options ensure every cake is made to suit your
                taste and style.
            </p>
        </div>
        <Carousel />
    </section>
</template>

<script setup>
import Carousel from "@/Components/BaseCarousel.vue";
</script>
