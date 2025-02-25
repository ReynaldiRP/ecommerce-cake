<template>
    <App>
        <section class="min-h-screen w-full py-28 px-10">
            <!-- breadcrumbs page -->
            <aside class="breadcrumbs text-sm me-auto relative">
                <ul>
                    <li>
                        <inertia-link :href="route('home')"
                            >Beranda</inertia-link
                        >
                    </li>
                    <li>
                        <inertia-link :href="route('order.history')"
                            >Riwayat Transaksi
                        </inertia-link>
                    </li>
                </ul>
            </aside>

            <!-- header content -->
            <section class="flex items-center gap-2 mt-4">
                <h1 class="text-2xl font-bold">Daftar Transaksi</h1>
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

                    <!--                    <div-->
                    <!--                        v-if="transactionTabsClicked[1]"-->
                    <!--                        role="tablist"-->
                    <!--                        class="tabs tabs-boxed font-medium"-->
                    <!--                    >-->
                    <!--                        <a-->
                    <!--                            v-for="(status, index) in orderStatus"-->
                    <!--                            role="tab"-->
                    <!--                            class="tab"-->
                    <!--                            :class="{-->
                    <!--                                'tab-active': orderStatusTabsClicked[index],-->
                    <!--                            }"-->
                    <!--                            @click="handleOrderStatusTabClick(index)"-->
                    <!--                            >{{ status }}</a-->
                    <!--                        >-->
                    <!--                    </div>-->
                </section>

                <select
                    class="select select-bordered w-full max-w-xs"
                    @change="
                        onChangeTransactionDate($event.target.selectedIndex)
                    "
                >
                    <option disabled selected>Pilih Bulan Transaksi</option>
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
                                v-if="order.transaction_status"
                                class="badge badge-outline font-medium text-lg"
                                :class="changeBadgeColorPaymentStatus(order)"
                            >
                                {{ order.transaction_status ?? "" }}
                            </div>
                            <p class="font-extralight">
                                {{ order.transaction_id || order.order_code }}
                            </p>
                            <div
                                class="badge badge-outline font-medium text-lg"
                                :class="changeBadgeColorOrderStatus(order)"
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
                                            :src="
                                                order.cake_image ??
                                                '/assets/image/default-img.jpg'
                                            "
                                            alt="Cake Image"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <p class="text-lg font-bold">
                                        {{ order.cake_name }}
                                        <span v-if="order.cake_size"
                                            >({{ order.cake_size }}Cm)</span
                                        >
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
                                    <p
                                        v-if="order.cake_note"
                                        class="font-extralight"
                                    >
                                        "{{ order.cake_note }}"
                                    </p>
                                    <p class="font-light">
                                        {{ order.quantity }}
                                        {{ order.cake_name }}
                                        <span v-if="order.cake_size"
                                            >({{ order.cake_size }}Cm)</span
                                        >
                                        x {{ formattedSubtotal[orderIndex] }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col text-xl pr-36">
                                <p>Total Order</p>
                                <strong>{{ formatPrice(order.price) }}</strong>
                            </div>
                        </section>

                        <!-- Transaction CTA -->
                        <section class="ms-auto flex gap-4 items-center">
                            <inertia-link
                                :href="
                                    route(
                                        'detail-transaction',
                                        order.order_code,
                                    )
                                "
                                class="link text-primary-color"
                                >See Detail Transaction</inertia-link
                            >
                            <button
                                v-if="
                                    order.transaction_status ===
                                        'Menunggu pembayaran' ||
                                    (order.order_status ===
                                        'Pesanan dikonfirmasi' &&
                                        order.transaction_status === null)
                                "
                                @click="modalActive = true"
                                class="btn btn-outline btn-error font-semibold"
                            >
                                Batalkan Pesanan
                            </button>
                            <section
                                v-if="
                                    order.order_status !== 'Pesanan kadaluwarsa'
                                "
                            >
                                <inertia-link
                                    v-if="showPayNowButton(order)"
                                    href="#"
                                    @click="redirectPayment(order.payment_url)"
                                    class="btn btn-outline btn-info font-semibold"
                                >
                                    Bayar Sekarang
                                </inertia-link>
                                <button
                                    v-else
                                    @click="handleBuyAgain(order.order_item_id)"
                                    class="btn btn-success font-semibold"
                                >
                                    Beli Lagi
                                </button>
                                <CardBoxModal
                                    v-model="modalActive"
                                    class="backdrop-contrast-50"
                                    title="Pembatalan Pesanan"
                                    button="danger"
                                    button-label="Yakin"
                                    :click-handler="
                                        () =>
                                            handleCancelOrder(order.order_code)
                                    "
                                    has-cancel
                                >
                                    <p>
                                        Apakah kamu yakin untuk membatalkan
                                        pesanan kue ?
                                    </p>
                                </CardBoxModal>
                            </section>
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

            <footer class="mt-2">
                <div class="flex justify-between items-center">
                    <Pagination
                        class="btn-outline"
                        :links="pagination.links"
                        :next-page-url="pagination.next_page_url"
                        :previous-page-url="pagination.prev_page_url"
                    />
                    <p>
                        Page
                        <span>{{ pagination.current_page }}</span> of
                        <span>{{ pagination.last_page }}</span>
                    </p>
                </div>
            </footer>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import axios from "axios";
import { ref, onMounted, onUnmounted, watch, onUpdated } from "vue";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    orderItems: {
        type: Object,
        default: () => ({}),
    },
});

const originalOrderItems = ref([]);
originalOrderItems.value = props.orderItems.data;

const pagination = ref(props.orderItems);

