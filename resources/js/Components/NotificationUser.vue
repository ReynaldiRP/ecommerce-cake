<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    fill="currentColor"
                    class="h-5 w-5"
                    stroke="currentColor"
                >
                    <path
                        d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"
                    />
                </svg>
                <span class="badge badge-sm indicator-item">8</span>
            </div>
        </div>
        <div
            tabindex="0"
            class="z-[1] card card-compact dropdown-content w-96 max-h-96 bg-base-100 shadow-xl p-3 overflow-auto"
        >
            <div
                class="flex justify-between items-center text-base font-medium py-2"
            >
                <p class="text-lg">Notification</p>
            </div>
            <div
                class="grid grid-flow-col-dense place-items-center pt-2 px-2 border-b-2 border-base-content"
            >
                <div
                    v-for="(status, index) in orderStatus"
                    :key="index"
                    class="py-2"
                >
                    <div
                        class="flex gap-1 flex-col text-center text-primary-color"
                    >
                        <i :class="status.icon"></i>
                        <span class="text-sm">{{ status.name }}</span>
                    </div>
                </div>
            </div>

            <inertia-link
                class="card-body flex-row gap-4 mt-2 rounded-lg bg-neutral"
                v-for="(notification, index) in combinedStatusHistory"
                :key="index"
                :href="link"
            >
                <div class="avatar">
                    <div class="w-16 rounded-lg bg-primary-color">
                        <img src="/assets/image/pastry.png" alt="" />
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex flex-col">
                        <p class="text-base text-justify">
                            {{ notification.status }}
                        </p>
                        <p class="text-sm font-light">
                            {{ notification.description }}
                        </p>
                    </div>
                    <p class="text-sm font-light">
                        {{ notification.created_at }}
                    </p>
                </div>
            </inertia-link>
            <div class="card-actions my-2">
                <inertia-link
                    :href="route('transaction-history')"
                    class="btn btn-sm bg-primary-color text-slate-700 hover:text-white btn-block"
                >
                    View Transaction
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";

const props = defineProps({
    link: {
        type: String,
    },
});

const notificationData = ref([]);
const orderStatus = [
    {
        icon: "fa-solid fa-clock fa-lg",
        name: "Wait For Confirmation",
    },
    {
        icon: "fa-solid fa-spinner fa-lg",
        name: "Order Process",
    },
    {
        icon: "fa-solid fa-truck fa-lg",
        name: "Order Delivery",
    },
    {
        icon: "fa-solid fa-location-dot fa-lg",
        name: "Order Complete",
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
    console.log(combinedStatusHistory.value);
});

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

    return [...paymentStatuses, ...orderStatuses].flat().sort((a, b) => {
        return parsedDate(b.created_at) - parsedDate(a.created_at);
    });
});
</script>
