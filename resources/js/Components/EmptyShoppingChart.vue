<template>
    <div
        tabindex="0"
        :class="{
            'card dropdown-content w-[420px] bg-white/95 backdrop-blur-lg shadow-card-lg border border-white/20 overflow-hidden rounded-3xl':
                !isMobileDisplayed,
            hidden: isMobileDisplayed,
        }"
    >
        <div class="p-6 text-center space-y-4">
            <!-- Empty State Icon -->
            <div
                class="w-14 h-14 mx-auto bg-gradient-to-r from-primary/10 to-accent/10 rounded-2xl flex items-center justify-center"
            >
                <i class="fas fa-shopping-cart text-xl text-primary/60"></i>
            </div>

            <!-- Empty State Content -->
            <div class="space-y-2">
                <h3 class="text-lg font-heading font-bold text-gray-900">
                    Keranjang Belanja Kosong
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Mulai belanja dan tambahkan kue favorit Anda ke keranjang!
                </p>
            </div>

            <!-- Action Button -->
            <inertia-link
                :href="route('home')"
                class="btn btn-modern bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover transition-all duration-300 shadow-card hover:shadow-card-hover transform hover:scale-[1.02] border-0 px-5 py-2 text-sm"
            >
                <i class="fas fa-search mr-2"></i>
                Mulai Belanja
            </inertia-link>
        </div>
    </div>
</template>

<script setup>
defineProps({
    isMobileDisplayed: {
        type: Boolean,
        default: false,
    },
});
</script>
