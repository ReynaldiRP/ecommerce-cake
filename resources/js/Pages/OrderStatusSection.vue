<template>
    <App>
        <section class="min-h-screen w-full">
            <section
                v-for="order in orders"
                :key="order.order_code"
                class="min-h-screen flex flex-col py-[132px] lg:py-28 px-10 gap-8"
            >
                <!-- Order Details -->
                <div class="flex gap-4">
                    <div class="flex flex-col gap-2 justify-center">
                        <h1 class="text-3xl font-bold w-fit">
                            Detail Pesanan #{{ order.order_code }}
                        </h1>
                        <p class="text-sm">
                            Pesanan Dibuat:
                            <span class="font-bold">{{
                                order.order_created_at
                            }}</span>
                        </p>
                        <p class="text-sm flex gap-2">
                            Tanggal Pengiriman atau Pengambilan:
                            <span class="font-bold">{{
                                order.estimated_delivery
                            }}</span>
                        </p>
                        <p class="text-sm">
                            Metode Pengiriman:
                            <span class="font-bold">
                                {{ order.method_delivery }}
                            </span>
                        </p>
                    </div>
                    <div
                        class="badge text-xl bg-neutral text-primary-color py-4 px-6 rounded-lg font-bold relative top-1"
                    >
                        {{ order.order_status }}
                    </div>
                </div>

                <!-- Order status -->
                <section class="w-full my-8 flex justify-center items-center">
                    <ul
                        class="timeline timeline-vertical lg:timeline-horizontal"
                    >
                        <li
                            v-for="(status, index) in combinedStatusHistory"
                            :key="`${status.history_status}-${status.id}`"
                            class="h-[250px] lg:w-[250px]"
                        >
                            <hr v-if="combinedStatusHistory[index - 1]" />
                            <div
                                :class="
                                    index % 2 !== 0
                                        ? 'timeline-start'
                                        : 'timeline-end'
                                "
                            >
                                <div class="flex flex-col gap-1">
                                    <span class="text-lg font-medium">{{
                                        status.status
                                    }}</span>
                                    <span
                                        class="text-sm text-justify font-light"
                                        >{{ status.description }}</span
                                    >
                                    <span
                                        class="text-sm text-start font-light"
                                        >{{ status.created_at }}</span
                                    >
                                </div>
                            </div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary-color h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr v-if="combinedStatusHistory[index + 1]" />
                        </li>
                    </ul>
                </section>

                <!-- Order Item  -->
                <div class="flex flex-col gap-4 mt-6">
                    <h1 class="text-2xl font-bold">Item ordered</h1>
                    <div
                        v-for="(orderItem, index) in order.order_items"
                        :key="index"
                        class="w-full px-8 bg-neutral rounded-lg"
                    >
                        <div
                            class="flex justify-between items-center px-4 py-6"
                        >
                            <div class="flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-16 lg:w-20 rounded">
                                        <img
                                            :src="
                                                orderItem.cake_image ??
                                                '/assets/image/default-img.jpg'
                                            "
                                            alt="Tailwind-CSS-Avatar-component"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h1
                                        class="font-bold text-base md:text-lg lg:text-xl m-0"
                                    >
                                        {{ orderItem.cake_name }}
                                        <span v-if="orderItem.cake_size"
                                            >({{ orderItem.cake_size }}Cm)</span
                                        >
                                    </h1>
                                    <div
                                        class="flex flex-col lg:flex-row gap-0 lg:gap-1 text-sm md:text-base lg:text-lg font-medium text-opacity-70"
                                    >
                                        <p>
                                            {{ orderItem.cake_flavour }}
                                        </p>
                                        <p
                                            v-if="
                                                orderItem.cake_flavour &&
                                                orderItem.cake_toppings
                                            "
                                        >
                                            |
                                        </p>
                                        <p>
                                            {{
                                                orderItem.cake_toppings.join(
                                                    ", ",
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-lg">{{ orderItem.quantity }}</p>
                            <p class="text-lg">
                                {{ formatPrice(orderItem.price[index]) }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="w-fit ms-auto px-12 py-4 flex flex-col gap-12 bg-neutral rounded-lg"
                    >
                        <div class="flex gap-24">
                            <h1 class="text-xl font-bold">Product Total:</h1>
                            <span class="text-lg font-bold">{{
                                formatPrice(order.total_price)
                            }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import { computed } from "vue";
import { useOrderStatusStore } from "@/Stores/orderStatus.js";
import { storeToRefs } from "pinia";
import { Inertia } from "@inertiajs/inertia";

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
