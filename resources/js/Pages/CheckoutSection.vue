<template>
    <App>
        <section class="min-h-screen w-full bg-gradient-soft">
            <div class="container mx-auto px-6 lg:px-12 pt-24 pb-16">
                <!-- Header Section -->
                <div
                    class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8"
                >
                    <div class="space-y-2">
                        <h1
                            class="text-3xl lg:text-4xl font-heading font-bold text-gray-900"
                        >
                            Checkout Pesanan
                        </h1>
                        <p class="text-gray-600">
                            Lengkapi detail pesanan Anda sebelum pembayaran
                        </p>
                    </div>
                    <BaseAlert
                        v-if="errorResponses"
                        class="bg-red-50 border border-red-200 text-red-800 px-6 py-3 rounded-2xl shadow-soft"
                        type="alert-error"
                    >
                        {{ errorResponses }}
                    </BaseAlert>
                </div>
                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    <!-- Order Items Section -->
                    <div class="space-y-6">
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-2"
                        >
                            <h2
                                class="text-xl font-heading font-bold text-gray-900 mb-6 px-4 pt-4"
                            >
                                Item Pesanan
                            </h2>

                            <div class="space-y-4">
                                <div
                                    v-for="(item, index) in chartItems"
                                    :key="index"
                                    class="bg-white/70 rounded-2xl shadow-soft border border-gray-100/50 p-4 mx-4 mb-4"
                                >
                                    <!-- Item Header -->
                                    <div class="flex items-start gap-4 mb-4">
                                        <div class="avatar flex-shrink-0">
                                            <div
                                                class="w-20 h-20 rounded-2xl overflow-hidden shadow-soft ring-2 ring-gray-100"
                                            >
                                                <img
                                                    :src="
                                                        item.cake.image_url ??
                                                        `/assets/image/default-img.jpg`
                                                    "
                                                    :alt="item.cake.name"
                                                    class="w-full h-full object-cover"
                                                />
                                            </div>
                                        </div>

                                        <div class="flex-1 space-y-2">
                                            <h3
                                                class="text-lg font-semibold text-gray-900"
                                            >
                                                {{ item.cake.name }}
                                                <span
                                                    v-if="item.cake_size"
                                                    class="text-primary font-medium"
                                                >
                                                    ({{
                                                        item.cake_size?.size
                                                    }}cm)
                                                </span>
                                            </h3>

                                            <!-- Specifications -->
                                            <div class="space-y-1">
                                                <div
                                                    v-if="
                                                        item.cake_flavour?.name
                                                    "
                                                    class="flex items-center space-x-2 text-sm text-gray-600"
                                                >
                                                    <div
                                                        class="w-2 h-2 bg-primary/50 rounded-full"
                                                    ></div>
                                                    <span class="font-medium"
                                                        >Rasa:</span
                                                    >
                                                    <span>{{
                                                        item.cake_flavour?.name
                                                    }}</span>
                                                </div>
                                                <div
                                                    v-if="
                                                        getToppingNameBasedOnChartItems(
                                                            item,
                                                        )
                                                    "
                                                    class="flex items-center space-x-2 text-sm text-gray-600"
                                                >
                                                    <div
                                                        class="w-2 h-2 bg-accent/50 rounded-full"
                                                    ></div>
                                                    <span class="font-medium"
                                                        >Topping:</span
                                                    >
                                                    <span>{{
                                                        getToppingNameBasedOnChartItems(
                                                            item,
                                                        )
                                                    }}</span>
                                                </div>
                                                <div
                                                    v-if="cakeNotes[item.id]"
                                                    class="flex items-start space-x-2 text-sm text-gray-600"
                                                >
                                                    <div
                                                        class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 flex-shrink-0"
                                                    ></div>
                                                    <span class="font-medium"
                                                        >Catatan:</span
                                                    >
                                                    <span class="italic"
                                                        >"{{
                                                            cakeNotes[item.id]
                                                        }}"</span
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quantity and Price -->
                                        <div class="text-right space-y-1">
                                            <div
                                                class="text-lg font-bold text-primary"
                                            >
                                                {{ cakeQuantities[item.id] }} x
                                                {{ formattedTotalPrice[index] }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Breakdown -->
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 space-y-2"
                                    >
                                        <h4
                                            class="font-semibold text-gray-700 mb-3"
                                        >
                                            Rincian Harga
                                        </h4>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600"
                                                    >Harga Kue</span
                                                >
                                                <span class="font-medium">{{
                                                    formattedSubTotal[index]
                                                }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600"
                                                    >Rasa Kue</span
                                                >
                                                <span class="font-medium">{{
                                                    formatPrice(
                                                        item.cake_flavour
                                                            ?.price || 0,
                                                    )
                                                }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600"
                                                    >Toppings</span
                                                >
                                                <span class="font-medium">{{
                                                    formatPrice(
                                                        getToppingPriceBasedOnChartItems(
                                                            item,
                                                        ),
                                                    )
                                                }}</span>
                                            </div>
                                            <div
                                                class="border-t border-gray-200 pt-2 mt-3"
                                            >
                                                <div
                                                    class="flex justify-between text-base font-bold text-primary"
                                                >
                                                    <span>Total</span>
                                                    <span>{{
                                                        formatPrice(
                                                            cakePrices[item.id],
                                                        )
                                                    }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Checkout Form Section -->
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
                        >
                            <!-- Form Header -->
                            <div class="flex items-center space-x-3 mb-8">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                                >
                                    <i
                                        class="fas fa-clipboard-list text-white"
                                    ></i>
                                </div>
                                <h2
                                    class="text-2xl font-heading font-bold text-gray-900"
                                >
                                    Detail Pengiriman
                                </h2>
                            </div>

                            <div class="space-y-6">
                                <!-- Delivery Date -->
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <BaseLabel
                                            :required="true"
                                            label="Tanggal Pengiriman / Pengambilan"
                                            class="text-gray-900 font-semibold"
                                        />
                                        <p
                                            class="text-sm text-gray-600 bg-amber-50 border border-amber-200 rounded-xl p-3"
                                        >
                                            <i
                                                class="fas fa-info-circle text-amber-600 mr-2"
                                            ></i>
                                            Pemesanan kue memerlukan
                                            pemberitahuan 2 hari sebelumnya
                                        </p>
                                    </div>
                                    <BaseInput
                                        input-type="date"
                                        v-model="form.estimated_delivery_date"
                                        class="w-full"
                                    />
                                </div>

                                <!-- Address Section -->
                                <div
                                    class="space-y-3"
                                    @click="handleClickOutsideAddressContainer"
                                    ref="addressContainer"
                                >
                                    <div class="space-y-1">
                                        <BaseLabel
                                            label="Alamat Pengiriman"
                                            :required="true"
                                            class="text-gray-900 font-semibold"
                                        />
                                        <p
                                            class="text-sm text-gray-600 bg-blue-50 border border-blue-200 rounded-xl p-3"
                                        >
                                            <i
                                                class="fas fa-map-marker-alt text-blue-600 mr-2"
                                            ></i>
                                            Pengiriman hanya tersedia di Kediri
                                            dan area sekitarnya
                                        </p>
                                    </div>
                                    <BaseInput
                                        v-model="form.user_address"
                                        placeholder="Masukkan alamat lengkap penerima"
                                        input-type="address"
                                        @keyup="getSearchResultAddress"
                                        :input-class="
                                            showSearchAddress
                                                ? 'rounded-t-2xl rounded-b-none'
                                                : 'rounded-2xl'
                                        "
                                        class="w-full"
                                    />
                                    <PreviewSearchAddress
                                        v-if="showSearchAddress"
                                        :results="searchResults"
                                        :selectAddress="selectedAddress"
                                        :addressResultsContainer="
                                            addressResultsContainer
                                        "
                                    />
                                </div>

                                <!-- Recipient Name -->
                                <div class="space-y-3">
                                    <BaseLabel
                                        label="Nama Penerima"
                                        :required="true"
                                        class="text-gray-900 font-semibold"
                                    />
                                    <BaseInput
                                        v-model="form.cake_recipient"
                                        placeholder="Nama lengkap penerima"
                                        input-type="username"
                                        class="w-full"
                                    />
                                </div>

                                <!-- Delivery Method -->
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <BaseLabel
                                            label="Metode Pengiriman"
                                            :required="true"
                                            class="text-gray-900 font-semibold"
                                        />
                                        <p class="text-sm text-gray-600">
                                            Pilih salah satu metode pengiriman
                                            yang tersedia
                                        </p>
                                    </div>
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                    >
                                        <div
                                            v-for="method in deliveryMethod"
                                            :key="method.id"
                                            class="relative"
                                        >
                                            <input
                                                type="radio"
                                                :id="method.id"
                                                :value="method.label"
                                                v-model="form.method_delivery"
                                                name="method_delivery"
                                                class="peer sr-only"
                                            />
                                            <label
                                                :for="method.id"
                                                class="flex items-center space-x-3 p-4 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all duration-200"
                                            >
                                                <div
                                                    class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center"
                                                >
                                                    <div
                                                        v-if="
                                                            form.method_delivery ===
                                                            method.label
                                                        "
                                                        class="w-2 h-2 bg-primary rounded-full"
                                                    ></div>
                                                </div>
                                                <span
                                                    class="font-medium text-gray-700"
                                                    >{{ method.label }}</span
                                                >
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Input -->
                                <input
                                    type="hidden"
                                    v-model="form.chartItems"
                                    name="chartItems"
                                />

                                <!-- Submit Button -->
                                <button
                                    type="submit"
                                    :disabled="isSubmitting"
                                    class="btn btn-modern w-full bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover transition-all duration-300 shadow-card hover:shadow-card-hover transform hover:scale-[1.02] border-0 py-4 text-lg font-semibold"
                                >
                                    <span
                                        v-if="!isSubmitting"
                                        class="flex items-center justify-center space-x-2"
                                    >
                                        <i class="fas fa-credit-card"></i>
                                        <span>Lanjutkan ke Pembayaran</span>
                                    </span>
                                    <span
                                        v-else
                                        class="flex items-center justify-center space-x-2"
                                    >
                                        <span
                                            class="loading loading-spinner loading-md"
                                        ></span>
                                        <span>Memproses Pesanan...</span>
                                    </span>
                                </button>

                                <!-- Security Info -->
                                <div
                                    class="mt-6 p-4 bg-green-50 rounded-2xl border border-green-100"
                                >
                                    <div class="flex items-start space-x-3">
                                        <i
                                            class="fas fa-shield-alt text-green-500 mt-0.5"
                                        ></i>
                                        <div class="text-sm text-green-700">
                                            <p class="font-semibold mb-1">
                                                Pembayaran Aman
                                            </p>
                                            <p class="text-xs">
                                                Transaksi Anda dilindungi dengan
                                                sistem pembayaran yang aman dan
                                                terpercaya.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseInput from "@/Components/BaseInput.vue";
import BaseLabel from "@/Components/BaseLabel.vue";
import PreviewSearchAddress from "@/Components/PreviewSearchAddress.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { computed, onMounted, onUnmounted, ref } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import BaseRadio from "@/Components/BaseRadio.vue";

const props = defineProps({
    chartItems: Array,
    cakePrices: Object,
    cakeQuantities: Object,
    cakeNotes: Object,
});

const showResults = ref(false);
const searchResults = ref([]);
const isSubmitting = ref(false);
const showSearchAddress = computed(() => {
    return showResults.value && form.user_address.length > 0;
});
const deliveryMethod = [
    {
        id: 1,
        label: "Ambil di Toko",
    },
    {
        id: 2,
        label: "Dikirim",
    },
];

const addressContainer = ref(null);
const addressResultsContainer = ref(null);
const errorResponses = ref(null);

const API_BASE_URL = "https://www.emsifa.com/api-wilayah-indonesia/api";

/**
 * Fetch data from given URL.
 *
 * @param {string} url
 * @returns {Promise<Object>}
 * @throws {Error}
 */
const fetchData = async (url) => {
    try {
        const response = await axios.get(url);
        return response.data;
    } catch (error) {
        console.error(`Error fetching data from ${url}:`, error);
        throw error;
    }
};

/**
 * Fetches search results based on the user's input address and updates the searchResults and showResults variables.
 *
 * @return {Promise<void>} - A Promise that resolves when the search results are fetched and the variables are updated.
 */

/**
 * Capitalizes the first letter of each word in a given string.
 *
 * @param {string} str
 * @returns {string}
 */
const capitalizeWords = (str) =>
    str
        .toLowerCase()
        .split(" ")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");

/**
 * Handles keyup event on address input field and fetches search results based on the input query.
 *
 * @param {string} query - The user's input query.
 * @return {Promise<void>} - A Promise that resolves when the search results are fetched and updated.
 */
const onKeyUpAddress = async (query) => {
    try {
        // Fetch data from all endpoints
        const districts = await fetchData(
            `${API_BASE_URL}/districts/3506.json`,
        );

        // Filter and process districts based on the query
        const districtResults = districts.map((item) => ({
            districts: {
                id: item.id,
                district_name: capitalizeWords(item.name),
            },
        }));

        const districtId = districtResults[0].districts.id;

        // Fetch villages based on the district ID
        const villages = await fetchData(
            `${API_BASE_URL}/villages/${districtId}.json`,
        );

        // Process village data
        searchResults.value = villages
            .filter((item) =>
                item.name.toLowerCase().includes(query.toLowerCase()),
            )
            .slice(0, 5)
            .map((item) => ({
                villages: {
                    district_id: item.district_id,
                    village_name: capitalizeWords(item.name),
                },
                ...districtResults[0],
                city: "Kediri",
                province: "Jawa Timur",
            }));
    } catch (error) {
        console.error("Error in onKeyUpAddress:", error);
    }
};

const debounceSearchAddress = debounce((query) => {
    onKeyUpAddress(query);
}, 500);

/**
 * Triggers the search for the given address and shows the search results.
 *
 * This function is called when the user types in the address input field.
 */
const getSearchResultAddress = () => {
    debounceSearchAddress(form.user_address);
    showResults.value = true;
};

/**
 * Sets the selected address in the form and hides the search results.
 *
 * @param {object} [address={}] - The selected address object containing the district, city, and province.
 */
const selectedAddress = (address = {}) => {
    // First set the address
    form.user_address = `${address.village}, ${address.district}, ${address.city}, ${address.province}`; // You can also set this to an object if needed

    // Then hide the search results
    showResults.value = false;
};

/**
 * Calculates the total price of the toppings for a given chart item.
 *
 * @param {object} item - The chart item object containing cake topping information
 * @return {number} The total price of the toppings
 */
const getToppingPriceBasedOnChartItems = (item) => {
    return item.cake_topping
        ?.map((topping) => topping.price)
        .reduce((a, b) => a + b, 0);
};

/**
 * Formats a given price into a currency string using the Indonesian Rupiah currency format.
 *
 * @param {number} price - The price to be formatted.
 * @return {string} The formatted currency string.
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
    return props.chartItems.map((item) => {
        let cakePrice = item.cake?.base_price;
        const cakeSizePrice = item.cake_size?.price ?? 0;

        // check if the cake has a discount
        if (item.cake?.discount) {
            const discount = item.cake.discount?.discount_percentage;
            const discountPrice = (cakePrice * discount) / 100;
            cakePrice -= discountPrice;
        }

        return cakePrice + cakeSizePrice;
    });
};

const temporaryTotalPrice = () => {
    return props.chartItems.map((item) => {
        let cakePrice = item.cake?.base_price;
        const cakeSizePrice = item.cake_size?.price ?? 0;
        const cakeFlavourPrice = item.cake_flavour?.price ?? 0;
        const toppingPrice = getToppingPriceBasedOnChartItems(item);

        if (item.cake?.discount) {
            const discount = item.cake.discount?.discount_percentage;
            const discountPrice = (cakePrice * discount) / 100;
            cakePrice -= discountPrice;
        }

        return cakePrice + cakeSizePrice + cakeFlavourPrice + toppingPrice;
    });
};

const formattedSubTotal = subtotal().map(formatPrice);
const formattedTotalPrice = temporaryTotalPrice().map(formatPrice);

/**
 * Retrieves the names of the toppings for a given chart item.
 *
 * @param {object} item - The chart item object containing cake topping information
 * @return {string} A comma-separated string of the names of the toppings
 */
const getToppingNameBasedOnChartItems = (item) => {
    return item.cake_topping?.map((topping) => topping.name).join(", ");
};

// Form helper for input fields
const form = useForm({
    chartItems: props.chartItems,
    estimated_delivery_date: "",
    user_address: "",
    cake_recipient: "",
    method_delivery: "",
});

const disableCheckout = computed(() =>
    [
        form.estimated_delivery_date,
        form.user_address,
        form.cake_recipient,
        form.method_delivery,
    ].every((field) => field !== "")
        ? "bg-primary-color text-base-300 hover:text-white"
        : "bg-gray-400 hover:bg-gray-400 text-base-300 cursor-not-allowed",
);

/**
 * Hides the address search results container when the user clicks outside of it.
 *
 * @param {object} event - The event object containing information about the click
 */
const handleClickOutsideAddressContainer = (event) => {
    if (
        addressContainer.value &&
        !addressContainer.value.contains(event.target)
    ) {
        showResults.value = false;
    }
};

// Add the event listener when the component mounts
onMounted(() => {
    document.addEventListener("click", handleClickOutsideAddressContainer);
});

// Clean up the event listener when the component is unmounted
onUnmounted(() => {
    document.removeEventListener("click", handleClickOutsideAddressContainer);
});

/**
 * Submits the checkout form.
 *
 * @returns {void}
 */
const submit = () => {
    // If all fields are filled in, submit the form
    isSubmitting.value = true;
    setTimeout(() => {
        isSubmitting.value = false;
        axios
            .post(
                route("payments"),
                {
                    estimated_delivery_date: form.estimated_delivery_date,
                    user_address: form.user_address,
                    cake_recipient: form.cake_recipient,
                    method_delivery: form.method_delivery,
                    chartItems: props.chartItems,
                },
                {
                    preserveState: true,
                    preserveScroll: true,
                },
            )
            .then((response) => {
                if (response.data.success) {
                    console.log(response.data);
                    // Redirect to Midtrans payment page
                    window.location.href = response.data.paymentUrl;
                } else {
                    // Handle error
                    console.error(response.data.message);
                }
            })
            .catch((error) => {
                // Get only the first error message
                const errors = error.response.data.errors;
                errorResponses.value = Object.values(errors)[0][0];
            });
    }, 2000);
};
</script>
