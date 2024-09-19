<template>
    <App>
        <section
            class="min-h-screen w-full flex flex-col gap-4 pt-36 pb-14 px-10 lg:px-20"
        >
            <h1 class="text-2xl font-bold">Shopping Chart</h1>
            <section class="grid grid-cols-12 gap-8">
                <section class="min-w-[750px] col-span-8 flex flex-col gap-6">
                    <div class="h-full px-3 py-5 bg-neutral rounded-t-lg">
                        <BaseCheckbox
                            label="Choose All"
                            text-color="white"
                            v-model="selectAllItem"
                            @change="isSelectedAll"
                        />
                    </div>
                    <div class="flex flex-col gap-4">
                        <div
                            class="flex justify-between items-center gap-2 px-3 py-4 bg-neutral rounded-md"
                            v-for="(item, index) in chartItems"
                            :key="item.id"
                        >
                            <div class="flex gap-2">
                                <BaseCheckbox
                                    v-model="selectCake[item.id]"
                                    :value="item.id"
                                    @change="updateTotalPrice"
                                />
                                <div class="flex gap-4">
                                    <div
                                        class="avatar rounded-lg outline outline-neutral shadow-lg"
                                    >
                                        <div class="w-20 rounded">
                                            <img
                                                :src="
                                                    item.image
                                                        ? item.cake.image
                                                        : '/assets/image/default-img.jpg'
                                                "
                                                alt="Tailwind-CSS-Avatar-component"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h1 class="text-xl text-white">
                                            {{ item.cake?.name }}
                                        </h1>
                                        <div
                                            class="flex gap-2 items-center text-base text-white text-opacity-75"
                                            v-if="
                                                item.cake_flavour ||
                                                item.cake_topping
                                            "
                                        >
                                            <p>
                                                {{ item.cake_flavour?.name }}
                                            </p>
                                            <div
                                                v-show="
                                                    item.cake_flavour &&
                                                    item.cake_topping.length > 1
                                                "
                                            >
                                                |
                                            </div>
                                            <p>
                                                {{
                                                    getToppingNameBasedChartItem(
                                                        item.id
                                                    )
                                                }}
                                            </p>
                                        </div>
                                        <p>{{ formatPrice(item.price) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="join">
                                <button
                                    class="btn btn-outline shadow-lg join-item"
                                    @click="
                                        (e) =>
                                            item.quantity <= 0
                                                ? e.preventDefault()
                                                : item.quantity--
                                    "
                                >
                                    -
                                </button>
                                <input
                                    class="input input-ghost input-bordered text-center w-14 join-item focus:bg-transparent"
                                    :value="item.quantity"
                                />
                                <button
                                    class="btn btn-outline shadow-lg join-item"
                                    @click="item.quantity++"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="h-fit col-span-4 flex justify-center">
                    <section
                        class="w-full flex flex-col gap-2 px-5 py-4 bg-neutral rounded-lg"
                    >
                        <h1 class="text-white text-2xl font-bold">
                            Shopping Summary
                        </h1>
                        <p></p>
                        <div
                            class="flex justify-between text-white font-bold text-lg"
                        >
                            <p>Total</p>
                            <p>{{ formatPrice(totalPrice) }}</p>
                        </div>
                        <inertia-link
                            :href="route('/checkout')"
                            class="btn btn-block mt-auto text-black bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none"
                        >
                            Checkout
                        </inertia-link>
                    </section>
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";

import { computed, ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const page = usePage();
const chartItems = computed(
    () => page.props.value.shoppingChartItems?.original.cart ?? []
);

const selectAllItem = ref(false);
const selectCake = ref({});
const totalPrice = ref(0);

/**
 * Updates the total price of the selected cakes in the shopping chart.
 *
 * @return {number} The total price of the selected cakes
 */
const updateTotalPrice = () => {
    const selectedCake = chartItems.value
        .filter((item) => selectCake.value[item.id])
        .reduce((totalPrice, item) => totalPrice + item.price, 0);

    totalPrice.value = selectedCake;

    // Check if all individual items are selected
    const allSelected = chartItems.value.every(
        (item) => selectCake.value[item.id]
    );

    // If not all are selected, uncheck "Select All"
    selectAllItem.value = allSelected;
};

/**
 * Selects or deselects all items in the shopping chart based on the selectAllItem value.
 *
 * @return {void}
 */
const isSelectedAll = () => {
    chartItems.value.forEach((item) => {
        selectCake.value[item.id] = selectAllItem.value;
    });

    updateTotalPrice();
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
 * Retrieves the names of the toppings for a specific chart item.
 *
 * @param {number} chartItemId - The ID of the chart item.
 * @return {string} A comma-separated string of the names of the toppings, or an empty string if the chart item is not found.
 */
const getToppingNameBasedChartItem = (chartItemId) => {
    if (!Array.isArray(chartItems.value)) {
        return [];
    }

    const item = chartItems.value.find((item) => item.id === chartItemId);

    if (!item) {
        return "";
    }

    return item.cake_topping.map((topping) => topping.name).join(", ");
};
</script>
