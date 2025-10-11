<template>
    <component
        :is="isMobileDisplayed ? 'inertia-link' : 'div'"
        @click="checkCurrentUrl"
        :class="{
            'dropdown dropdown-hover dropdown-end': !isMobileDisplayed,
        }"
    >
        <!-- Cart Button -->
        <div
            :tabindex="isMobileDisplayed ? null : '0'"
            :role="isMobileDisplayed ? null : 'button'"
            class="btn btn-ghost btn-circle group relative transition-all duration-300 hover:bg-white/20 hover:scale-105"
        >
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 transition-all duration-300 stroke-gray-800"
                    :class="
                        isNavbarHovered
                            ? 'stroke-neutral-content group-hover:stroke-primary'
                            : 'stroke-base-100 group-hover:stroke-primary'
                    "
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <span
                    v-if="chartItems.length > 0"
                    class="badge badge-sm indicator-item bg-gradient-to-r from-primary to-accent text-white border-0 animate-pulse-gentle shadow-lg"
                >
                    {{ chartItems.length }}
                </span>
            </div>
        </div>

        <!-- Cart Dropdown Content -->
        <div
            v-if="chartItems.length > 0"
            tabindex="0"
            :class="{
                'card dropdown-content w-[420px] max-h-[500px] bg-white/95 backdrop-blur-lg shadow-card-lg border border-white/20 overflow-hidden rounded-3xl':
                    !isMobileDisplayed,
                hidden: isMobileDisplayed,
            }"
        >
            <!-- Cart Header -->
            <div class="px-6 py-5 border-b border-gray-100/50">
                <div class="flex justify-between items-center">
                    <div class="flex flex-col space-y-1">
                        <h3
                            class="text-lg font-heading font-bold text-gray-900"
                        >
                            Keranjang Belanja
                        </h3>
                        <span class="text-sm text-gray-500">
                            {{ chartItemsLength }} item{{
                                chartItemsLength > 1 ? "s" : ""
                            }}
                        </span>
                    </div>
                    <inertia-link
                        :href="route('detail-chart')"
                        class="text-sm font-semibold text-primary hover:text-accent transition-all duration-300 flex items-center space-x-2 bg-primary/10 hover:bg-primary/20 rounded-full px-4 py-2"
                    >
                        <span>Lihat Semua</span>
                        <svg
                            class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m9 5 7 7-7 7"
                            />
                        </svg>
                    </inertia-link>
                </div>
            </div>

            <!-- Cart Items -->
            <div
                class="px-4 py-3 space-y-3 max-h-80 overflow-y-auto aside-scrollbars-light"
            >
                <inertia-link
                    v-for="(items, index) in chartItems"
                    :key="index"
                    :href="route('detail-product', items.cake?.id)"
                    class="flex items-start gap-4 p-4 bg-white/80 rounded-2xl shadow-soft hover:shadow-card transition-all duration-300 group border border-gray-100/50 hover:border-primary/20"
                >
                    <!-- Item Image -->
                    <div class="avatar flex-shrink-0">
                        <div
                            class="w-16 h-16 rounded-2xl overflow-hidden shadow-soft ring-2 ring-gray-100 group-hover:ring-primary/30 transition-all duration-300"
                        >
                            <img
                                :src="
                                    items.cake?.image_url ??
                                    `/assets/image/default-img.jpg`
                                "
                                :alt="`Gambar ${items.cake?.name}`"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            />
                        </div>
                    </div>

                    <!-- Item Details -->
                    <div class="flex-1 min-w-0 space-y-2">
                        <div class="flex justify-between items-start gap-3">
                            <h4
                                class="font-semibold text-gray-900 text-sm leading-tight group-hover:text-primary transition-colors duration-300"
                            >
                                {{ items.cake?.name }}
                            </h4>
                            <div
                                class="flex flex-col items-end space-y-1 flex-shrink-0"
                            >
                                <div
                                    class="bg-primary/15 text-primary text-xs font-bold px-3 py-1 rounded-full"
                                >
                                    {{ items.quantity }}x
                                </div>
                                <div class="font-bold text-primary text-sm">
                                    {{ formatPrice(items.price) }}
                                </div>
                            </div>
                        </div>

                        <!-- Item Specifications -->
                        <div class="space-y-1.5">
                            <div
                                v-if="items.cake_flavour?.name"
                                class="flex items-center space-x-2 text-xs text-gray-600"
                            >
                                <div
                                    class="w-2 h-2 bg-primary/50 rounded-full flex-shrink-0"
                                ></div>
                                <span class="font-medium">Rasa:</span>
                                <span>{{ items.cake_flavour?.name }}</span>
                            </div>
                            <div
                                v-if="getToppingNameBasedChartItem(items.id)"
                                class="flex items-center space-x-2 text-xs text-gray-600"
                            >
                                <div
                                    class="w-2 h-2 bg-accent/50 rounded-full flex-shrink-0"
                                ></div>
                                <span class="font-medium">Topping:</span>
                                <span class="truncate">{{
                                    getToppingNameBasedChartItem(items.id)
                                }}</span>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </div>

            <!-- Cart Footer -->
            <div class="px-6 py-5 border-t border-gray-100/50">
                <inertia-link
                    :href="route('detail-chart')"
                    class="btn btn-modern w-full bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover transition-all duration-300 shadow-card hover:shadow-card-hover transform hover:scale-[1.02] border-0 py-3"
                >
                    <svg
                        class="w-5 h-5 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    Lihat Keranjang Lengkap
                </inertia-link>
            </div>
        </div>

        <!-- Empty Cart Component -->
        <EmptyShoppingChart :is-mobile-displayed="isMobileDisplayed" v-else />
    </component>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import EmptyShoppingChart from "@/Components/EmptyShoppingChart.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    isNavbarHovered: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const chartItems = ref(
    page.props.value.shoppingChartItems?.original.cart ?? [],
);

