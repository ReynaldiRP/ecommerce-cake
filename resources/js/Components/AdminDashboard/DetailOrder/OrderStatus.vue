<template>
    <section class="w-full">
        <div
            class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
        >
            <!-- Header -->
            <div class="flex items-center space-x-3 mb-8">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                >
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h2
                    class="text-xl lg:text-2xl font-heading font-bold text-gray-900"
                >
                    Status Pesanan
                </h2>
            </div>

            <!-- Timeline -->
            <div class="relative">
                <div class="space-y-6">
                    <div
                        v-for="(order_status, index) in statuses"
                        :key="`${order_status.history_status}-${order_status.id}`"
                        class="relative flex items-start space-x-4"
                    >
                        <!-- Timeline Line -->
                        <div
                            v-if="index < statuses.length - 1"
                            class="absolute left-5 top-12 w-0.5 h-6 bg-gradient-to-b from-primary to-accent"
                        ></div>

                        <!-- Status Icon -->
                        <div class="relative z-10 flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-soft"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="w-5 h-5 text-white"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Status Content -->
                        <div class="flex-1 min-w-0 pb-4">
                            <div class="bg-gray-50 rounded-2xl p-4 shadow-soft">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ order_status.status }}
                                </h3>
                                <div
                                    class="flex items-center space-x-2 text-sm text-gray-600"
                                >
                                    <i
                                        class="fas fa-calendar-alt text-primary"
                                    ></i>
                                    <span class="font-medium">{{
                                        order_status.created_at
                                    }}</span>
                                </div>

                                <!-- Status Description -->
                                <div
                                    class="mt-3 p-3 bg-blue-50 rounded-xl border border-blue-100"
                                >
                                    <p class="text-sm text-blue-700">
                                        <span class="font-semibold">{{
                                            getStatusDescription(
                                                order_status.status,
                                            )
                                        }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    statuses: Array,
});

// Helper function to provide status descriptions
const getStatusDescription = (status) => {
    const descriptions = {
        "Menunggu pembayaran":
            "Silakan lakukan pembayaran untuk melanjutkan pesanan Anda.",
        "Pesanan dikonfirmasi":
            "Pesanan Anda telah dikonfirmasi dan sedang diproses.",
        "Pesanan diproses":
            "Tim kami sedang menyiapkan pesanan Anda dengan penuh perhatian.",
        "Pesanan dikemas":
            "Pesanan Anda sedang dikemas dengan rapi untuk pengiriman.",
        "Pesanan dikirim":
            "Pesanan Anda sedang dalam perjalanan menuju alamat tujuan.",
        "Pesanan diterima":
            "Pesanan Anda telah berhasil diterima. Terima kasih!",
        "Pesanan dibatalkan": "Pesanan ini telah dibatalkan.",
        "Pesanan terbayar": "Pembayaran berhasil diterima.",
    };

    return descriptions[status] || "Status pesanan telah diperbarui.";
};
</script>
