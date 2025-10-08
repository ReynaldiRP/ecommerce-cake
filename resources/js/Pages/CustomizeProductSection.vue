<template>
    <section class="py-20 bg-gradient-soft relative overflow-hidden">
        <!-- Background Decoration -->
        <div
            class="absolute top-0 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl"
        ></div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-16 fade-in-up">
                <h2
                    class="text-4xl md:text-5xl font-heading font-bold text-gray-800 mb-6"
                >
                    Ciptakan Kue
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent"
                    >
                        Impianmu
                    </span>
                    Sendiri! 🎂✨
                </h2>
                <p
                    class="text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto"
                >
                    Ingin kue yang benar-benar sesuai selera? Di sini, kamu bisa
                    membuat kue spesial yang unik dan personal! Pilih ukuran,
                    rasa, topping, dan hiasan sesuai keinginanmu. Dengan bahan
                    berkualitas dan sentuhan kreativitasmu, setiap potongan jadi
                    lebih dari sekadar kue – ini adalah ekspresi dirimu!
                </p>

                <!-- Feature Icons -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16">
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-lg">
                            Ukuran Fleksibel
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Sesuai kebutuhan
                        </p>
                    </div>
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-accent to-secondary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-lg">
                            50+ Rasa
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Pilihan berlimpah
                        </p>
                    </div>
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-secondary to-warning rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-lg">
                            Topping Premium
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Kualitas terjamin
                        </p>
                    </div>
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-success to-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-lg">
                            Bahan Terbaik
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">100% fresh</p>
                    </div>
                </div>
            </div>

            <!-- Carousel Section -->
            <div class="fade-in-up">
                <LayoutCarousel :options="options" :on-moved="onMoved">
                    <ImageCarousel
                        :cakes="props.cakes"
                        :active-slide-index="activeSlideIndex"
                    />
                </LayoutCarousel>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-20 fade-in-up">
                <inertia-link
                    :href="route('products')"
                    class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-primary to-accent rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 group"
                >
                    <span>Mulai Customize Sekarang</span>
                    <svg
                        class="w-5 h-5 ml-3 transform group-hover:translate-x-1 transition-transform"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                        />
                    </svg>
                </inertia-link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from "vue";
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
