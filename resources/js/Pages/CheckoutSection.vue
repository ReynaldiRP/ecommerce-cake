<template>
    <App>
        <section
            class="min-h-screen w-full py-36 xl:py-28 px-10 flex flex-col justify-center gap-4"
        >
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold relative">Pesanan kamu</h1>
                <BaseAlert
                    v-if="errorResponses"
                    class="w-fit"
                    type="alert-error"
                    >{{ errorResponses }}</BaseAlert
                >
            </div>
            <section
                class="flex flex-col-reverse items-center lg:items-start lg:flex-row justify-center xl:justify-between gap-4"
            >
                <section class="flex flex-col gap-4">
                    <section
                        class="h-fit w-[700px] flex flex-col gap-6 p-4 border rounded-lg bg-neutral"
                        v-for="(item, index) in chartItems"
                        :key="index"
                    >
                        <section class="flex items-center justify-between">
                            <section class="flex gap-3">
                                <figure
                                    class="avatar rounded-lg outline outline-neutral shadow-lg"
                                >
                                    <div class="w-20 rounded">
                                        <img
                                            :src="
                                                item.cake.image_url ??
                                                `/assets/image/default-img.jpg`
                                            "
                                            alt="Tailwind-CSS-Avatar-component"
                                        />
                                    </div>
                                </figure>
                                <section class="flex flex-col justify-center">
                                    <h1 class="text-xl text-white">
                                        {{ item.cake.name }}
                                        <span v-if="item.cake_size">
                                            ({{ item.cake_size?.size }}Cm)
                                        </span>
                                    </h1>

                                    <article class="flex gap-2 text-white">
                                        <p class="text-base text-opacity-75">
                                            {{ item.cake_flavour?.name }}
                                        </p>
                                        <span
                                            v-show="
                                                item.cake_flavour &&
                                                item.cake_topping.length >= 1
                                            "
                                            >|</span
                                        >
                                        <p class="text-base text-opacity-75">
                                            {{
                                                getToppingNameBasedOnChartItems(
                                                    item,
                                                )
                                            }}
                                        </p>
                                    </article>
                                    <!-- Cake Notes -->
                                    <p
                                        v-if="cakeNotes[item.id]"
                                        class="font-extralight"
                                    >
                                        "{{ cakeNotes[item.id] }}"
                                    </p>
                                </section>
                            </section>
                            <div class="flex flex-col text-white">
                                <!-- Quantity and Order Price -->
                                <h1 class="text-xl font-bold">
                                    {{ cakeQuantities[item.id] }} x
                                    {{ formattedTotalPrice[index] }}
                                </h1>
                            </div>
                        </section>
                        <section class="px-2 text-xl font-bold text-white/70">
                            <article class="flex justify-between">
                                <h1 class="flex items-center gap-2">Kue</h1>
                                <h1>
                                    {{ formattedSubTotal[index] }}
                                </h1>
                            </article>
                            <article class="flex justify-between">
                                <h1>Rasa Kue</h1>
                                <h1>
                                    {{ formatPrice(item.cake_flavour?.price) }}
                                </h1>
                            </article>
                            <article class="flex justify-between">
                                <h1>Toppings</h1>
                                <h1>
                                    {{
                                        formatPrice(
                                            getToppingPriceBasedOnChartItems(
                                                item,
                                            ),
                                        )
                                    }}
                                </h1>
                            </article>
                            <article
                                class="px-2 flex justify-between mt-4 border-t-white border-t-2 text-white"
                            >
                                <h1>Totals</h1>
                                <!-- Order Total Price -->
                                <h1>{{ formatPrice(cakePrices[item.id]) }}</h1>
                            </article>
                        </section>
                    </section>
                </section>
                <form
                    @submit.prevent="submit"
                    class="h-fit w-[700px] rounded-lg px-8 py-6 flex flex-col gap-4 bg-neutral border border-white"
                >
                    <h1 class="text-4xl text-white font-bold">Checkout</h1>
                    <section class="flex flex-col gap-4">
                        <article class="flex flex-col gap-2">
                            <section class="flex flex-col gap-1">
                                <BaseLabel
                                    :required="true"
                                    label="Tanggal Pengiriman / Pengambilan"
                                />
                                <small class="font-medium"
                                    >(Pemesanan kue memerlukan pemberitahuan 2
                                    hari sebelumnya.)</small
                                >
                            </section>
                            <BaseInput
                                input-type="date"
                                v-model="form.estimated_delivery_date"
                            />
                        </article>
                        <article
                            class="flex flex-col gap-2"
                            @click="handleClickOutsideAddressContainer"
                            ref="addressContainer"
                        >
                            <section class="flex flex-col gap-1">
                                <BaseLabel
                                    label="Alamat Pengiriman"
                                    :required="true"
                                />
                                <small class="font-medium">
                                    (Pengiriman hanya tersedia di Kediri dan
                                    area sekitarnya.)
                                </small>
                            </section>
                            <BaseInput
                                v-model="form.user_address"
                                style="width: 100%"
                                placeholder="Alamat Penerima"
                                input-type="address"
                                @keyup="getSearchResultAddress"
                                :input-class="
                                    showSearchAddress
                                        ? 'rounded-t-lg rounded-b-none'
                                        : 'rounded-lg'
                                "
                            />
                            <PreviewSearchAddress
                                v-if="showSearchAddress"
                                :results="searchResults"
                                :selectAddress="selectedAddress"
                                :addressResultsContainer="
                                    addressResultsContainer
                                "
                            />
                        </article>
                        <article class="flex flex-col gap-2">
                            <BaseInput
                                v-model="form.cake_recipient"
                                style="width: 100%"
                                placeholder="Nama Penerima"
                                input-type="username"
                            />
                        </article>
                        <article class="flex flex-col gap-2">
                            <section class="flex flex-col gap-1">
                                <BaseLabel
                                    label="Metode Pengiriman"
                                    :required="true"
                                />
                                <small class="font-medium">
                                    (Pilih salah satu metode pengiriman.)
                                </small>
                            </section>
                            <div class="flex items-center gap-2">
                                <BaseRadio
                                    v-for="method in deliveryMethod"
                                    v-model="form.method_delivery"
                                    :key="method.id"
                                    :label="method.label"
                                    :id="method.id"
                                />
                            </div>
                        </article>
                        <input
                            type="hidden"
                            v-model="form.chartItems"
                            name="chartItems"
                        />
                        <button
                            class="btn"
                            :class="disableCheckout"
                            type="submit"
                        >
                            Pesan Sekarang
                        </button>
                    </section>
                </form>
            </section>
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
        const cakePrice = item.cake?.base_price;
        const cakeSizePrice = item.cake_size?.price ?? 0;

        return cakePrice + cakeSizePrice;
    });
};

const temporaryTotalPrice = () => {
    return props.chartItems.map((item) => {
        const cakePrice = item.cake?.base_price;
        const cakeSizePrice = item.cake_size?.price ?? 0;
        const cakeFlavourPrice = item.cake_flavour?.price ?? 0;
        const toppingPrice = getToppingPriceBasedOnChartItems(item);

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
    console.log(form.data());

    // If all fields are filled in, submit the form
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
            const errors = error.response.data.error;
            errorResponses.value = Object.values(errors)[0][0];
        });
};
</script>
