<template>
    <div
        class="min-h-screen flex items-center justify-center relative overflow-hidden"
    >
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-primary opacity-95"></div>
        <div
            class="absolute inset-0 bg-[url('/assets/image/home-image-cake.png')] bg-no-repeat bg-right bg-contain opacity-10"
        ></div>

        <!-- Decorative Elements -->
        <div
            class="absolute top-20 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-bounce-gentle"
        ></div>
        <div
            class="absolute bottom-20 left-20 w-24 h-24 bg-accent/20 rounded-full blur-lg"
        ></div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content Section -->
                <div class="text-center lg:text-left fade-in-up">
                    <div class="mb-8">
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-white mb-6 leading-tight"
                        >
                            Buat Kue
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300"
                            >
                                Impian
                            </span>
                            Anda
                        </h1>
                        <p
                            class="text-xl md:text-2xl text-white/90 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0"
                        >
                            Dari kue pernikahan yang elegan hingga brownies
                            lezat dan pastry yang menggugah selera. Wujudkan
                            keinginan manis Anda bersama kami! ✨
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8"
                    >
                        <inertia-link
                            :href="route('products')"
                            class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-xl hover:bg-white hover:text-gray-900 transition-all duration-300 group shadow-lg"
                        >
                            <span>Jelajahi Katalog</span>
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

                    <!-- Stats -->
                    <div
                        class="grid grid-cols-3 gap-8 pt-8 border-t border-white/30"
                    >
                        <div class="text-center">
                            <div
                                class="text-2xl md:text-3xl font-bold text-white mb-1"
                            >
                                500+
                            </div>
                            <div class="text-white/90 text-sm font-medium">
                                Kue Terjual
                            </div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-2xl md:text-3xl font-bold text-white mb-1"
                            >
                                4.9★
                            </div>
                            <div class="text-white/90 text-sm font-medium">
                                Rating
                            </div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-2xl md:text-3xl font-bold text-white mb-1"
                            >
                                50+
                            </div>
                            <div class="text-white/90 text-sm font-medium">
                                Varian Rasa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="hidden lg:flex justify-center items-center">
                    <div class="relative">
                        <div
                            class="w-96 h-96 bg-white/10 rounded-full absolute -top-4 -left-4 animate-pulse"
                        ></div>
                        <img
                            src="/assets/image/home-image-cake.png"
                            alt="Delicious Cake"
                            class="relative z-10 w-80 h-80 object-contain filter drop-shadow-2xl animate-bounce-gentle"
                        />
                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-64 h-8 bg-black/20 rounded-full blur-lg"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div
            class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce"
        >
            <svg
                class="w-6 h-6 text-white/60"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 14l-7 7m0 0l-7-7m7 7V3"
                />
            </svg>
        </div>
    </div>
</template>

<script setup></script>
