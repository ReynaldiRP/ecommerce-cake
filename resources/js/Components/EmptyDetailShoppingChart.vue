<template>
    <div class="xl:col-span-8">
        <div
            class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
        >
            <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-8">
                <!-- Illustration -->
                <div class="flex-shrink-0">
                    <img
                        src="/assets/image/cake-not-found.gif"
                        class="w-48 h-48 lg:w-56 lg:h-56 rounded-2xl shadow-card object-cover"
                        alt="Empty cart illustration"
                    />
                </div>

                <!-- Content -->
                <div class="flex-1 text-center lg:text-left space-y-4">
                    <!-- Heading -->
                    <div class="space-y-2">
                        <h1
                            class="text-2xl lg:text-3xl font-heading font-bold text-gray-900"
                        >
                            Ups! Keranjangmu masih kosong...
                        </h1>
                        <p
                            class="text-base lg:text-lg text-gray-600 leading-relaxed"
                        >
                            Saatnya mengisinya dengan kelezatan! 🍰
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 py-4">
                        <div class="flex items-center space-x-2 text-gray-600">
                            <div
                                class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center"
                            >
                                <i class="fas fa-star text-primary text-xs"></i>
                            </div>
                            <span class="text-sm font-medium"
                                >Kue premium berkualitas</span
                            >
                        </div>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <div
                                class="w-6 h-6 bg-accent/10 rounded-full flex items-center justify-center"
                            >
                                <i class="fas fa-truck text-accent text-xs"></i>
                            </div>
                            <span class="text-sm font-medium"
                                >Pengiriman cepat</span
                            >
                        </div>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <div
                                class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center"
                            >
                                <i
                                    class="fas fa-palette text-primary text-xs"
                                ></i>
                            </div>
                            <span class="text-sm font-medium"
                                >Kustomisasi sesuai selera</span
                            >
                        </div>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <div
                                class="w-6 h-6 bg-accent/10 rounded-full flex items-center justify-center"
                            >
                                <i class="fas fa-heart text-accent text-xs"></i>
                            </div>
                            <span class="text-sm font-medium"
                                >Dibuat dengan cinta</span
                            >
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div
                        class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start"
                    >
                        <inertia-link
                            :href="route('home')"
                            class="btn btn-modern bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover transition-all duration-300 shadow-card hover:shadow-card-hover transform hover:scale-[1.02] border-0 px-6 py-3 text-base"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Mulai Belanja Sekarang
                        </inertia-link>
                        <inertia-link
                            :href="route('products')"
                            class="btn btn-modern bg-white text-primary border-2 border-primary hover:bg-primary hover:text-white transition-all duration-300 shadow-soft hover:shadow-card px-6 py-3 text-base"
                        >
                            <i class="fas fa-list mr-2"></i>
                            Lihat Katalog
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup></script>
