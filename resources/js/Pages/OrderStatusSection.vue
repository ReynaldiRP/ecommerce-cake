<template>
    <App>
        <section class="min-h-screen w-full bg-gradient-soft">
            <div class="container mx-auto px-6 lg:px-12 pt-24 pb-16">
                <div
                    v-for="order in orders"
                    :key="order.order_code"
                    class="space-y-8"
                >
                    <!-- Order Header -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
                    >
                        <div
                            class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6"
                        >
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                                    >
                                        <i
                                            class="fas fa-receipt text-white"
                                        ></i>
                                    </div>
                                    <h1
                                        class="text-2xl lg:text-3xl font-heading font-bold text-gray-900"
                                    >
                                        Detail Pesanan #{{ order.order_code }}
                                    </h1>
                                </div>

                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm"
                                >
                                    <div class="flex items-center space-x-2">
                                        <i
                                            class="fas fa-calendar-plus text-primary"
                                        ></i>
                                        <div>
                                            <span class="text-gray-600"
                                                >Dibuat:</span
                                            >
                                            <span
                                                class="font-semibold text-gray-900 ml-1"
                                                >{{
                                                    order.order_created_at
                                                }}</span
                                            >
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <i
                                            class="fas fa-truck text-primary"
                                        ></i>
                                        <div>
                                            <span class="text-gray-600"
                                                >Pengiriman:</span
                                            >
                                            <span
                                                class="font-semibold text-gray-900 ml-1"
                                                >{{
                                                    order.estimated_delivery
                                                }}</span
                                            >
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <i
                                            class="fas fa-shipping-fast text-primary"
                                        ></i>
                                        <div>
                                            <span class="text-gray-600"
                                                >Metode:</span
                                            >
                                            <span
                                                class="font-semibold text-gray-900 ml-1"
                                                >{{
                                                    order.method_delivery
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="px-6 py-3 bg-gradient-to-r from-primary/10 to-accent/10 rounded-2xl border border-primary/20"
                            >
                                <p class="text-lg font-bold text-primary">
                                    {{ order.order_status }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
                    >
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

                        <!-- Desktop Timeline -->
                        <div class="hidden lg:block">
                            <div class="relative">
                                <!-- Background Line -->
                                <div
                                    class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200"
                                ></div>

                                <div
                                    class="flex justify-between items-start mb-8"
                                >
                                    <div
                                        v-for="(
                                            status, index
                                        ) in combinedStatusHistory"
                                        :key="`${status.history_status}-${status.id}`"
                                        class="flex-1 relative flex flex-col items-center"
                                    >
                                        <!-- Active Timeline Line -->
                                        <div
                                            v-if="
                                                index <
                                                combinedStatusHistory.length - 1
                                            "
                                            class="absolute top-5 left-1/2 w-full h-0.5 bg-gradient-to-r from-primary to-accent z-0"
                                        ></div>

                                        <!-- Status Point -->
                                        <div
                                            class="relative z-10 flex flex-col items-center"
                                        >
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-soft mb-4 border-4 border-white"
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

                                            <div class="text-center max-w-xs">
                                                <div
                                                    class="bg-gray-50 rounded-2xl p-4 shadow-soft"
                                                >
                                                    <h3
                                                        class="font-semibold text-gray-900 mb-2"
                                                    >
                                                        {{ status.status }}
                                                    </h3>
                                                    <p
                                                        class="text-sm text-gray-600 mb-2"
                                                    >
                                                        {{ status.description }}
                                                    </p>
                                                    <div
                                                        class="flex items-center justify-center space-x-1 text-xs text-gray-500"
                                                    >
                                                        <i
                                                            class="fas fa-calendar-alt text-primary"
                                                        ></i>
                                                        <span>{{
                                                            status.created_at
                                                        }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tablet Timeline (iPad) -->
                        <div class="hidden md:block lg:hidden">
                            <div class="relative">
                                <div
                                    v-for="(
                                        status, index
                                    ) in combinedStatusHistory"
                                    :key="`tablet-${status.history_status}-${status.id}`"
                                    class="relative flex items-start space-x-6 pb-8"
                                    :class="{
                                        'pb-0':
                                            index ===
                                            combinedStatusHistory.length - 1,
                                    }"
                                >
                                    <!-- Timeline Line for Tablet - Centered and proper height -->
                                    <div
                                        v-if="
                                            index <
                                            combinedStatusHistory.length - 1
                                        "
                                        class="absolute left-6 top-6 w-0.5 bg-gradient-to-b from-primary to-accent"
                                        style="height: calc(100% + 0.5rem)"
                                    ></div>

                                    <!-- Status Icon for Tablet -->
                                    <div class="relative z-10 flex-shrink-0">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-soft border-4 border-white"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                class="w-6 h-6 text-white"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Status Content for Tablet -->
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="bg-gray-50 rounded-2xl p-6 shadow-soft"
                                        >
                                            <h3
                                                class="text-xl font-semibold text-gray-900 mb-3"
                                            >
                                                {{ status.status }}
                                            </h3>
                                            <p
                                                class="text-base text-gray-600 mb-4"
                                            >
                                                {{ status.description }}
                                            </p>
                                            <div
                                                class="flex items-center space-x-2 text-sm text-gray-500"
                                            >
                                                <i
                                                    class="fas fa-calendar-alt text-primary"
                                                ></i>
                                                <span class="font-medium">{{
                                                    status.created_at
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Timeline -->
                        <div class="md:hidden">
                            <div class="relative">
                                <div
                                    v-for="(
                                        status, index
                                    ) in combinedStatusHistory"
                                    :key="`mobile-${status.history_status}-${status.id}`"
                                    class="relative flex items-start space-x-4 pb-6"
                                    :class="{
                                        'pb-0':
                                            index ===
                                            combinedStatusHistory.length - 1,
                                    }"
                                >
                                    <!-- Timeline Line - Centered and proper height -->
                                    <div
                                        v-if="
                                            index <
                                            combinedStatusHistory.length - 1
                                        "
                                        class="absolute left-5 top-5 w-0.5 bg-gradient-to-b from-primary to-accent"
                                        style="height: calc(100% + 0.25rem)"
                                    ></div>

                                    <!-- Status Icon -->
                                    <div class="relative  z-10 flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-soft border-4 border-white"
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
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="bg-gray-50 rounded-2xl p-4 shadow-soft"
                                        >
                                            <h3
                                                class="text-lg font-semibold text-gray-900 mb-2"
                                            >
                                                {{ status.status }}
                                            </h3>
                                            <p
                                                class="text-sm text-gray-600 mb-3"
                                            >
                                                {{ status.description }}
                                            </p>
                                            <div
                                                class="flex items-center space-x-2 text-sm text-gray-500"
                                            >
                                                <i
                                                    class="fas fa-calendar-alt text-primary"
                                                ></i>
                                                <span class="font-medium">{{
                                                    status.created_at
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
                    >
                        <div class="flex items-center space-x-3 mb-8">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                            >
                                <i class="fas fa-birthday-cake text-white"></i>
                            </div>
                            <h2
                                class="text-xl lg:text-2xl font-heading font-bold text-gray-900"
                            >
                                Pesanan Kue
                            </h2>
                        </div>

                        <div class="space-y-6">
                            <div
                                v-for="(orderItem, index) in order.order_items"
                                :key="index"
                                class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-card transition-all duration-300"
                            >
                                <div
                                    class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4"
                                >
                                    <!-- Product Info -->
                                    <div
                                        class="flex items-center space-x-4 flex-1"
                                    >
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl overflow-hidden shadow-soft"
                                            >
                                                <img
                                                    :src="
                                                        orderItem.cake_image ??
                                                        '/assets/image/default-img.jpg'
                                                    "
                                                    :alt="orderItem.cake_name"
                                                    class="w-full h-full object-cover"
                                                />
                                            </div>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-lg lg:text-xl font-bold text-gray-900 mb-2"
                                            >
                                                {{ orderItem.cake_name }}
                                                <span
                                                    v-if="orderItem.cake_size"
                                                    class="text-primary"
                                                >
                                                    ({{
                                                        orderItem.cake_size
                                                    }}cm)
                                                </span>
                                            </h3>

                                            <div
                                                class="flex flex-wrap items-center gap-2 text-sm text-gray-600"
                                            >
                                                <div
                                                    v-if="
                                                        orderItem.cake_flavour
                                                    "
                                                    class="flex items-center space-x-1"
                                                >
                                                    <i
                                                        class="fas fa-palette text-primary text-xs"
                                                    ></i>
                                                    <span>{{
                                                        orderItem.cake_flavour
                                                    }}</span>
                                                </div>

                                                <div
                                                    v-if="
                                                        orderItem.cake_flavour &&
                                                        orderItem.cake_toppings
                                                            ?.length
                                                    "
                                                    class="text-gray-400"
                                                >
                                                    •
                                                </div>

                                                <div
                                                    v-if="
                                                        orderItem.cake_toppings
                                                            ?.length
                                                    "
                                                    class="flex items-center space-x-1"
                                                >
                                                    <i
                                                        class="fas fa-plus text-primary text-xs"
                                                    ></i>
                                                    <span>{{
                                                        orderItem.cake_toppings.join(
                                                            ", ",
                                                        )
                                                    }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quantity & Price -->
                                    <div
                                        class="flex items-center justify-between lg:justify-end gap-8 lg:gap-12"
                                    >
                                        <div class="text-center">
                                            <div
                                                class="text-xs text-gray-500 mb-1"
                                            >
                                                Jumlah
                                            </div>
                                            <div
                                                class="flex items-center justify-center w-8 h-8 bg-primary/10 rounded-lg"
                                            >
                                                <span
                                                    class="text-lg font-bold text-primary"
                                                    >{{
                                                        orderItem.quantity
                                                    }}</span
                                                >
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div
                                                class="text-xs text-gray-500 mb-1"
                                            >
                                                Harga
                                            </div>
                                            <div
                                                class="text-lg lg:text-xl font-bold text-gray-900"
                                            >
                                                {{
                                                    formatPrice(
                                                        orderItem.price[index],
                                                    )
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-end">
                                <div
                                    class="bg-gradient-to-r from-primary/10 to-accent/10 rounded-2xl p-6 border border-primary/20"
                                >
                                    <div class="flex items-center space-x-8">
                                        <span
                                            class="text-lg font-semibold text-gray-700"
                                            >Total Pesanan:</span
                                        >
                                        <span
                                            class="text-2xl font-bold text-primary"
                                        >
                                            {{ formatPrice(order.total_price) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import { computed } from "vue";
import { useOrderStatusStore } from "@/Stores/orderStatus.js";
import { storeToRefs } from "pinia";

const props = defineProps({
    orders: {
        type: Array,
        default: () => [],
    },
    statusHistory: Object,
});

const { orderInformationStatus } = storeToRefs(useOrderStatusStore());

const parsedDate = (dateString) => {
    const [time, date] = dateString.split(", ");
    const [hourMinute, second] = time.split(":");
    const [hour, minute] = hourMinute.split(".").map(Number);

    const months = {
        Januari: 0,
        Februari: 1,
        Maret: 2,
        April: 3,
        Mei: 4,
        Juni: 5,
        Juli: 6,
        Agustus: 7,
        September: 8,
        Oktober: 9,
        November: 10,
        Desember: 11,
    };

    const [day, monthName, year] = date.split(" ");
    const month = months[monthName];

    return new Date(year, month, day, hour, minute, Number(second));
};

/**
 * Combines the order and payment status history into a single array and sorts them by the created_at date.
 *
 * @returns {Array} - The combined status history of the order and payment.
 */
const combinedStatusHistory = computed(() => {
    const orderStatuses = props.statusHistory.map((status) =>
        status.order_statuses.map((orderStatus) => ({
            ...orderStatus,
            history_status: "order_status",
        })),
    );

    const paymentStatuses = props.statusHistory.map((status) => {
        if (status.payment_statuses) {
            return status.payment_statuses.map((paymentStatus) => ({
                ...paymentStatus,
                history_status: "payment_status",
            }));
        }

        return [];
    });

    // Combine the order and payment statuses
    const combineStatus = [
        ...paymentStatuses,
        ...orderStatuses,
        ...orderInformationStatus.value,
    ].flat();

    console.log(combineStatus);

    return combineStatus.sort((a, b) => {
        return parsedDate(a.created_at) - parsedDate(b.created_at);
    });
});

/**
 * Formats the price of an item by multiplying the price with the quantity.
 *
 * @param {number} price - The price of the item.
 * @returns {string} - The formatted price.
 */
const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};
</script>
