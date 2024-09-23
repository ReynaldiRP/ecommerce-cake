<template>
    <App>
        <section
            class="min-h-screen w-full flex flex-col gap-4 pt-36 pb-14 px-10 lg:px-20"
        >
            <BaseAlert
                v-show="showAlert"
                class="w-fit py-2 font-medium ms-auto transform transition-transform duration-500 ease-in-out translate-y-0 opacity-100"
                :class="{
                    'translate-y-[-20px] opacity-0': !showAlert,
                    'translate-y-0 opacity-100': showAlert,
                }"
                type="alert-success"
            >
                {{ messageDelete }}
            </BaseAlert>
            <h1 class="text-2xl font-bold">Shopping Chart</h1>
            <section class="grid grid-cols-12 gap-8">
                <section class="col-span-8 flex flex-col gap-6">
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
                            class="flex flex-col lg:flex-row lg:justify-between lg:items-center lg:gap-2 px-3 py-4 bg-neutral rounded-md"
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
                                        class="flex flex-col sm:flex-row gap-4"
                                    >
                                        <div
                                            class="avatar w-fit rounded-lg outline outline-neutral shadow-lg"
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
                                        <div
                                            class="flex flex-col gap-1 lg:justify-center"
                                        >
                                            <h1
                                                class="text-xl font-semibold text-white"
                                            >
                                                {{ item.cake?.name }}
                                            </h1>
                                            <div
                                                class="flex gap-2 lg:items-center text-base text-nowrap text-white text-opacity-75"
                                            >
                                                <p v-show="item.cake_flavour">
                                                    {{
                                                        item.cake_flavour?.name
                                                    }}
                                                </p>
                                                <div
                                                    v-show="
                                                        item.cake_flavour &&
                                                        item.cake_topping
                                                            .length > 1
                                                    "
                                                >
                                                    |
                                                </div>
                                                <p v-show="item.cake_topping">
                                                    {{
                                                        getToppingNameBasedChartItem(
                                                            item.id
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex flex-col relative left-10 sm:left-[8.5rem] lg:left-0 lg:bottom-0 items-start lg:items-center gap-2"
                                :class="{
                                    'sm:bottom-12':
                                        !item.cake_flavour ||
                                        item.cake_topping.length <= 0,
                                    'sm:bottom-6':
                                        item.cake_flavour ||
                                        item.cake_topping.length >= 1,
                                }"
                            >
                                <p class="text-lg font-medium">
                                    {{ formatPrice(item.price) }}
                                </p>
                                <div class="flex flex-row-reverse gap-4">
                                    <div class="join">
                                        <button
                                            class="btn btn-sm btn-outline shadow-lg join-item"
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
                                            class="input input-sm input-ghost input-bordered text-center w-10 join-item focus:bg-transparent"
                                            :value="item.quantity"
                                        />
                                        <button
                                            class="btn btn-sm btn-outline shadow-lg join-item"
                                            @click="item.quantity++"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <button @click="deleteItem(item.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
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
import BaseAlert from "@/Components/BaseAlert.vue";

import { ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";

const page = usePage();

const chartItems = ref(
    page.props.value.shoppingChartItems?.original.cart ?? []
);
const selectAllItem = ref(false);
const selectCake = ref({});
const totalPrice = ref(0);
const showAlert = ref(false);
const messageDelete = ref("");

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

/**
 * Deletes an item from the chartItems array and updates the chart.
 *
 * @param {number} id - The ID of the item to be deleted.
 * @return {Promise<void>} - A promise that resolves when the item is successfully deleted.
 */
const deleteItem = async (id) => {
    try {
        const response = await axios.delete(route("delete-cart-item", id));
        chartItems.value = chartItems.value.filter((item) => item.id !== id);
        messageDelete.value = response.data.message;

        window.dispatchEvent(
            new CustomEvent("delete:cartItem", {
                detail: {
                    deletedItemId: id,
                },
            })
        );
    } catch (error) {
        console.error("Error deleting item:", error);
    } finally {
        showAlert.value = true;
        setTimeout(() => {
            showAlert.value = false;
        }, 2000);
    }
};
</script>
