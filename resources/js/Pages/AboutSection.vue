<template>
    <section class="py-20 lg:py-32 bg-white relative overflow-hidden">
        <!-- Background decoration -->
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 left-1/4 w-64 h-64 bg-accent/5 rounded-full blur-3xl"
        ></div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Image Section -->
                <div class="order-2 lg:order-1 fade-in-up">
                    <div class="relative">
                        <!-- Image container with modern styling -->
                        <div
                            class="relative overflow-hidden rounded-3xl shadow-card-lg group"
                        >
                            <img
                                src="/assets/image/default-img.jpg"
                                alt="Dream Dessert Story"
                                class="w-full h-[400px] lg:h-[500px] object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <!-- Overlay gradient -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            ></div>
                        </div>

                        <!-- Floating badge -->
                        <div
                            class="absolute -bottom-6 -right-6 bg-gradient-to-r from-primary to-accent text-white px-6 py-3 rounded-2xl shadow-xl"
                        >
                            <div class="text-center">
                                <div class="text-2xl font-bold">2021</div>
                                <div class="text-sm opacity-90">Sejak</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="order-1 lg:order-2 fade-in-up">
                    <div class="space-y-8">
                        <!-- Header -->
                        <div>
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
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                                Cerita Kami
                            </div>
                            <h2
                                class="text-4xl lg:text-5xl font-heading font-bold text-gray-900 mb-6 leading-tight"
                            >
                                Perjalanan
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent"
                                >
                                    Dream Dessert
                                </span>
                            </h2>
                        </div>

                        <!-- Story Content -->
                        <div class="space-y-6">
                            <p class="text-lg text-gray-700 leading-relaxed">
                                Dream Dessert adalah UMKM yang bergerak di
                                industri makanan, khususnya pembuatan kue sejak
                                <span class="font-semibold text-primary"
                                    >2021</span
                                >. Berlokasi di Kecamatan Mojoroto, Jl. Kawi
                                Gang 2, Kota Kediri, Jawa Timur 64112, kami
                                menghadirkan berbagai pilihan kue seperti tart,
                                kue pernikahan, puding, dan brownies.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                Untuk tart dan kue pernikahan, Anda bebas
                                memilih varian dan topping sesuai keinginan.
                                Kami mengundang Anda untuk berkunjung langsung
                                ke tempat kami di Kediri atau menjelajahi
                                pilihan kue kami secara online.
                            </p>
                        </div>

                        <!-- Highlights -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8">
                            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                                <div
                                    class="text-2xl font-bold text-primary mb-2"
                                >
                                    4+
                                </div>
                                <div class="text-gray-600 font-medium">
                                    Tahun Berpengalaman
                                </div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                                <div
                                    class="text-2xl font-bold text-primary mb-2"
                                >
                                    500+
                                </div>
                                <div class="text-gray-600 font-medium">
                                    Kue Terjual
                                </div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                                <div
                                    class="text-2xl font-bold text-primary mb-2"
                                >
                                    100%
                                </div>
                                <div class="text-gray-600 font-medium">
                                    Custom Made
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="pt-6">
                            <inertia-link
                                :href="route('products')"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-accent text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 group font-semibold"
                            >
                                <span>Lihat Produk Kami</span>
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
            </div>
        </div>
    </section>
</template>

<script setup></script>