const modalActive = ref(false);
const transactionFilter = ["Semua", "Berjalan", "Sukses", "Gagal"];
const orderStatus = ["Menunggu konfirmasi", "Pesanan diproses", "Terkirim"];
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
    new Array(transactionFilter.length).fill(false),
);

const orderStatusTabsClicked = ref(new Array(orderStatus.length).fill(false));
const selectedTransactionStatus = ref("All");
const selectedTransactionDate = ref("");

/**
 * Handles the click event for transaction tabs.
 * Updates the `transactionTabsClicked` array to set the clicked tab as active.
 *
 * @param {number} index - The index of the clicked tab.
 */
const handleTransactionTabClick = (index) => {
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === index,
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
        (_, i) => i === index,
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
        const response = await axios.get(route("fetch-transaction-history"), {
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

        pagination.value = response.data.orderItems;
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
 * Changes the badge color based on the order status.
 *
 * @param {Object} order - The order object to check.
 * @returns {string} - The class name for the badge color.
 */
const changeBadgeColorOrderStatus = (order) => {
    const orderStatusMap = {
        "Pesanan dikonfirmasi": "badge-info",
        "Pesanan diproses": "badge-info",
        "Pesanan dikemas": "badge-info",
        "Pesanan dikirim": "badge-success",
        "Pesanan diterima": "badge-success",
        "Pesanan dibatalkan": "badge-error",
        "Pesanan kadaluwarsa": "badge-error",
    };

    return orderStatusMap[order.order_status] || "badge-neutral";
};

/**
 * Changes the badge color based on the payment status.
 *
 * @param {Object} order - The order object to check.
 * @returns {string} - The class name for the badge color.
 */
const changeBadgeColorPaymentStatus = (order) => {
    const paymentStatusMap = {
        "Menunggu pembayaran": "badge-info",
        "Pesanan terbayar": "badge-success",
        "Pembayaran kedaluwarsa": "badge-error",
        "Pembayaran dibatalkan": "badge-error",
    };

    return paymentStatusMap[order.transaction_status] || "badge-neutral";
};

/**
 * Checks the status of an order by returning the payment status if available,
 * otherwise returns the order status.
 *
 * @param {Object} order - The order object to check.
 * @returns {string} - The payment status if it exists, otherwise the order status.
 */
const checkOrderOrPaymentStatus = (order) =>
    order.transaction_status || order.order_status;

/**
 * Determines if the "Pay Now" button should be shown based on the order status.
 *
 * @param {Object} order - The order object to check.
 * @returns {boolean} - True if the "Pay Now" button should be shown, otherwise false.
 */
const showPayNowButton = (order) => {
    const status = checkOrderOrPaymentStatus(order);
    return (
        status === "Menunggu pembayaran" || status === "Pesanan dikonfirmasi"
    );
};

onMounted(() => {
    // When loading set the tab to be active default in first index
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === 0,
    );

    // Retrieves transaction status from the URL query parameters and updates the transaction status
    const urlParams = new URLSearchParams(window.location.search).get("status");

    if (urlParams) {
        // Set the transaction status based on the URL parameter
        selectedTransactionStatus.value = urlParams;
        transactionTabsClicked.value = transactionTabsClicked.value.map(
            (_, i) => transactionFilter[i] === urlParams,
        );
    }
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
 * Formats a given price to Indonesian Rupiah (IDR) currency format.
 *
 * @param {number} [price=0] - The price to be formatted.
 * @returns {string} - The formatted price string in IDR currency.
 */
const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};

/**
 * Calculates the subtotal for each item in the shopping cart.
 *
 * This function iterates over the `chartItems` array and calculates the subtotal
 * for each item by summing up the base price of the cake, the price of the selected
 * flavor, the total price of the selected toppings, and the price of the selected size.
 *
 * @returns {number[]} An array of subtotals for each item in the shopping cart.
 */
const subtotal = () => {
    return originalOrderItems.value.map((item) => {
        const cakePrice = item.cake_price ?? 0;
        const cakeSizePrice = item.cake_size_price ?? 0;
        const cakeFlavourPrice = item.cake_flavour_price ?? 0;
        const cakeToppingsPrice = item.cake_toppings_price ?? 0;

        return cakePrice + cakeSizePrice + cakeFlavourPrice + cakeToppingsPrice;
    });
};

const formattedSubtotal = subtotal().map(formatPrice);

/**
 * Handles the "Buy Again" action for a given order.
 *
 * This function sends a POST request to the server to place the same order again.
 * If the request is successful, the user is redirected to the detail chart page.
 * If there is an error, it logs the error to the console.
 *
 * @param {string} orderItem
 */
const handleBuyAgain = async (orderItem) => {
    try {
        const response = await axios.post(
            route("buy-again", { orderItem }),
            null,
            {
                params: {
                    orderItem: orderItem,
                },
            },
        );

        const chartItemId = response.data.chartItem[0].cartItem.id;

        // Redirect to the detail chart page
        window.location.href = route("detail-chart", {
            chartItemId: chartItemId,
        });
    } catch (e) {
        console.error("Error buying again:", e);
    }
};

const handleCancelOrder = async (orderId) => {
    try {
        await axios.post(route("cancel-order", { orderId }), null, {
            params: {
                orderId: orderId,
            },
        });

        // Update the order items after cancel order
        originalOrderItems.value.forEach((order) => {
            order.order_status = "Pesanan dibatalkan";
            order.transaction_status != null
                ? (order.transaction_status = "Pembayaran dibatalkan")
                : null;
        });
    } catch (e) {
        console.error("Error cancel order again:", e);
    }
};
</script>
