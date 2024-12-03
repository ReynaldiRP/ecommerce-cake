<template>
    <component
        :is="isMobileDisplayed ? 'inertia-link' : 'div'"
        @click="checkCurrentUrl"
        :class="{
            'dropdown dropdown-hover dropdown-end': !isMobileDisplayed,
        }"
    >
        <div
            :tabindex="isMobileDisplayed ? null : '0'"
            :role="isMobileDisplayed ? null : 'button'"
            class="btn btn-ghost btn-circle"
        >
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <span class="badge badge-sm indicator-item">{{
                    chartItems.length
                }}</span>
            </div>
        </div>
        <div
            v-if="chartItems.length > 0"
            tabindex="0"
            :class="{
                'card card-compact dropdown-content w-96 max-h-96 bg-base-100 shadow overflow-auto':
                    !isMobileDisplayed,
                hidden: isMobileDisplayed,
            }"
        >
            <div class="card-body border-b-2 border-neutral">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">
                        Keranjang Belanja
                        <span class="font-light">({{ chartItemsLength }})</span>
                    </h3>
                    <inertia-link
                        :href="route('detail-chart')"
                        class="text-lg text-primary-color font-bold"
                    >
                        Lihat Semua
                    </inertia-link>
                </div>
            </div>
            <div class="card-body gap-4">
                <inertia-link
                    class="flex justify-between items-center gap-2 bg-neutral rounded-lg shadow-xl"
                    v-for="(items, index) in chartItems"
                    :key="index"
                    :href="route('detail-product', items.cake?.id)"
                >
                    <div class="flex items-center gap-2">
                        <div class="avatar">
                            <div class="w-16 rounded">
                                <img
                                    :src="
                                        items.cake?.image_url ??
                                        `/assets/image/default-img.jpg`
                                    "
                                    alt="Tailwind-CSS-Avatar-component"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="font-bold text-lg m-0">
                                {{ items.cake?.name }}
                            </h1>
                            <div
                                class="flex flex-col text-sm font-medium text-opacity-70"
                            >
                                <p>
                                    {{ items.cake_flavour?.name }}
                                </p>
                                <p>
                                    {{ getToppingNameBasedChartItem(items.id) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 me-2 font-bold">
                        <p>{{ items.quantity }}</p>
                        <p>x</p>
                        <p>{{ formatPrice(items.price) }}</p>
                    </div>
                </inertia-link>
            </div>
        </div>
        <EmptyShoppingChart :is-mobile-displayed="isMobileDisplayed" v-else />
    </component>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import EmptyShoppingChart from "@/Components/EmptyShoppingChart.vue";
import { Inertia } from "@inertiajs/inertia";

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
