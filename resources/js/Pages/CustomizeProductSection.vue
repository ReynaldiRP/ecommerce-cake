<template>
    <section class="h-screen flex flex-col items-center gap-6">
        <div class="grid grid-cols-1 gap-2 px-14 place-items-center">
            <h1 class="font-bold text-xl lg:text-2xl text-base-100">
                Ciptakan Kue Impianmu Sendiri! 🎂✨
            </h1>
            <p
                class="w-full md:w-3/4 lg:w-1/2 font-light text-lg lg:text-xl text-justify lg:text-center text-base-200"
            >
                Ingin kue yang benar-benar sesuai selera? Di sini, kamu bisa
                membuat kue spesial yang unik dan personal! Pilih ukuran, rasa,
                topping, dan hiasan sesuai keinginanmu. Dengan bahan berkualitas
                dan sentuhan kreativitasmu, setiap potongan jadi lebih dari
                sekadar kue – ini adalah ekspresi dirimu!
            </p>
        </div>
        <LayoutCarousel :options="options" :on-moved="onMoved">
            <ImageCarousel
                :cakes="props.cakes"
                :active-slide-index="activeSlideIndex"
            />
        </LayoutCarousel>
    </section>
</template>

<script setup>
import { reactive, ref, defineComponent } from "vue";
import LayoutCarousel from "@/Components/BaseCarousel/Layout.vue";
import ImageCarousel from "@/Components/BaseCarousel/Image.vue";
import "@splidejs/vue-splide/css";

const props = defineProps({
    cakes: {
        type: Object,
    },
});

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

const onMoved = (Splide, newIndex, prevIndex, destIndex) => {
    activeSlideIndex.value = newIndex;
};
</script>
