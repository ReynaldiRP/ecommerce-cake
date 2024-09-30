<template>
    <App>
        <section
            class="min-h-screen w-full py-36 xl:py-28 px-10 flex flex-col justify-center gap-4"
        >
            <h1 class="text-4xl font-bold text-center xl:text-start">
                Your Orders
            </h1>
            <section
                class="flex flex-col-reverse lg:flex-row justify-center xl:justify-between gap-4"
            >
                <section class="flex flex-col gap-4">
                    <section
                        class="h-fit w-[700px] flex flex-col gap-6 p-4 border rounded-lg bg-neutral"
                        v-for="(item, index) in chartItems"
                        :key="index"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex gap-3">
                                <div
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
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h1 class="text-xl text-white">
                                        {{ item.cake.name }}
                                    </h1>
                                    <div class="flex gap-2 text-white">
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
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 text-white">
                                <h1 class="text-xl font-bold">
                                    {{ formatPrice(item.price) }}
                                </h1>
                                <div class="join">
                                    <button
                                        class="btn btn-outline border-white shadow-lg join-item"
                                    >
                                        -
                                    </button>
                                    <input
                                        class="input input-ghost input-bordered border-white text-center w-14 join-item focus:bg-transparent"
                                        :value="item.quantity"
                                    />
                                    <button
                                        class="btn btn-outline border-white shadow-lg join-item"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 text-xl font-bold text-white/70">
                            <div class="flex justify-between">
                                <h1 class="flex items-center gap-2">
                                    Subtotal
                                    <small class="text-sm font-light"
                                        >(Cake Price x Quantity)</small
                                    >
                                </h1>
                                <h1>
                                    {{ formatPrice(getItemSubtotal(item)) }}
                                </h1>
                            </div>
                            <div class="flex justify-between">
                                <h1>Flavour</h1>
                                <h1>
                                    {{ formatPrice(item.cake_flavour?.price) }}
                                </h1>
                            </div>
                            <div class="flex justify-between">
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
                            </div>
                            <div
                                class="px-2 flex justify-between mt-4 border-t-white border-t-2 text-white"
                            >
                                <h1>Totals</h1>
                                <h1>{{ formatPrice(item.price) }}</h1>
                            </div>
                        </div>
                    </section>
                </section>
                <form
                    @submit.prevent=""
                    class="h-fit w-[700px] rounded-lg px-8 py-6 flex flex-col gap-4 bg-neutral border border-white"
                >
                    <h1 class="text-4xl text-white font-bold">Checkout</h1>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-4">
                            <BaseLabel
                                :required="true"
                                label="Estimation time"
                            />
                            <BaseInput input-type="date" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <BaseLabel
                                label="Shipping Address"
                                :required="true"
                            />
                            <BaseInput
                                v-model="form.address"
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
                            />
                        </div>
                        <div class="flex flex-col gap-2">
                            <BaseInput
                                v-model="form.username"
                                style="width: 100%"
                                placeholder="Consignee"
                                input-type="username"
                                :error="error.username"
                                :error-message="errorMessage.username"
                                @change="onChangeUsername"
                            />
                        </div>
                        <button
                            class="btn bg-primary-color text-base-300 hover:text-white"
                        >
                            Place Order
                        </button>
                    </div>
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
import { ref, reactive, computed } from "vue";
import axios from "axios";
import { debounce } from "lodash";

const props = defineProps({
    chartItems: Array,
});

const showResults = ref(false);
const searchResults = ref([]);

const showSeachAddress = computed(() => {
    return showResults.value && form.address.length > 0;
});

/**
 * Fetches search results based on the user's input address and updates the searchResults and showResults variables.
 *
 * @return {Promise<void>} - A Promise that resolves when the search results are fetched and the variables are updated.
 */
const onKeyUpAddress = async (query) => {
    try {
        const config = {
            method: "get",
            url: `https://api.geoapify.com/v1/geocode/autocomplete?text=${query}&apiKey=8f6a39785d72465ab4ea84a0870970ef`,
            headers: {},
        };

        const response = await axios(config);

        searchResults.value = response.data.features;
    } catch (error) {
        console.log(error);
    }
};

const debounceSearchAddress = debounce((query) => {
    onKeyUpAddress(query);
}, 500);

const getSearchResultAdress = () => {
    debounceSearchAddress(form.address);
    showResults.value = true;
};

const selectedAddress = (address) => {
    // First set the address
    form.address = address;

    // Then hide the search results
    showResults.value = false;

    // This should now log 'false' after the selection
    console.log(showSeachAddress.value);
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

// State for error in client side
const error = reactive({
    email: false,
    username: false,
});

// State for error message in client side
const errorMessage = reactive({
    email: "",
    username: "",
});

// Form helper for input fields
const form = useForm({
    email: "",
    address: "",
    username: "",
});

const errorMessageRegex = {
    username:
        "Username can only include letters, numbers, dots, underscores, and hyphens.",
    email: "Please enter a valid email address.",
};

// Valdation for email and password in client side
const validations = {
    email: {
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        minLength: 1,
    },
    username: {
        regex: /^[a-zA-Z0-9._-]{1,}$/,
        minLength: 1,
    },
};

// Function for validation user input in client side
const validate = (value, type) => {
    const validation = validations[type];
    if (!validation) return;

    error[type] = false;
    errorMessage[type] = "";

    if (value.length < validation.minLength) {
        error[type] = true;
        errorMessage[type] = `${type.charAt(0).toUpperCase()}${type.slice(
            1
        )} must be at least ${validation.minLength} characters`;

        return;
    }

    if (validation.regex && !validation.regex.test(value)) {
        error[type] = true;
        errorMessage[type] = errorMessageRegex[type];
    }
};

// Function event on change input user email
const onChangeEmail = () => {
    validate(form.email, "email");
};

const onChangeUsername = () => {
    validate(form.username, "username");
};
</script>
