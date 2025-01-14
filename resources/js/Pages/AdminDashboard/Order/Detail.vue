<template>
    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />

    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-8">
            <section class="flex items-center justify-between">
                <h1 class="text-3xl font-medium text-neutral">
                    Order Detail : #{{ ordersData.order_code }}
                </h1>
                <div class="flex items-center justify-end gap-2">
                    <div class="flex flex-col gap-1">
                        <small class="text-base-300 font-medium"
                            >Status Pesanan</small
                        >
                        <div
                            class="btn btn-outline"
                            :class="orderStatusColor[order.status]"
                            @click="
                                () => {
                                    if (order.status !== 'Pesanan dibatalkan')
                                        editOrderStatus(order);
                                }
                            "
                        >
                            {{ ordersData.status }}
                        </div>
                    </div>
                    <CardBoxModal
                        v-model="modalActive"
                        title="Ubah Status Pemesanan"
                        class="backdrop-contrast-50"
                        button-label="Simpan"
                        button="success"
                        :click-handler="() => updateOrderStatus(orderId)"
                    >
                        <div>
                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text font-medium"
                                        >Status Pesanan</span
                                    >
                                </div>
                                <select
                                    class="select select-ghost select-bordered"
                                    v-model="currentOrderStatus"
                                >
                                    <option disabled>
                                        {{ currentOrderStatus }}
                                    </option>
                                    <option
                                        v-for="status in orderStatusFiltered(
                                            order,
                                        )"
                                        :key="status.id"
                                    >
                                        {{ status.name }}
                                    </option>
                                </select>
                            </label>
                            <label
                                v-show="
                                    currentOrderStatus === 'Pesanan diterima'
                                "
                                class="form-control w-full max-w-xs"
                            >
                                <div class="label">
                                    <span class="label-text">
                                        Bukti penerimaan pesanan
                                    </span>
                                </div>
                                <input
                                    type="file"
                                    class="file-input file-input-ghost file-input-bordered w-full max-w-xs"
                                />
                            </label>
                        </div>
                    </CardBoxModal>
                    <NotificationBar
                        class="w-[50%]"
                        v-if="message"
                        color="success"
                        :icon="mdiCheckCircle"
                    >
                        {{ message }}
                    </NotificationBar>
                </div>
            </section>
            <section class="grid grid-cols-12 bg-slate-100 shadow-lg">
                <!--       Detail Order         -->
                <section
                    class="col-span-8 flex flex-col px-4 py-6 border rounded-l-lg border-neutral"
                >
                    <RecipientAddress :order="order" :address="address" />
                    <OrderItem :order="order" />
                    <OrderSummary
                        :order="order"
                        :order-subtotal="orderSubTotal"
                    />
                </section>
                <!--       Order Track          -->
                <section
                    class="col-span-4 p-4 border-y border-r rounded-r-lg border-neutral"
                >
                    <h1 class="text-lg font-medium text-neutral">
                        Order Status History
                    </h1>
                    <OrderStatus :statuses="combinedStatusHistory" />
                </section>
            </section>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import RecipientAddress from "@/Components/AdminDashboard/DetailOrder/RecipientAddress.vue";
import OrderItem from "@/Components/AdminDashboard/DetailOrder/OrderItem.vue";
import OrderSummary from "@/Components/AdminDashboard/DetailOrder/OrderSummary.vue";
import OrderStatus from "@/Components/AdminDashboard/DetailOrder/OrderStatus.vue";
import { computed, ref } from "vue";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import axios from "axios";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { mdiCheckCircle } from "@mdi/js";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { useOrderStatusStore } from "@/Stores/orderStatus.js";
import { storeToRefs } from "pinia";

const props = defineProps({
    order: Object,
    statusHistory: Array,
});

const { orderInformationStatus } = storeToRefs(useOrderStatusStore());
// const orderInformationStatus = ref([]);
const currentOrderStatus = ref("");
const isLoading = ref(false);
const orderStatus = [
    {
        id: 1,
        name: "Pesanan diproses",
    },
    {
        id: 2,
        name: "Pesanan dikemas",
    },
    {
        id: 3,
        name: "Pesanan dikirim",
    },
    {
        id: 4,
        name: "Pesanan diterima",
    },
];
const orderId = ref("");
const message = ref("");
const modalActive = ref(false);
const ordersData = ref(props.order);

