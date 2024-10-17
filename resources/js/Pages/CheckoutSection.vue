<template>
    <App>
        <section
            class="min-h-screen w-full py-36 xl:py-28 px-10 flex flex-col justify-center gap-4"
        >
            <h1 class="text-4xl font-bold relative">Your Orders</h1>
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
                                    </h1>
                                    <article class="flex gap-2 text-white">
                                        <p class="text-base text-opacity-75">
                                            {{ item.cake_flavour?.name }}
                                        </p>
                                        <span
                                            v-show="
                                                item.cake_flavour &&
                                                item.cake_topping
                                            "
                                            >|</span
                                        >
                                        <p class="text-base text-opacity-75">
                                            {{
                                                getToppingNameBasedOnChartitems(
                                                    item
                                                )
                                            }}
                                        </p>
                                    </article>
                                </section>
                            </section>
                            <div class="flex flex-col gap-3 text-white">
                                <h1 class="text-xl font-bold">
                                    {{ item.quantity }} x
                                    {{ formatPrice(item.price) }}
                                </h1>
                            </div>
                        </section>
                        <section class="px-2 text-xl font-bold text-white/70">
                            <article class="flex justify-between">
                                <h1 class="flex items-center gap-2">
                                    Subtotal
                                    <small class="text-sm font-light"
                                        >(Cake Price x Quantity)</small
                                    >
                                </h1>
                                <h1>
                                    {{ formatPrice(getItemSubtotal(item)) }}
                                </h1>
                            </article>
                            <article class="flex justify-between">
                                <h1>Flavour</h1>
                                <h1>
                                    {{ formatPrice(item.cake_flavour?.price) }}
                                </h1>
                            </article>
                            <article class="flex justify-between">
                                <h1>Toppings</h1>
                                <h1>
                                    {{
                                        formatPrice(
                                            getToppingPriceBasedOnChartitems(
                                                item
                                            )
                                        )
                                    }}
                                </h1>
                            </article>
                            <article
                                class="px-2 flex justify-between mt-4 border-t-white border-t-2 text-white"
                            >
                                <h1>Totals</h1>
                                <h1>{{ formatPrice(item.price) }}</h1>
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
                            <section class="flex gap-1 items-center">
                                <BaseLabel
                                    :required="true"
                                    label="Estimation time"
                                />
                                <small class="font-medium"
                                    >(Cake orders require 2 days' advance
                                    notice.)</small
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
                            <section class="flex gap-1 items-center">
                                <BaseLabel
                                    label="Shipping Address"
                                    :required="true"
                                />
                                <small class="font-medium"
                                    >(Delivery available only in Kediri and
                                    nearby areas.)</small
                                >
                            </section>
                            <BaseInput
                                v-model="form.user_address"
                                style="width: 100%"
                                placeholder="User Address"
                                input-type="address"
                                @keyup="getSearchResultAdress"
                                :input-class="
                                    showSeachAddress
                                        ? 'rounded-t-lg rounded-b-none'
                                        : 'rounded-lg'
                                "
                            />
                            <PreviewSearchAddress
                                v-if="showSeachAddress"
                                :results="searchResults"
                                :selectAddress="selectedAddress"
                                :addressResultsContainer="
                                    addressResultsContainer
                                "
                            />
                        </article>
                        <article class="flex flex-col gap-2">
                            <BaseInput
                                v-model="form.cake_recipent"
                                style="width: 100%"
                                placeholder="Cake Recipient"
                                input-type="username"
                            />
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
                            Place Order
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

import { useForm } from "@inertiajs/inertia-vue3";
import { ref, computed, onMounted, onUnmounted } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    chartItems: Array,
});

const showResults = ref(false);
const searchResults = ref([]);
const showSeachAddress = computed(() => {
    return showResults.value && form.user_address.length > 0;
});

const addressContainer = ref(null);
const addressResultsContainer = ref(null);

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
            `${API_BASE_URL}/districts/3506.json`
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
            `${API_BASE_URL}/villages/${districtId}.json`
        );

        // Process village data
        const villageResults = villages
            .filter((item) =>
                item.name.toLowerCase().includes(query.toLowerCase())
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

        console.log("Final Result:", villageResults);

        searchResults.value = villageResults;
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
const getSearchResultAdress = () => {
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
 * Calculates the subtotal of a given item based on its base price, cake size price, and quantity.
 *
 * @param {object} item - The item object containing cake and quantity information
 * @return {number} The calculated subtotal of the item
 */
const getItemSubtotal = (item) => {
    const basePrice = item.cake.base_price || 0;
    const cakeSizePrice = item.cake.cake_size?.price || 0;
    return (basePrice + cakeSizePrice) * item.quantity;
};

/**
 * Retrieves the names of the toppings for a given chart item.
 *
 * @param {object} item - The chart item object containing cake topping information
 * @return {string} A comma-separated string of the names of the toppings
 */
const getToppingNameBasedOnChartitems = (item) => {
    return item.cake_topping?.map((topping) => topping.name).join(", ");
};

/**
 * Calculates the total price of the toppings for a given chart item.
 *
 * @param {object} item - The chart item object containing cake topping information
 * @return {number} The total price of the toppings
 */
const getToppingPriceBasedOnChartitems = (item) => {
    return item.cake_topping
        ?.map((topping) => topping.price)
        .reduce((a, b) => a + b, 0);
};

// Form helper for input fields
const form = useForm({
    chartItems: props.chartItems,
    estimated_delivery_date: "",
    user_address: "",
    cake_recipent: "",
});

const disableCheckout = computed(() =>
    [form.estimated_delivery_date, form.user_address, form.cake_recipent].every(
        (field) => field !== ""
    )
        ? "bg-primary-color text-base-300 hover:text-white"
        : "bg-gray-400 hover:bg-gray-400 text-base-300 cursor-not-allowed"
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
 * @param {object} e - The event object containing information about the form submission
 *
 * @returns {void}
 */
const submit = (e) => {
    try {
        // Destructure the form data
        const {
            estimated_delivery_date,
            user_address,
            cake_recipent,
            chartItems,
        } = form;

        // Check if all fields are filled in
        if (estimated_delivery_date === undefined) {
            console.error("estimated_delivery_date is undefined");
            return e.preventDefault();
        }
        if (user_address === undefined) {
            console.error("user_address is undefined");
            return e.preventDefault();
        }
        if (cake_recipent === undefined) {
            console.error("cake_recipent is undefined");
            return e.preventDefault();
        }

        // If all fields are filled in, submit the form
        axios.post(
            route("payments"),
            {
                estimated_delivery_date,
                user_address,
                cake_recipent,
                chartItems,
            },
            {
                preserveState: true,
                preserveScroll: true,
            }
        )
            .then((response) => {
                if (response.data.success) {
                    // Redirect to Midtrans payment page
                    window.location.href = response.data.paymentUrl;
                } else {
                    // Handle error
                    console.error(response.data.message);
                    // You might want to show an error message to the user here
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    } catch (error) {
        console.error(error);
    }
};
</script>
