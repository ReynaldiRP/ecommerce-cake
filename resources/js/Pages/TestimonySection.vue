<template>
    <section class="py-20 lg:py-32 bg-gradient-soft relative overflow-hidden">
        <!-- Background decoration -->
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 right-1/4 w-64 h-64 bg-accent/5 rounded-full blur-3xl"
        ></div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-16 fade-in-up">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-6"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />
                    </svg>
                    Testimoni
                </div>
                <h2
                    class="text-4xl md:text-5xl font-heading font-bold text-gray-900 mb-6"
                >
                    Apa Yang Dikatakan
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent"
                    >
                        Pelanggan Kami
                    </span>
                </h2>
                <p
                    class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto"
                >
                    Kepuasan pelanggan adalah prioritas utama kami. Simak cerita
                    mereka tentang pengalaman manis bersama Dream Dessert.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16"
            >
                <div
                    v-for="(testimonial, index) in testimonials"
                    :key="index"
                    class="fade-in-up bg-white rounded-3xl shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-2 group"
                    :style="{ animationDelay: `${index * 0.1}s` }"
                >
                    <!-- Card Content -->
                    <div class="p-8">
                        <!-- Quote Icon -->
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform"
                        >
                            <svg
                                class="w-6 h-6 text-white"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"
                                />
                            </svg>
                        </div>

                        <!-- Testimonial Text -->
                        <blockquote
                            class="text-gray-700 text-lg leading-relaxed mb-6"
                        >
                            "{{ testimonial.text }}"
                        </blockquote>

                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 mb-6">
                            <svg
                                v-for="star in 5"
                                :key="star"
                                class="w-5 h-5 text-yellow-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                />
                            </svg>
                        </div>

                        <!-- Customer Info -->
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img
                                    :src="testimonial.avatar"
                                    :alt="testimonial.name"
                                    class="w-16 h-16 rounded-full object-cover ring-4 ring-primary/10"
                                />
                                <!-- Verified badge -->
                                <div
                                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-3 h-3 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="3"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-lg">
                                    {{ testimonial.name }}
                                </h4>
                                <p class="text-gray-600">
                                    {{ testimonial.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center fade-in-up">
                <div
                    class="bg-white rounded-3xl shadow-card p-8 md:p-12 max-w-2xl mx-auto"
                >
                    <h3
                        class="text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-4"
                    >
                        Siap Menjadi Bagian dari Keluarga Dream Dessert?
                    </h3>
                    <p class="text-gray-600 text-lg mb-8">
                        Bergabunglah dengan ribuan pelanggan yang telah
                        merasakan kelezatan kue-kue istimewa kami.
                    </p>
                    <inertia-link
                        :href="route('products')"
                        class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary to-accent text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 group font-semibold text-lg"
                    >
                        <span>Pesan Sekarang</span>
                        <svg
                            class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform"
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
        </div>
    </section>
</template>

<script setup>
import { ref } from "vue";

// Sample testimonial data - you can replace this with real data from your backend
const testimonials = ref([
    {
        id: 1,
        name: "Sarah Wijaya",
        title: "Ibu Rumah Tangga",
        avatar: "/assets/image/default-img.jpg",
        text: "Kue ulang tahun dari Dream Dessert sangat lezat! Anak saya sangat senang dengan rasa coklat yang tidak terlalu manis. Pelayanannya juga sangat ramah dan pengiriman tepat waktu.",
    },
    {
        id: 2,
        name: "Budi Santoso",
        title: "Pengusaha",
        avatar: "/assets/image/default-img.jpg",
        text: "Wedding cake yang dibuat Dream Dessert untuk pernikahan kami benar-benar melebihi ekspektasi. Desainnya cantik dan rasanya luar biasa. Semua tamu memuji kelezatannya!",
    },
    {
        id: 3,
        name: "Maya Kusuma",
        title: "Karyawan Swasta",
        avatar: "/assets/image/default-img.jpg",
        text: "Brownies dan tart dari Dream Dessert selalu jadi pilihan utama untuk acara kantor. Kualitasnya konsisten dan harganya sangat terjangkau. Highly recommended!",
    },
]);
</script>
