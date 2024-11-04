<template>
    <App>
        <section
            class="min-h-screen w-full flex flex-col gap-4 pt-36 pb-14 px-10 lg:px-20"
        >
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Shopping Chart</h1>
                <BaseAlert
                    v-show="showAlert"
                    class="w-fit py-2 font-medium ms-auto"
                    type="alert-success"
                >
                    {{ messageDelete }}
                </BaseAlert>
            </div>

            <section class="grid grid-cols-12 gap-8">
                <section
                    class="col-span-8 flex flex-col gap-6"
                    v-if="chartItems.length > 0"
                >
                    <div class="h-full px-3 py-5 bg-neutral rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <BaseCheckbox
                                :label="`Choose All (${chartItems.length})`"
                                text-color="white"
                                v-model="selectAllItem"
                                @change="isSelectedAll"
                            />
                            <p
                                v-show="totalSelectedCake > 0"
                                class="text-lg font-medium text-primary-color cursor-pointer"
                                @click="deleteItem"
                            >
                                Delete
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div
                            class="flex flex-col lg:flex-row lg:justify-between lg:items-center lg:gap-2 px-3 py-4 bg-neutral rounded-md"
                            v-for="(item, index) in chartItems"
                            :key="item.id"
                            :class="{
                                'slide-left': item.id === deleteAnimation,
                            }"
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
                                <p class="text-lg font-medium lg:ms-auto">
                                    {{ formatPrice(item.price) }}
                                </p>
                                <div
                                    class="flex flex-row-reverse items-center gap-4"
                                >
                                    <div class="join">
                                        <button
                                            class="btn btn-sm btn-outline shadow-lg join-item"
                                            @click="decrementQuantity(index)"
                                        >
                                            -
                                        </button>
                                        <input
                                            class="input input-sm input-ghost input-bordered text-center w-10 join-item focus:bg-transparent"
                                            v-model="cakeQuantity[index]"
                                        />
                                        <button
                                            class="btn btn-sm btn-outline shadow-lg join-item"
                                            @click="incrementQuantity(index)"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <button @click="deleteItem(item.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <AddNotesOrder
                                        :hiddenNotes="hiddenNotes"
                                        v-model:notes="notes[index]"
                                        @update:hiddenNotes="
                                            hiddenNotes = $event
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <EmptyDetailShoppingChart v-else />
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
                        <component
                            :is="chartItems.length <= 0 ? 'div' : 'button'"
                            :class="
                                chartItems.length <= 0
                                    ? 'bg-gray-400 hover:bg-gray-400 cursor-not-allowed'
                                    : 'bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none'
                            "
                            @click="
                                checkoutItems(
                                    chartItems.map(
                                        (item) => selectCake[item.id]
                                    )
                                )
                            "
                            class="btn btn-block mt-auto text-black"
                        >
                            <span v-show="!isSubmitting"> Checkout </span>
                            <span
                                v-show="isSubmitting"
                                class="loading loading-spinner loading-md"
                            ></span>
                            <span
                                v-show="totalSelectedCake > 0 && !isSubmitting"
                            >
                                ({{ totalSelectedCake }})
                            </span>
                        </component>
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
import EmptyDetailShoppingChart from "@/Components/EmptyDetailShoppingChart.vue";
import AddNotesOrder from "@/Components/AddNotesOrder.vue";
import { ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

const page = usePage();

const chartItems = ref(
    page.props.value.shoppingChartItems?.original.cart ?? []
);

const selectAllItem = ref(false);
const selectCake = ref({});
const totalPrice = ref(0);
const showAlert = ref(false);
const deleteAnimation = ref(null);
const messageDelete = ref("");
const isSubmitting = ref(false);
const cakeQuantity = ref(chartItems.value.map((item) => item.quantity));
const hiddenNotes = ref(false);
const notes = ref(chartItems.value.map((item) => item.notes));

const updateTotalPrice = () => {
    const selectedCake = chartItems.value
        .filter((item) => selectCake.value[item.id])
        .reduce(
            (totalPrice, item, index) =>
                totalPrice + item.price * cakeQuantity.value[index],
            0
        );

    totalPrice.value = selectedCake;

    // Check if all individual items are selected
    const allSelected = chartItems.value.every(
        (item) => selectCake.value[item.id]
    );

    // If not all are selected, uncheck "Select All"
    selectAllItem.value = allSelected;
};

// Watch for changes in the cakeQuantity array and update the total price accordingly
watch(cakeQuantity, updateTotalPrice, { deep: true });

/**
 * A computed property that returns the total number of selected cakes in the chart.
 *
 * @returns {number} The total count of selected cakes.
 */
const totalSelectedCake = computed(() => {
    return chartItems.value.filter((item) => selectCake.value[item.id]).length;
});

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
 * Deletes a shopping chart item (or multiple items if the "Select All" checkbox is checked).
 *
 * @param {number} id - The ID of the item to be deleted, or the single item ID if no items are selected.
 * @return {Promise<void>} A promise that resolves when the deletion is successful.
 */
const deleteItem = async (id) => {
    try {
        const selectedItems = chartItems.value
            .filter((item) => selectCake.value[item.id])
            .map((item) => item.id);

        // If multiple items are selected, delete them all
        const itemsToDelete = selectedItems.length > 0 ? selectedItems : [id]; // If no selected items, delete the single one

        const response = await axios.delete(route("delete-cart-item"), {
            data: {
                selectCake: itemsToDelete, // Send either multiple items or a single item in the array
            },
        });

        // Update message based on how many items were deleted
        messageDelete.value = response.data.message;

        deleteAnimation.value = id;

        setTimeout(() => {
            // Remove deleted items from chartItems
            chartItems.value = chartItems.value.filter(
                (item) => !itemsToDelete.includes(item.id)
            );

            totalPrice.value = 0;
        }, 500);

        window.dispatchEvent(
            new CustomEvent("delete:cartItem", {
                detail: {
                    deletedItemId: itemsToDelete,
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

/**
 * Initiates the checkout process by populating the shoppingChartItemsIds array with selected item IDs and redirecting to the checkout route.
 *
 * @param {array} shoppingChartItemsIds - The array to store the IDs of selected items.
 * @param {event} e - The event object, used to prevent default behavior if provided.
 * @return {void|event} Prevents default event behavior if e is provided, otherwise returns nothing.
 */
const checkoutItems = (shoppingChartItemsIds = []) => {
    // Clear the shoppingChartItemsIds array before adding items
    shoppingChartItemsIds.length = 0;

    // Populate the array with selected item IDs
    chartItems.value.forEach((item) => {
        if (selectCake.value[item.id]) {
            shoppingChartItemsIds.push(item.id);
        }
    });

    if (totalSelectedCake.value > 0) {
        try {
            isSubmitting.value = true;
            setTimeout(function () {
                Inertia.post(route("checkout"), {
                    _token: page.props.value.csrf_token,
                    selectCake: shoppingChartItemsIds,
                    cakeQuantity: cakeQuantity.value,
                    notes: notes.value,
                });
                isSubmitting.value = false;
            }, 2000);
        } catch (error) {
            console.error("Error checking out items:", error);
        }
    } else {
        return false;
    }
};

/**
 * Decrements the quantity of a cake at the specified index.
 * If the quantity is already 1 or less, the function returns false and does not decrement further.
 *
 * @param {number} index - The index of the cake in the cakeQuantity array.
 * @returns {boolean} - Returns false if the quantity is 1 or less, otherwise decrements the quantity.
 */
const decrementQuantity = (index) => {
    if (cakeQuantity.value[index] <= 1) {
        return false;
    }

    cakeQuantity.value[index]--;
};

/**
 * Increments the quantity of a specific cake in the shopping cart.
 *
 * @param {number} index - The index of the cake in the shopping cart array.
 */
const incrementQuantity = (index) => {
    cakeQuantity.value[index]++;
};
</script>
