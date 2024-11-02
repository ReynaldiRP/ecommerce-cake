<template>
    <App>
        <section class="min-h-screen w-full py-28 px-10">
            <!-- breadcrumbs page -->
            <aside class="breadcrumbs text-sm me-auto relative">
                <ul>
                    <li>
                        <inertia-link :href="route('home')">Home</inertia-link>
                    </li>
                    <li>
                        <inertia-link :href="route('order.history')"
                            >Transaction History
                        </inertia-link>
                    </li>
                </ul>
            </aside>

            <!-- header content -->
            <section class="flex items-center gap-2 mt-4">
                <h1 class="text-2xl font-bold">Transaction Lists</h1>
                <div
                    class="px-3 rounded-lg bg-primary-color text-black font-medium text-lg"
                >
                    {{ orderItems.total }}
                </div>
            </section>

            <!-- transaction history filter -->
            <section class="mt-4 flex items-center justify-between">
                <section class="flex flex-col gap-2">
                    <div role="tablist" class="tabs tabs-boxed font-bold">
                        <a
                            v-for="(filter, index) in transactionFilter"
                            :key="index"
                            role="tab"
                            class="tab"
                            :class="{
                                'tab-active': transactionTabsClicked[index],
                            }"
                            @click="handleTransactionTabClick(index)"
                            >{{ filter }}</a
                        >
                    </div>

                    <div
                        v-if="transactionTabsClicked[1]"
                        role="tablist"
                        class="tabs tabs-boxed font-medium"
                    >
                        <a
                            v-for="(status, index) in orderStatus"
                            role="tab"
                            class="tab"
                            :class="{
                                'tab-active': orderStatusTabsClicked[index],
                            }"
                            @click="handleOrderStatusTabClick(index)"
                            >{{ status }}</a
                        >
                    </div>
                </section>

                <select
                    class="select select-bordered w-full max-w-xs"
                    @change="
                        onChangeTransactionDate($event.target.selectedIndex)
                    "
                >
                    <option disabled selected>Select Transaction Months</option>
                    <option v-for="(month, index) in months" :key="index">
                        {{ month }}
                    </option>
                </select>
            </section>

            <!-- transaction history content -->
            <section
                class="flex flex-col gap-4 mt-4 p-4 border-2 border-neutral rounded-lg shadow-lg"
            >
                <!-- Iterate over each order group (list of orders per transaction) -->
                <section
                    v-for="(order, orderIndex) in originalOrderItems"
                    :key="order.transaction_id + orderIndex"
                    class="flex flex-col gap-4"
                >
                    <!-- Iterate over each individual order -->
                    <section
                        class="rounded-lg flex flex-col gap-4 border-2 border-neutral p-4"
                    >
                        <!-- Transaction Detail -->
                        <section class="flex items-center gap-2 text-xl">
                            <p>
                                {{ order.order_created_at }}
                            </p>
                            <div
                                class="badge badge-outline font-medium text-lg"
                                :class="
                                    changeBadgeColorOrderOrPaymentStatus(order)
                                "
                            >
                                {{ order.transaction_status ?? "" }}
                            </div>
                            <p class="font-extralight">
                                {{ order.transaction_id || order.order_code }}
                            </p>
                            <div
                                class="badge badge-outline badge-info font-medium text-lg"
                            >
                                {{ order.order_status }}
                            </div>
                        </section>

                        <!-- Transaction Image and Details -->
                        <section class="flex items-center justify-between">
                            <div class="flex gap-4">
                                <div class="avatar">
                                    <div class="w-28 rounded">
                                        <img
                                            src="/assets/image/default-img.jpg"
                                            alt="Cake Image"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-lg font-bold">
                                        {{ order.cake_name }}
                                    </p>
                                    <p
                                        v-if="order.cake_flavour"
                                        class="font-medium"
                                    >
                                        {{ order.cake_flavour }}
                                    </p>
                                    <div
                                        v-if="order.cake_toppings.length"
                                        class="flex gap-2"
                                    >
                                        <p class="font-medium">
                                            {{ order.cake_toppings.join(", ") }}
                                        </p>
                                    </div>
                                    <p class="font-light">
                                        {{ order.quantity }} Cake x Rp.{{
                                            formatPrice(order.price)
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col text-xl pr-36">
                                <p>Total Order</p>
                                <strong>{{
                                    formatPrice(
                                        totalPrice(order.price, order.quantity)
                                    )
                                }}</strong>
                            </div>
                        </section>

                        <!-- Transaction CTA -->
                        <section class="ms-auto flex gap-4 items-center">
                            <inertia-link
                                :href="
                                    route(
                                        'detail-transaction',
                                        order.order_code
                                    )
                                "
                                class="link text-primary-color"
                                >See Detail Transaction</inertia-link
                            >
                            <inertia-link
                                v-if="showPayNowButton(order)"
                                href="#"
                                @click="redirectPayment(order.payment_url)"
                                class="btn btn-outline btn-info font-semibold"
                            >
                                Pay Now
                            </inertia-link>
                            <button
                                v-else
                                class="btn btn-success font-semibold"
                            >
                                Buy Again
                            </button>
                        </section>
                    </section>
                </section>
                <!-- Filtered Data not found -->
                <section v-if="originalOrderItems.length <= 0">
                    <p>
                        Oops! Looks like this transaction pulled a disappearing
                        act. 🎩✨
                    </p>
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import axios from "axios";
import { ref, onMounted, onUnmounted, watch, computed } from "vue";

const props = defineProps({
    orderItems: {
        type: Object,
        default: () => ({}),
    },
});

const originalOrderItems = ref([]);
originalOrderItems.value = props.orderItems.data;

const transactionFilter = ["All", "Ongoing", "Successful"];
const orderStatus = ["Wait for confirmation", "Order processed", "Delivered"];
const months = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

const transactionTabsClicked = ref(
    new Array(transactionFilter.length).fill(false)
);

const orderStatusTabsClicked = ref(new Array(orderStatus.length).fill(false));
const selectedTransactionStatus = ref("All");
const selectedTransactionDate = ref("");
const notFoundFilteredMessage = ref("");

/**
 * Handles the click event for transaction tabs.
 * Updates the `transactionTabsClicked` array to set the clicked tab as active.
 *
 * @param {number} index - The index of the clicked tab.
 */
const handleTransactionTabClick = (index) => {
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === index
    );

    // Get the transaction status based on the clicked tab
    selectedTransactionStatus.value = transactionFilter[index];
};

/**
 * Handles the click event on an order status tab.
 * Updates the `orderStatusTabsClicked` array to reflect the clicked tab.
 *
 * @param {number} index - The index of the clicked tab.
 */
const handleOrderStatusTabClick = (index) => {
    orderStatusTabsClicked.value = orderStatusTabsClicked.value.map(
        (_, i) => i === index
    );
};

/**
 * Handles the change of the transaction date based on the selected index.
 *
 * @param {number} index - The index of the selected date in the months array.
 */
const onChangeTransactionDate = (index) => {
    // Get the transaction date based on the selected date
    selectedTransactionDate.value = months[index - 1];
};

/**
 * Fetches filtered transaction history data from the API based on the selected transaction status and date.
 *
 * @async
 * @function fetchFilteredData
 * @returns {Promise<void>} - A promise that resolves when the data is successfully fetched and processed.
 */
const fetchFilteredData = async () => {
    try {
        const response = await axios.get(route("api.transaction-history"), {
            params: {
                status: selectedTransactionStatus.value,
                date: selectedTransactionDate.value,
            },
        });

        const results = response.data.orderItems.data;

        if (results.length <= 0) {
            originalOrderItems.value = [];
        } else {
            originalOrderItems.value = results;
        }
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

/**
 * Watches for changes in the selectedTransactionStatus and selectedTransactionDate variables.
 * When either of these variables change, the fetchFilteredData function is called to update the data accordingly.
 */
watch([selectedTransactionStatus, selectedTransactionDate], fetchFilteredData);

/**
 * Changes the badge color based on the order or payment status.
 *
 * @param {Object} order - The order object to check the status of.
 * @returns {string} - The corresponding badge color class.
 *
 */
const changeBadgeColorOrderOrPaymentStatus = (order) => {
    const status = checkOrderOrPaymentStatus(order);

    const statusMap = {
        "Order Confirmed": "badge-info",
        "Order processed": "badge-info",
        delivered: "badge-success",
        pending: "badge-info",
        paid: "badge-success",
    };

    return statusMap[status] || "badge-neutral";
};

/**
 * Checks the status of an order by returning the payment status if available,
 * otherwise returns the order status.
 *
 * @param {Object} order - The order object to check.
 * @param {Object} [order.payment] - The payment object associated with the order.
 * @param {string} [order.payment.payment_status] - The status of the payment.
 * @param {string} order.order_status - The status of the order.
 * @returns {string} - The payment status if it exists, otherwise the order status.
 */
const checkOrderOrPaymentStatus = (order) => {
    return order.transaction_status || order.order_status;
};

// Show the button pay now if the payment status is pending or the order status is order confirmed
const showPayNowButton = (order) => {
    const status = checkOrderOrPaymentStatus(order);
    return status === "pending" || status === "Order Confirmed";
};

onMounted(() => {
    // When loading set the tab to be active default in first index
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === 0
    );
});

onUnmounted(() => {
    // When unmounted reset the tab to be active default in first index
    transactionTabsClicked.value = new Array(transactionFilter.length).fill(
        false
    );
});

/**
 * Redirects the user to the specified payment URL.
 *
 * @param {string} paymentUrl - The URL to which the user will be redirected for payment.
 */
const redirectPayment = (paymentUrl) => {
    window.location = paymentUrl;
};

/**
 * Formats the price of an item by multiplying the price with the quantity.
 *
 * @param {number} price - The price of the item.
 * @param {number} quantity - The quantity of the item.
 * @returns {string} - The formatted price.
 */
const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};

/**
 * Calculates the total price of an order by multiplying the price with the quantity.
 *
 * @param {number} price - The price of the item.
 * @param {number} quantity - The quantity of the item.
 * @returns {number} - The total price of the order.
 */
const totalPrice = (price, quantity) => {
    return price * quantity;
};
</script>
