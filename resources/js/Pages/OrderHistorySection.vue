<template>
    <App>
        <section class="min-h-screen w-full bg-gradient-soft">
            <div class="container mx-auto px-6 lg:px-12 pt-24 pb-16">
                <!-- Breadcrumb -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 md:space-x-3">
                        <li class="inline-flex items-center">
                            <inertia-link
                                :href="route('home')"
                                class="inline-flex items-center text-gray-700 hover:text-primary transition-colors font-medium"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                    ></path>
                                </svg>
                                Beranda
                            </inertia-link>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg
                                    class="w-4 h-4 text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span
                                    class="ml-2 text-sm font-medium text-gray-600"
                                    >Riwayat Transaksi</span
                                >
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Header Section -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8"
                >
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3">
                            <h1
                                class="text-2xl lg:text-3xl font-heading font-bold text-gray-900"
                            >
                                Riwayat Transaksi
                            </h1>
                            <div
                                class="px-3 py-1 bg-gradient-to-r from-primary to-accent text-white rounded-full text-sm font-semibold shadow-soft"
                            >
                                {{ orderItems.total }}
                            </div>
                        </div>
                        <p class="text-gray-600">
                            Halo,
                            {{
                                username.charAt(0).toUpperCase() +
                                username.slice(1)
                            }}! Kelola dan pantau semua transaksi Anda
                        </p>
                    </div>
                </div>

                <!-- Filter and Sort Section -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 mb-8"
                >
                    <div
                        class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6"
                    >
                        <!-- Transaction Filter Tabs -->
                        <div class="flex-1">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Filter Status
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    v-for="(filter, index) in transactionFilter"
                                    :key="index"
                                    class="px-4 py-2 rounded-xl font-semibold text-sm transition-all duration-200"
                                    :class="{
                                        'bg-gradient-to-r from-primary to-accent text-white shadow-soft':
                                            transactionTabsClicked[index],
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200':
                                            !transactionTabsClicked[index],
                                    }"
                                    @click="handleTransactionTabClick(index)"
                                >
                                    {{ filter }}
                                </button>
                            </div>
                        </div>

                        <!-- Date Filters -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-medium text-gray-700 mx-2"
                                    >Tahun</label
                                >
                                <select
                                    class="select select-bordered bg-white border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-xl"
                                    @change="
                                        onChangeYearTransaction(
                                            $event.target.selectedIndex,
                                        )
                                    "
                                >
                                    <option disabled selected>
                                        Pilih Tahun
                                    </option>
                                    <option
                                        v-for="(year, index) in years"
                                        :key="index"
                                    >
                                        {{ year }}
                                    </option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-medium text-gray-700 mx-2"
                                    >Bulan</label
                                >
                                <select
                                    class="select select-bordered bg-white border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-xl"
                                    @change="
                                        onChangeMonthTransaction(
                                            $event.target.selectedIndex,
                                        )
                                    "
                                >
                                    <option disabled selected>
                                        Pilih Bulan
                                    </option>
                                    <option
                                        v-for="(month, index) in months"
                                        :key="index"
                                    >
                                        {{ month }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History Content -->
                <div class="space-y-6">
                    <!-- Individual Order Cards -->
                    <div
                        v-for="(order, orderIndex) in originalOrderItems"
                        :key="order.transaction_id + orderIndex"
                        class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8 transition-all duration-300 hover:shadow-card-hover"
                    >
                        <!-- Order Header -->
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6"
                        >
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                                >
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        {{ order.order_created_at }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        ID: {{ order.order_code }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="px-4 py-2 rounded-full text-sm font-semibold"
                                :class="
                                    changeBadgeColorOrderStatus(
                                        originalTransactionStatus[
                                            order.order_code
                                        ]?.status ?? order.order_status,
                                    )
                                "
                            >
                                {{
                                    originalTransactionStatus[order.order_code]
                                        ?.status ?? order.order_status
                                }}
                            </div>
                        </div>

                        <!-- Order Content -->
                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Product Image and Details -->
                            <div class="flex gap-4 flex-1">
                                <div class="avatar flex-shrink-0">
                                    <div
                                        class="w-20 h-20 lg:w-24 lg:h-24 rounded-2xl overflow-hidden shadow-soft ring-2 ring-gray-100"
                                    >
                                        <img
                                            :src="
                                                order.cake_image ??
                                                '/assets/image/default-img.jpg'
                                            "
                                            alt="Cake Image"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                </div>

                                <div class="flex-1 space-y-2">
                                    <h3
                                        class="text-lg lg:text-xl font-semibold text-gray-900"
                                    >
                                        {{ order.cake_name }}
                                        <span
                                            v-if="order.cake_size"
                                            class="text-primary font-medium"
                                        >
                                            ({{ order.cake_size }}cm)
                                        </span>
                                    </h3>

                                    <!-- Specifications -->
                                    <div class="space-y-1">
                                        <div
                                            v-if="order.cake_flavour"
                                            class="flex items-center space-x-2 text-sm text-gray-600"
                                        >
                                            <div
                                                class="w-2 h-2 bg-primary/50 rounded-full"
                                            ></div>
                                            <span class="font-medium"
                                                >Rasa:</span
                                            >
                                            <span>{{
                                                order.cake_flavour
                                            }}</span>
                                        </div>
                                        <div
                                            v-if="order.cake_toppings.length"
                                            class="flex items-center space-x-2 text-sm text-gray-600"
                                        >
                                            <div
                                                class="w-2 h-2 bg-accent/50 rounded-full"
                                            ></div>
                                            <span class="font-medium"
                                                >Topping:</span
                                            >
                                            <span>{{
                                                order.cake_toppings.join(", ")
                                            }}</span>
                                        </div>
                                        <div
                                            v-if="order.cake_note"
                                            class="bg-blue-50 rounded-xl p-3 border border-blue-100"
                                        >
                                            <div
                                                class="flex items-start space-x-2"
                                            >
                                                <i
                                                    class="fas fa-sticky-note text-blue-500 mt-0.5 text-sm"
                                                ></i>
                                                <div>
                                                    <p
                                                        class="text-xs font-semibold text-blue-700 mb-1"
                                                    >
                                                        Catatan:
                                                    </p>
                                                    <p
                                                        class="text-sm text-blue-600 italic"
                                                    >
                                                        "{{ order.cake_note }}"
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quantity and Price per Item -->
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-semibold">{{
                                                order.quantity
                                            }}</span>
                                            x
                                            <span class="font-medium">{{
                                                formattedSubtotal[orderIndex]
                                            }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Price and Actions -->
                            <div class="lg:w-80 space-y-4">
                                <!-- Total Price -->
                                <div
                                    class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-2xl p-4"
                                >
                                    <p class="text-sm text-gray-600 mb-1">
                                        Total Pembayaran
                                    </p>
                                    <p class="text-2xl font-bold text-primary">
                                        {{ formatPrice(order.price) }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-3">
                                    <inertia-link
                                        :href="
                                            route(
                                                'detail-transaction',
                                                order.order_code,
                                            )
                                        "
                                        class="btn w-full bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white rounded-xl transition-all duration-200"
                                    >
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </inertia-link>

                                    <button
                                        v-if="
                                            originalTransactionStatus[
                                                order.order_code
                                            ]?.status === 'Menunggu pembayaran'
                                        "
                                        @click="
                                            modalActiveMap[order.order_code] =
                                                true
                                        "
                                        class="btn w-full bg-red-50 border-2 border-red-200 text-red-600 hover:bg-red-100 rounded-xl transition-all duration-200"
                                    >
                                        <i class="fas fa-times mr-2"></i>
                                        Batalkan Pesanan
                                    </button>

                                    <div
                                        v-if="
                                            order.order_status !==
                                            'Pesanan kadaluwarsa'
                                        "
                                    >
                                        <inertia-link
                                            v-if="showPayNowButton(order)"
                                            href="#"
                                            @click="
                                                redirectPayment(
                                                    order.payment_url,
                                                )
                                            "
                                            class="btn w-full bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover rounded-xl shadow-soft transition-all duration-200"
                                        >
                                            <i
                                                class="fas fa-credit-card mr-2"
                                            ></i>
                                            Bayar Sekarang
                                        </inertia-link>
                                        <button
                                            v-else
                                            @click="
                                                handleBuyAgain(
                                                    order.order_item_id,
                                                )
                                            "
                                            class="btn w-full bg-green-50 border-2 border-green-200 text-green-700 hover:bg-green-100 rounded-xl transition-all duration-200"
                                        >
                                            <i
                                                class="fas fa-shopping-cart mr-2"
                                            ></i>
                                            Beli Lagi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel Order Modal -->
                        <CardBoxModal
                            v-model="modalActiveMap[order.order_code]"
                            class="backdrop-blur-sm"
                            title="Konfirmasi Pembatalan"
                            button="danger"
                            button-label="Ya, Batalkan"
                            :click-handler="
                                () => handleCancelOrder(order.order_code)
                            "
                            has-cancel
                        >
                            <div class="space-y-4">
                                <div
                                    class="flex items-center space-x-3 p-4 bg-red-50 rounded-xl border border-red-100"
                                >
                                    <i
                                        class="fas fa-exclamation-triangle text-red-500 text-lg"
                                    ></i>
                                    <div>
                                        <p class="font-semibold text-red-800">
                                            Yakin ingin membatalkan pesanan?
                                        </p>
                                        <p class="text-sm text-red-600">
                                            Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </CardBoxModal>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="originalOrderItems.length <= 0"
                        class="text-center py-16"
                    >
                        <div class="max-w-md mx-auto">
                            <div
                                class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"
                            >
                                <i
                                    class="fas fa-shopping-bag text-gray-400 text-2xl"
                                ></i>
                            </div>
                            <h3
                                class="text-xl font-heading font-bold text-gray-900 mb-4"
                            >
                                Belum Ada Transaksi
                            </h3>
                            <p class="text-gray-600 mb-8">
                                Anda belum memiliki riwayat transaksi. Mulai
                                berbelanja sekarang! 🎂✨
                            </p>
                            <inertia-link
                                :href="route('products')"
                                class="btn btn-primary-modern"
                            >
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Mulai Belanja
                            </inertia-link>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4"
                >
                    <Pagination
                        class="order-2 sm:order-1"
                        :links="pagination.links"
                        :next-page-url="pagination.next_page_url"
                        :previous-page-url="pagination.prev_page_url"
                    />
                    <p class="text-sm text-gray-600 order-1 sm:order-2">
                        Halaman
                        <span class="font-semibold">{{
                            pagination.current_page
                        }}</span>
                        dari
                        <span class="font-semibold">{{
                            pagination.last_page
                        }}</span>
                    </p>
                </div>
            </div>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import axios from "axios";
import { ref, onMounted, watch, computed, reactive } from "vue";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import Pagination from "@/Components/Pagination.vue";
import { usePage } from "@inertiajs/inertia-vue3";

const page = usePage();
const username = computed(() => page.props.value.user.name);

const props = defineProps({
    orderItems: {
        type: Object,
        default: () => ({}),
    },
    transactionStatus: {
        type: Object,
        default: () => ({}),
    },
});

const originalTransactionStatus = ref(props.transactionStatus || {});
console.log(originalTransactionStatus.value);
const originalOrderItems = ref([]);
originalOrderItems.value = props.orderItems.data;

const pagination = ref(props.orderItems);
const modalActiveMap = ref({});
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
const years = ["2021", "2022", "2023", "2024", "2025"];

const transactionTabsClicked = ref(
    new Array(transactionFilter.length).fill(false),
);

const orderStatusTabsClicked = ref(new Array(orderStatus.length).fill(false));
const selectedTransactionStatus = ref("All");
const selectedTransactionDate = reactive({
    months: null,
    years: null,
});

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

const onChangeMonthTransaction = (index) => {
    selectedTransactionDate.months = months[index - 1];
    console.log(selectedTransactionDate.months);
};

const onChangeYearTransaction = (index) => {
    selectedTransactionDate.years = years[index - 1];
    console.log(selectedTransactionDate.years);
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
                month: selectedTransactionDate.months,
                year: selectedTransactionDate.years,
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
 * @returns {string} - The class name for the badge color.
 * @param status
 */
const changeBadgeColorOrderStatus = (status) => {
    const orderStatusMap = {
        "Menunggu pembayaran":
            "bg-blue-100 text-blue-800 border border-blue-200",
        "Pesanan dikonfirmasi":
            "bg-blue-100 text-blue-800 border border-blue-200",
        "Pesanan diproses":
            "bg-yellow-100 text-yellow-800 border border-yellow-200",
        "Pesanan dikemas":
            "bg-purple-100 text-purple-800 border border-purple-200",
        "Pesanan dikirim":
            "bg-indigo-100 text-indigo-800 border border-indigo-200",
        "Pesanan diterima":
            "bg-green-100 text-green-800 border border-green-200",
        "Pesanan dibatalkan": "bg-red-100 text-red-800 border border-red-200",
        "Pesanan kadaluwarsa": "bg-red-100 text-red-800 border border-red-200",
        "Pesanan terbayar":
            "bg-green-100 text-green-800 border border-green-200",
        "Pembayaran kedaluwarsa":
            "bg-red-100 text-red-800 border border-red-200",
        "Pembayaran dibatalkan":
            "bg-red-100 text-red-800 border border-red-200",
    };

    return (
        orderStatusMap[status] ||
        "bg-gray-100 text-gray-800 border border-gray-200"
    );
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

// FIXME: fix the cancel order for not canceling all the order status
const handleCancelOrder = async (orderId) => {
    try {
        await axios.post(route("cancel-order", { orderId }), null, {
            params: {
                orderId: orderId,
            },
        });

        console.log(orderId);

        if (originalTransactionStatus.value[orderId]) {
            originalTransactionStatus.value[orderId].status =
                "Pesanan dibatalkan";
        }

        modalActiveMap.value[orderId] = false;
    } catch (e) {
        console.error("Error cancel order again:", e);
    }
};
</script>
