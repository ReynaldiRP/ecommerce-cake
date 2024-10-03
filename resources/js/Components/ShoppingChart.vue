<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
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
            class="card card-compact dropdown-content w-96 max-h-96 bg-base-100 shadow overflow-auto"
        >
            <div class="card-body border-b-2 border-neutral">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">
                        Shopping Chart
                        <span class="font-light">({{ chartItemsLength }})</span>
                    </h3>
                    <inertia-link
                        :href="route('detail-chart')"
                        class="text-lg text-primary-color font-bold"
                    >
                        View
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
                                        chartItems.cake?.image_url ??
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
                        <p>Rp{{ items.price }}</p>
                    </div>
                </inertia-link>
            </div>
        </div>
        <EmptyShoppingChart v-else />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import EmptyShoppingChart from "@/Components/EmptyShoppingChart.vue";

const page = usePage();
const chartItems = ref(
    page.props.value.shoppingChartItems?.original.cart ?? []
);

const chartItemsLength = computed(() => {
    return chartItems.value.length;
});

/**
 * Updates the shopping chart items by appending new items to the existing list.
 *
 * @param {Array} newCartItems - The new items to be added to the shopping chart.
 * @return {void}
 */
const updateCartItems = (newCartItems = []) => {
    chartItems.value = [...chartItems.value, ...newCartItems];
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
            (item) => !deletedItemId.includes(item.id)
        );
    } else {
        // Single item deletion
        chartItems.value = chartItems.value.filter(
            (item) => item.id !== deletedItemId
        );
    }
};

onMounted(() => {
    window.addEventListener("update:cartItemCount", (event) => {
        updateCartItems(event.detail.cartItems);
    });

    window.addEventListener("delete:cartItem", (event) => {
        deleteCartItems(event.detail.deletedItemId);
    });
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
</script>
