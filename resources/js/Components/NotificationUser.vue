<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div
            tabindex="0"
            role="button"
            class="btn btn-ghost btn-circle group relative transition-all duration-300 hover:bg-white/20 hover:scale-105"
        >
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    class="h-6 w-6 transition-all duration-300"
                    :class="
                        isNavbarHovered
                            ? 'fill-neutral-content group-hover:fill-primary'
                            : 'fill-base-100 group-hover:fill-primary'
                    "
                >
                    <path
                        d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"
                    />
                </svg>
                <span
                    v-if="orderStatus.length > 0"
                    class="badge badge-sm indicator-item bg-gradient-to-r from-primary to-accent text-white border-0 animate-pulse-gentle shadow-lg"
                >
                    {{ orderStatus.length }}
                </span>
            </div>
        </div>
        <div
            tabindex="0"
            class="z-[1] card card-compact dropdown-content w-[420px] max-h-[500px] bg-white/95 backdrop-blur-lg shadow-card-lg border border-white/20 overflow-hidden rounded-3xl"
        >
            <!-- Notification Header -->
            <div class="px-6 py-5 border-b border-gray-100/50">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M10 2L3 7v11h4v-6h6v6h4V7l-7-5z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h3
                            class="text-lg font-heading font-bold text-gray-900"
                        >
                            Notifikasi
                        </h3>
                        <span class="text-sm text-gray-500">
                            Status pesanan terbaru
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status Icons Grid -->
            <div class="px-6 py-4 border-b border-gray-100/50">
                <div class="grid grid-cols-3 gap-3">
                    <div
                        v-for="(status, index) in orderStatus"
                        :key="index"
                        class="group cursor-pointer"
                        @click="redirectLinkBasedOnOrderStatus(status.value)"
                    >
                        <div
                            class="flex flex-col items-center space-y-2 p-3 bg-white/70 rounded-2xl shadow-soft hover:shadow-card transition-all duration-300 group-hover:scale-105 border border-gray-100/50 group-hover:border-primary/20"
                        >
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl flex items-center justify-center group-hover:from-primary/20 group-hover:to-accent/20 transition-all duration-300"
                            >
                                <i
                                    :class="[
                                        status.icon,
                                        'text-primary group-hover:text-accent transition-colors duration-300 text-sm',
                                    ]"
                                ></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-gray-700 text-center group-hover:text-primary transition-colors duration-300 leading-tight"
                            >
                                {{ status.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Items -->
            <div class="max-h-72 overflow-y-auto aside-scrollbars-light">
                <div class="px-4 py-3 space-y-3">
                    <div
                        class="flex items-start gap-4 p-4 bg-white/80 rounded-2xl shadow-soft hover:shadow-card transition-all duration-300 border border-gray-100/50 hover:border-primary/20 group"
                        v-for="(notification, index) in combinedStatusHistory"
                        :key="index"
                    >
                        <div class="avatar flex-shrink-0">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-r from-primary/10 to-accent/10 flex items-center justify-center ring-2 ring-gray-100 group-hover:ring-primary/30 transition-all duration-300"
                            >
                                <img
                                    src="/assets/image/pastry.png"
                                    alt="Order notification"
                                    class="w-8 h-8 object-cover rounded-xl"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 flex-1 min-w-0">
                            <div class="space-y-1">
                                <p
                                    class="text-sm font-semibold text-gray-900 leading-relaxed group-hover:text-primary transition-colors duration-300"
                                >
                                    {{ notification.status }}
                                </p>
                                <p
                                    class="text-xs text-gray-600 leading-relaxed line-clamp-2"
                                >
                                    {{ notification.description }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <div
                                    class="w-1.5 h-1.5 bg-primary/50 rounded-full flex-shrink-0"
                                ></div>
                                <p class="text-xs font-medium text-gray-500">
                                    {{ notification.created_at }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="px-6 py-5 border-t border-gray-100/50">
                <inertia-link
                    :href="route('transaction-history')"
                    class="btn btn-modern w-full bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover transition-all duration-300 shadow-card hover:shadow-card-hover transform hover:scale-[1.02] border-0 py-3"
                >
                    <svg
                        class="w-5 h-5 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                    Lihat Riwayat Transaksi
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    link: {
        type: String,
    },
    isNavbarHovered: {
        type: Boolean,
        default: false,
    },
});

const notificationData = ref([]);
const orderStatus = [
    {
        icon: "fa-solid fa-spinner fa-lg",
        name: "Order Berjalan",
        value: "Berjalan",
    },
    {
        icon: "fa-solid fa-check-circle fa-lg",
        name: "Order Sukses",
        value: "Sukses",
    },
    {
        icon: "fa-solid fa-times-circle fa-lg",
        name: "Order Gagal",
        value: "Gagal",
    },
];

/**
 * Get the order and payment status history
 *
 * @return {Promise}
 */
const getStatusHistory = async () => {
    try {
        const response = await axios.get(route("notification-order-status"));
        notificationData.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

/**
 * Parses a relative time string (e.g., "10 jam yang lalu") and converts it to a Date object.
 *
 * @param {string} dateString - The relative time string to parse.
 * @returns {Date} - The Date object representing the parsed time.
 */
const parsedDate = (dateString) => {
    const timeUnits = {
        detik: 1 / 60,
        menit: 1,
        jam: 60,
        hari: 1440, // 24 * 60
        minggu: 10080, // 7 * 24 * 60
    };

    const parts = dateString.split(" ");
    const value = parseInt(parts[0]);
    const unit = parts[1];

    if (timeUnits[unit]) {
        const minutesAgo = value * timeUnits[unit];
        return new Date(Date.now() - minutesAgo * 60 * 1000); // Convert minutes to milliseconds
    }

    return new Date();
};

onMounted(async () => {
    await getStatusHistory();
});

/**
 * Computes the combined status history of orders and payments.
 *
 * @returns {Array} - An array of the top 3 most recent combined statuses.
 */
const combinedStatusHistory = computed(() => {
    const orderStatuses = notificationData.value.map((status) =>
        status.order_statuses.map((orderStatus) => ({
            ...orderStatus,
            history_status: "order_status",
        })),
    );

    const paymentStatuses = notificationData.value.map((status) => {
        if (status.payment_statuses) {
            return status.payment_statuses.map((paymentStatus) => ({
                ...paymentStatus,
                history_status: "payment_status",
            }));
        }

        return [];
    });

    return [...paymentStatuses, ...orderStatuses]
        .flat()
        .sort((a, b) => {
            return parsedDate(b.created_at) - parsedDate(a.created_at);
        })
        .slice(0, 3);
});

/**
 * Redirects the user to the appropriate page based on the order status.
 *
 * @param {string} status - The order status to redirect the user to.
 * @returns {void}
 */
const redirectLinkBasedOnOrderStatus = (status) => {
    Inertia.visit(route("transaction-history", { status }));
};
</script>