/**
 * Splits an address string into its components: street name, city, and province.
 *
 * @param {string} address - The full address string, expected to be comma-separated.
 * @returns {Object} An object containing the street_name, city, and province.
 */
const separateAddress = (address) => {
    const parts = address.split(",").map((part) => part.trim());

    // Take first two parts for street_name, and rest for city and province
    const street_name = parts.slice(0, 2).join(", ");
    const city = parts[2];
    const province = parts[3];

    return { street_name, city, province };
};

const address = separateAddress(props.order.user_address);

/**
 * Computes the subtotal of the order by summing the total price of each item.
 *
 * @returns {number} The subtotal of the order.
 */
const orderSubTotal = computed(() => {
    return props.order.order_items
        ?.map((item) => {
            return item.price * item.quantity;
        })
        .reduce((acc, curr) => acc + curr, 0);
});

/**
 * Filters the order statuses to exclude the current status of the given order.
 * @param {Object} order - The order object containing the current status.
 * @returns {Array} An array of order statuses excluding the current status.
 */
const orderStatusFiltered = (order) => {
    return orderStatus.filter((status) => status.name !== order.status);
};

/**
 * Computed property that returns a mapping of order statuses to their corresponding button classes.
 *
 * @returns {Object} An object where the keys are order statuses and the values are button classes.
 */
const orderStatusColor = computed(() => {
    return {
        "Pesanan diproses": "btn-info",
        "Pesanan dikonfirmasi": "btn-info",
        "Pesanan dikemas": "btn-info",
        "Pesanan dikirim": "btn-info",
        "Pesanan diterima": "btn-success",
        "Pesanan dibatalkan": "btn-error cursor-not-allowed",
        "Pesanan kadaluwarsa": "btn-error",
    };
});

/**
 * Edits the status of the given order.
 *
 * @param {Object} order - The order object containing the order ID.
 */
const editOrderStatus = async (order) => {
    try {
        const response = await axios.get(
            route("order.edit-status", { order: order.id }),
            {
                params: {
                    order: order.id,
                },
            },
        );

        currentOrderStatus.value = response.data.order.status;
        orderId.value = response.data.order.id;
        modalActive.value = true;
    } catch (e) {
        console.error(e);
    }
};

/**
 * Updates the status of the given order.
 *
 * @param {Object} order - The order object containing the order ID.
 */
const updateOrderStatus = async (order) => {
    try {
        const response = await axios.patch(
            route("order.update-status", { orderId: order }),
            {
                status: currentOrderStatus.value,
            },
            {
                params: {
                    orderId: order,
                },
            },
        );

        isLoading.value = true;

        setTimeout(() => {
            isLoading.value = false;
            modalActive.value = false;
            ordersData.value.status = response.data.order.status;
            orderInformationStatus.value = [
                ...orderInformationStatus.value,
                response.data.order,
            ];

            message.value = response.data.message;
        }, 2000);
    } catch (e) {
        console.error(e);
    }
};

/**
 * Parses a date string and returns a JavaScript Date object.
 *
 * @param {string} dateString - The date string to parse, expected to be in the format "day monthName year, hour:minute:second".
 * @returns {Date} A JavaScript Date object representing the parsed date and time.
 */
const parsedDate = (dateString) => {
    const [datePart, timePart] = dateString.split(", ");
    const [day, monthName, year] = datePart.split(" ");
    const [hour, minute, second] = timePart.split(":").map(Number);

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

    const month = months[monthName];
    return new Date(year, month, Number(day), hour, minute, second);
};

/**
 * Combines the order and payment status history into a single array and sorts them by the created_at date.
 *
 *
 * @returns {Array} - The combined status history of the order and payment.
 */
const combinedStatusHistory = computed(() => {
    const orderStatuses = props.statusHistory.flatMap((status) =>
        status.order_statuses.map((orderStatus) => ({
            ...orderStatus,
            history_status: "order_status",
        })),
    );

    const paymentStatuses = props.statusHistory.flatMap((status) => {
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

    return combineStatus.sort((a, b) => {
        return parsedDate(a.created_at) - parsedDate(b.created_at);
    });
});
</script>
