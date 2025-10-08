<template>
    <App>
        <section class="min-h-screen w-full bg-gradient-soft">
            <div class="container mx-auto px-6 lg:px-12 pt-24 pb-16">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8"
                >
                    <div class="space-y-2">
                        <h1
                            class="text-2xl lg:text-3xl font-heading font-bold text-gray-900 leading-tight"
                        >
                            Keranjang Belanja
                        </h1>
                        <p class="text-gray-600">
                            Kelola pesanan Anda sebelum checkout
                        </p>
                    </div>
                    <BaseAlert
                        v-show="showAlert"
                        class="w-fit py-3 px-6 font-medium bg-green-50 border border-green-200 text-green-800 rounded-2xl shadow-soft"
                        type="alert-success"
                    >
                        {{ messageDelete }}
                    </BaseAlert>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                    <!-- Cart Items Section -->
                    <div class="xl:col-span-8">
                        <div v-if="chartItems.length > 0" class="space-y-6">
                            <!-- Select All Header -->
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6"
                            >
                                <div class="flex justify-between items-center">
                                    <BaseCheckbox
                                        :label="`Pilih Semua (${chartItems.length} item${chartItems.length > 1 ? 's' : ''})`"
                                        text-color="gray-900"
                                        v-model="selectAllItem"
                                        @change="isSelectedAll"
                                        class="text-gray-900 font-semibold"
                                    />
                                    <button
                                        v-show="totalSelectedCake > 0"
                                        class="text-red-600 hover:text-red-700 font-semibold px-4 py-2 rounded-full hover:bg-red-50 transition-all duration-200 text-sm"
                                        @click="deleteItem"
                                    >
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus ({{ totalSelectedCake }})
                                    </button>
                                </div>
                            </div>

                            <!-- Cart Items List -->
                            <div class="space-y-4">
                                <div
                                    v-for="(item, index) in chartItems"
                                    :key="item.id"
                                    :class="{
                                        'slide-left':
                                            item.id === deleteAnimation,
                                    }"
                                    class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 transition-all duration-300 hover:shadow-card-hover"
                                >
                                    <div
                                        class="flex flex-col lg:flex-row gap-6"
                                    >
                                        <!-- Checkbox and Product Info -->
                                        <div class="flex gap-4 flex-1">
                                            <BaseCheckbox
                                                v-model="selectCake[item.id]"
                                                :value="item.id"
                                                class="mt-1"
                                            />

                                            <!-- Product Image -->
                                            <div class="avatar flex-shrink-0">
                                                <div
                                                    class="w-20 h-20 lg:w-24 lg:h-24 rounded-2xl overflow-hidden shadow-soft ring-2 ring-gray-100"
                                                >
                                                    <img
                                                        :src="
                                                            item.cake
                                                                .image_url ||
                                                            '/assets/image/default-img.jpg'
                                                        "
                                                        :alt="item.cake?.name"
                                                        class="w-full h-full object-cover"
                                                    />
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 space-y-2">
                                                <h3
                                                    class="text-lg lg:text-xl font-semibold text-gray-900 leading-tight"
                                                >
                                                    {{ item.cake?.name }}
                                                    <span
                                                        v-if="item.cake_size"
                                                        class="text-primary font-medium"
                                                    >
                                                        ({{
                                                            item.cake_size
                                                                ?.size
                                                        }}cm)
                                                    </span>
                                                </h3>

                                                <!-- Specifications -->
                                                <div
                                                    class="flex flex-wrap gap-4 text-sm text-gray-600"
                                                >
                                                    <div
                                                        v-if="item.cake_flavour"
                                                        class="flex items-center space-x-2"
                                                    >
                                                        <div
                                                            class="w-2 h-2 bg-primary/50 rounded-full"
                                                        ></div>
                                                        <span
                                                            class="font-medium"
                                                            >Rasa:</span
                                                        >
                                                        <span>{{
                                                            item.cake_flavour
                                                                ?.name
                                                        }}</span>
                                                    </div>
                                                    <div
                                                        v-if="
                                                            getToppingNameBasedChartItem(
                                                                item.id,
                                                            )
                                                        "
                                                        class="flex items-center space-x-2"
                                                    >
                                                        <div
                                                            class="w-2 h-2 bg-accent/50 rounded-full"
                                                        ></div>
                                                        <span
                                                            class="font-medium"
                                                            >Topping:</span
                                                        >
                                                        <span>{{
                                                            getToppingNameBasedChartItem(
                                                                item.id,
                                                            )
                                                        }}</span>
                                                    </div>
                                                </div>

                                                <!-- Price Display -->
                                                <div
                                                    class="text-xl font-bold text-primary"
                                                >
                                                    {{
                                                        formattedSubTotal[index]
                                                    }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions Section -->
                                        <div
                                            class="flex flex-col lg:flex-row items-start lg:items-center gap-4"
                                        >
                                            <!-- Quantity Controls -->
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <span
                                                    class="text-sm font-medium text-gray-600"
                                                    >Jumlah:</span
                                                >
                                                <div
                                                    class="join bg-gray-50 rounded-xl"
                                                >
                                                    <button
                                                        class="btn btn-sm join-item bg-white hover:bg-gray-50 border-gray-200"
                                                        @click="
                                                            decrementQuantity(
                                                                item,
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-minus text-xs"
                                                        ></i>
                                                    </button>
                                                    <input
                                                        class="input input-sm input-bordered text-center w-16 join-item bg-white focus:bg-white"
                                                        v-model="
                                                            cakeQuantity[
                                                                item.id
                                                            ]
                                                        "
                                                        readonly
                                                    />
                                                    <button
                                                        class="btn btn-sm join-item bg-white hover:bg-gray-50 border-gray-200"
                                                        @click="
                                                            incrementQuantity(
                                                                item,
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-plus text-xs"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <AddNotesOrder
                                                    v-model:notes="
                                                        notes[item.id]
                                                    "
                                                />
                                                <button
                                                    @click="deleteItem(item.id)"
                                                    class="btn btn-sm btn-circle bg-red-50 hover:bg-red-100 border-red-200 text-red-600"
                                                >
                                                    <i
                                                        class="fas fa-trash text-xs"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <EmptyDetailShoppingChart v-else />
                    </div>
                    <!-- Order Summary Section -->
                    <div class="xl:col-span-4">
                        <div class="sticky top-8">
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-6 lg:p-8"
                            >
                                <!-- Summary Header -->
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center"
                                    >
                                        <i
                                            class="fas fa-shopping-cart text-white"
                                        ></i>
                                    </div>
                                    <h2
                                        class="text-xl lg:text-2xl font-heading font-bold text-gray-900"
                                    >
                                        Ringkasan Belanja
                                    </h2>
                                </div>

                                <!-- Total Price -->
                                <div
                                    class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-2xl p-4 mb-6"
                                >
                                    <div
                                        class="flex justify-between items-center"
                                    >
                                        <span
                                            class="text-lg font-semibold text-gray-700"
                                            >Total Pembayaran</span
                                        >
                                        <span
                                            class="text-2xl font-bold text-primary"
                                            >{{ formatPrice(totalPrice) }}</span
                                        >
                                    </div>
                                    <div
                                        v-if="totalSelectedCake > 0"
                                        class="text-sm text-gray-500 mt-1"
                                    >
                                        {{ totalSelectedCake }} item{{
                                            totalSelectedCake > 1 ? "s" : ""
                                        }}
                                        dipilih
                                    </div>
                                </div>

                                <!-- Checkout Button -->
                                <component
                                    :is="
                                        chartItems.length <= 0
                                            ? 'div'
                                            : 'button'
                                    "
                                    :class="[
                                        'btn w-full py-4 text-lg font-semibold rounded-2xl transition-all duration-300',
                                        chartItems.length <= 0 ||
                                        totalSelectedCake <= 0
                                            ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            : 'btn-modern bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover shadow-card hover:shadow-card-hover transform hover:scale-[1.02]',
                                    ]"
                                    :disabled="
                                        chartItems.length <= 0 ||
                                        totalSelectedCake <= 0
                                    "
                                    @click="
                                        checkoutItems(
                                            chartItems.map(
                                                (item) => selectCake[item.id],
                                            ),
                                        )
                                    "
                                >
                                    <span
                                        v-if="!isSubmitting"
                                        class="flex items-center justify-center space-x-2"
                                    >
                                        <i class="fas fa-credit-card"></i>
                                        <span>
                                            Checkout
                                            <span v-if="totalSelectedCake > 0">
                                                ({{ totalSelectedCake }})
                                            </span>
                                        </span>
                                    </span>
                                    <span
                                        v-else
                                        class="flex items-center justify-center space-x-2"
                                    >
                                        <span
                                            class="loading loading-spinner loading-md"
                                        ></span>
                                        <span>Memproses...</span>
                                    </span>
                                </component>

                                <!-- Checkout Info -->
                                <div
                                    class="mt-4 p-4 bg-blue-50 rounded-2xl border border-blue-100"
                                >
                                    <div class="flex items-start space-x-3">
                                        <i
                                            class="fas fa-info-circle text-blue-500 mt-0.5"
                                        ></i>
                                        <div class="text-sm text-blue-700">
                                            <p class="font-semibold mb-1">
                                                Informasi Checkout
                                            </p>
                                            <ul class="space-y-1 text-xs">
                                                <li>
                                                    • Pilih item yang ingin
                                                    dibeli
                                                </li>
                                                <li>
                                                    • Pastikan jumlah sudah
                                                    sesuai
                                                </li>
                                                <li>
                                                    • Klik checkout untuk
                                                    melanjutkan
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import EmptyDetailShoppingChart from "@/Components/EmptyDetailShoppingChart.vue";
import AddNotesOrder from "@/Components/AddNotesOrder.vue";
import { computed, onMounted, ref, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

const page = usePage();

const chartItems = ref(
    page.props.value.shoppingChartItems?.original.cart ?? [],
);

const selectAllItem = ref(false);
const selectCake = ref({});
const totalPrice = ref(0);
const showAlert = ref(false);
const deleteAnimation = ref(null);
const messageDelete = ref("");
const isSubmitting = ref(false);
const cakeQuantity = ref({
    ...Object.fromEntries(
        chartItems.value.map((item) => [item.id, item.quantity]),
    ),
});
// No longer need hiddenNotes since each component manages its own state
const notes = ref({});
const totalPriceEachItem = ref([]);

onMounted(() => {
    /**
     * Retrieves the chart item ID from the URL query parameters and updates the selectCake object.
     * If a chart item ID is found, it sets the corresponding value in selectCake to true.
     */
    const chartItemId = new URLSearchParams(window.location.search).get(
        "chartItemId",
    );

    if (chartItemId) {
        selectCake.value[chartItemId] = true;

        // check if select all item is true
        selectAllItem.value = chartItems.value.every(
            (item) => selectCake.value[item.id],
        );
    }
});

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
    return chartItems.value.map((item) => {
        const flavourPrice = item.cake_flavour?.price ?? 0;
        const toppingPrice = item.cake_topping.reduce(
            (total, topping) => total + topping.price,
            0,
        );
        const cakeSizePrice = item.cake_size?.price ?? 0;

        // check if cake has discount
        if (!item.cake.discount) {
            const cakePrice = item.cake?.base_price;

            return cakePrice + flavourPrice + toppingPrice + cakeSizePrice;
        } else {
            const discountedCakePrice =
                item.cake?.base_price *
                (1 - item.cake.discount.discount_percentage / 100);

            return (
                discountedCakePrice +
                flavourPrice +
                toppingPrice +
                cakeSizePrice
            );
        }
    });
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

const formattedSubTotal = subtotal().map(formatPrice);

watch(
    [selectCake, cakeQuantity],
    () => {
        totalPrice.value = chartItems.value
            .filter((item) => selectCake.value[item.id])
            .reduce((totalPrice, item) => {
                const itemIndex = chartItems.value.findIndex(
                    (chartItem) => chartItem.id === item.id,
                );

                return (
                    totalPrice +
                    subtotal()[itemIndex] * cakeQuantity.value[item.id]
                );
            }, 0);

        totalPriceEachItem.value = chartItems.value.reduce((total, item) => {
            const itemIndex = chartItems.value.findIndex(
                (chartItem) => chartItem.id === item.id,
            );

            return {
                ...total,
                [item.id]: subtotal()[itemIndex] * cakeQuantity.value[item.id],
            };
        }, {});

        // check if select all item is true
        selectAllItem.value = chartItems.value.every(
            (item) => selectCake.value[item.id],
        );
    },
    {
        deep: true,
    },
);

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
                (item) => !itemsToDelete.includes(item.id),
            );

            totalPrice.value = 0;
        }, 500);

        window.dispatchEvent(
            new CustomEvent("delete:cartItem", {
                detail: {
                    deletedItemId: itemsToDelete,
                },
            }),
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
                    cakesPrice: totalPriceEachItem.value,
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
 *
 * @param {number} item - The index of the cake item to decrement the quantity.
 * @returns {void} - Decrements the quantity of the cake.
 */
const decrementQuantity = (item) => {
    if (cakeQuantity.value[item.id] <= 1) {
        return false;
    }

    cakeQuantity.value[item.id]--;
};

/**
 * Increments the quantity of a cake at the specified index.
 *
 * @param {object} item - The cake item to increment the quantity.
 * @returns {void} - Increments the quantity of the cake.
 */
const incrementQuantity = (item) => {
    cakeQuantity.value[item.id]++;
};
</script>