const chartItemsLength = computed(() => {
    return chartItems.value.length;
});

const isMobileDisplayed = ref(false);
const pageWidth = ref(window.innerWidth);

/**
 * Updates the shopping chart items by appending new items to the existing list.
 *
 * @param event
 * @param event
 */
const updateCartItems = (event) => {
    chartItems.value = [...chartItems.value, ...event.detail.cartItems];
};

/**
 * Deletes items from the shopping chart by their IDs.
 *
 * @param {Array<number>|number} deletedItemId - The ID(s) of the item(s) to be deleted.
 * @return {void}
 */
const deleteCartItems = (deletedItemId = []) => {
    if (Array.isArray(deletedItemId)) {
        chartItems.value = chartItems.value.filter(
            (item) => !deletedItemId.includes(item.id),
        );
    } else {
        // Single item deletion
        chartItems.value = chartItems.value.filter(
            (item) => item.id !== deletedItemId,
        );
    }
};

// This function is called when the component is mounted.
// It adds event listeners to the window object.
onMounted(() => {
    // The first event listener listens for the "update:cartItemCount" event and calls the updateCartItems function when triggered.
    window.addEventListener("update:cartItemCount", updateCartItems);
    // The second event listener listens for the "delete:cartItem" event and calls the deleteCartItems function with the deletedItemId from the event detail when triggered.
    window.addEventListener("delete:cartItem", (event) => {
        deleteCartItems(event.detail.deletedItemId);
    });

    pageWidth.value = window.innerWidth;
    handleRezize();

    window.addEventListener("resize", handleRezize);
});

onUnmounted(() => {
    window.removeEventListener("update:cartItemCount", updateCartItems);
    window.removeEventListener("delete:cartItem", (event) => {
        deleteCartItems(event.detail.deletedItemId);
    });

    window.addEventListener("resize", handleRezize);
});

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
 * Handles the resize event by updating the page width value with the current inner width of the window.
 */
const handleRezize = () => {
    pageWidth.value = window.innerWidth;

    isMobileDisplayed.value = pageWidth.value <= 640;
};

/**
 * Checks the current URL to see if it includes "order-history".
 * If not, it redirects to the "order.history" route.
 * Prevents the default action of the event.
 *
 * @param {Event} e - The event object.
 */
const checkCurrentUrl = (e) => {
    const currentUrl = window.location.href;

    if (currentUrl.includes("detail-chart")) {
        // Prevent default navigation if already on the detail-chart page
        e.preventDefault();
    } else {
        // Use Inertia to navigate to the "detail-chart" route
        Inertia.visit(route("detail-chart"));
    }
};

watch(pageWidth, (newWidth) => {
    isMobileDisplayed.value = newWidth <= 640;
});

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
</script>
