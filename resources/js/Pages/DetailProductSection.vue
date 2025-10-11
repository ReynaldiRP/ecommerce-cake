<template>
    <App>
        <!-- Main Product Detail Section -->
        <section class="min-h-screen w-full bg-gradient-soft">
            <div class="container mx-auto px-6 lg:px-12 py-8 lg:py-16">
                <!-- Breadcrumbs -->
                <nav
                    class="flex mb-10 animate-slide-up relative top-5"
                    aria-label="Breadcrumb"
                >
                    <ol class="inline-flex items-center space-x-2 md:space-x-3">
                        <li class="inline-flex items-center">
                            <inertia-link
                                :href="route('home')"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                    ></path>
                                </svg>
                                Beranda
                            </inertia-link>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg
                                    class="w-6 h-6 text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <inertia-link
                                    :href="route('products')"
                                    class="ml-2 text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200"
                                >
                                    Katalog
                                </inertia-link>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg
                                    class="w-6 h-6 text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span
                                    class="ml-2 text-sm font-medium text-gray-600"
                                    >Detail Kue</span
                                >
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Product Content Grid -->
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start"
                >
                    <!-- Product Image Section -->
                    <div
                        class="flex flex-col space-y-6 animate-slide-up"
                        style="animation-delay: 0.1s"
                    >
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-primary/20 to-accent/20 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"
                            ></div>
                            <ProductImage
                                :class="[
                                    'relative rounded-2xl overflow-hidden shadow-card-lg transition-all duration-300 group-hover:shadow-card-hover',
                                    props.cake?.personalization_type ===
                                    'customized'
                                        ? 'w-full max-w-md lg:max-w-lg h-80 sm:h-96 lg:h-[500px]'
                                        : 'w-full max-w-md h-80 sm:h-96',
                                ]"
                                :cake-image="props.cake.image_url"
                            />
                        </div>
                    </div>

                    <!-- Product Configuration Form -->
                    <div
                        class="flex flex-col justify-start animate-slide-up"
                        style="animation-delay: 0.2s"
                    >
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card-lg p-6 lg:p-8 border border-white/50"
                        >
                            <form
                                @submit.prevent="addItemToChart"
                                class="space-y-8"
                            >
                                <input
                                    type="text"
                                    hidden
                                    v-model="form.cake_id"
                                />

                                <!-- Product Details -->
                                <div class="space-y-6">
                                    <ProductDetail
                                        :cake="totalPrice"
                                        :format-price="formatPrice"
                                    />
                                </div>

                                <!-- Product Customization Options -->
                                <div
                                    v-if="isCakeCustomized"
                                    class="space-y-6 border-t border-gray-100 pt-6"
                                >
                                    <h3
                                        class="text-lg font-heading font-semibold text-gray-900 mb-4"
                                    >
                                        Kustomisasi Produk
                                    </h3>

                                    <ProductFlavour
                                        :flavours="props.flavour"
                                        v-model="form.cake_flavour_id"
                                        @update-flavour-price="
                                            handleUpdateFlavourPrice
                                        "
                                        :error-responses="errorResponses"
                                        :format-price="formatPrice"
                                        class="animate-slide-up"
                                        style="animation-delay: 0.3s"
                                    />

                                    <ProductTopping
                                        :toppings="props.topping"
                                        v-model="form.toppings"
                                        @update-topping-price="
                                            handleUpdateToppingPrice
                                        "
                                        :error-responses="errorResponses"
                                        :format-price="formatPrice"
                                        class="animate-slide-up"
                                        style="animation-delay: 0.4s"
                                    />

                                    <ProductSize
                                        v-model="form.cake_size_id"
                                        :cake-size="props.size"
                                        :error-responses="errorResponses"
                                        :format-price="formatPrice"
                                        @update-cake-size-price="
                                            handleUpdateCakeSizePrice
                                        "
                                        class="animate-slide-up"
                                        style="animation-delay: 0.5s"
                                    />
                                </div>

                                <!-- Quantity and Add to Cart -->
                                <div
                                    class="space-y-6 border-t border-gray-100 pt-6"
                                >
                                    <ProductQuantity
                                        v-model="form.quantity"
                                        :quantity="qty"
                                        @update-quantity-price="
                                            handleUpdateQuantityPrice
                                        "
                                        class="animate-slide-up"
                                        style="animation-delay: 0.6s"
                                    />

                                    <AddToChartButton
                                        type="submit"
                                        :is-submitting="isSubmitting"
                                        class="w-full animate-slide-up"
                                        style="animation-delay: 0.7s"
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Preview Modal -->
        <PreviewChartItem
            :is-preview-open="isPreviewOpen"
            :chart="chartItem"
            :successMessage="successMessage"
            @update:isPreviewOpen="isPreviewOpen = $event"
        />
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import ProductImage from "@/Components/DetailProduct/ProductImage.vue";
import ProductDetail from "@/Components/DetailProduct/ProductDetail.vue";
import ProductFlavour from "@/Components/DetailProduct/ProductFlavour.vue";
import ProductTopping from "@/Components/DetailProduct/ProductTopping.vue";
import ProductQuantity from "@/Components/DetailProduct/ProductQuantity.vue";
import AddToChartButton from "@/Components/DetailProduct/AddToChartButton.vue";
import PreviewChartItem from "@/Components/PreviewChartItem.vue";
import ProductSize from "@/Components/DetailProduct/ProductSize.vue";
import { computed, reactive, ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

const props = defineProps({
    cake: {
        type: Object,
    },
    flavour: {
        type: Object,
    },
    topping: {
        type: Object,
    },
    size: {
        type: Array,
    },
});

const qty = [1, 2, 3, 4, 5];

const selected = reactive({
    flavour: null,
    topping: [],
    quantity: qty[0],
    size: "",
});

const flavourPrice = ref(0);
const toppingPrice = ref(0);
const quantityPrice = ref(1);
const sizePrice = ref(0);
const isPreviewOpen = ref(false);
const chartItem = ref([]);
const successMessage = ref("");
const isSubmitting = ref(false);
const errorResponses = ref([]);

/**
 * Updates the flavour price state with the provided price value.
 *
 * @param {number} price - The new flavour price value
 * @return {void}
 */
const handleUpdateFlavourPrice = (price) => {
    flavourPrice.value = price;
};

/**
 * Updates the topping price state with the provided price value.
 *
 * @param {number} price - The new topping price value
 * @return {void}
 */
const handleUpdateToppingPrice = (price) => {
    toppingPrice.value = price;
};

/**
 * Updates the quantity price state with the provided quantity value.
 *
 * @param {number} price
 * @return {void}
 */
const handleUpdateQuantityPrice = (price) => {
    quantityPrice.value = parseInt(price);
};

/**
 * Updates the cake size price state with the provided size id.
 *
 * @param {number} size - The new cake size value
 * @return {void}
 */
const handleUpdateCakeSizePrice = (size) => {
    sizePrice.value = Object.values(props.size).find(
        (cakeSize) => cakeSize.id === size,
    ).price;
};

/**
 * Computes the total price of the cake based on its base price, flavour price, cake size and quantity.
 *
 * @return {object} An object containing the cake details and the calculated total price
 */
const totalPrice = computed(() => {
    if (!props.cake.discount) {
        return {
            ...props.cake,
            totalCakePrice:
                (props.cake.base_price +
                    sizePrice.value +
                    flavourPrice.value +
                    toppingPrice.value) *
                quantityPrice.value,
        };
    }

    const totalDiscountedPrice =
        (props.cake.discounted_price +
            sizePrice.value +
            flavourPrice.value +
            toppingPrice.value) *
        quantityPrice.value;

    return {
        ...props.cake,
        totalCakePrice: totalDiscountedPrice,
    };
});

const form = useForm({
    cake_id: props.cake.id,
    cake_flavour_id: selected.flavour,
    toppings: selected.topping,
    quantity: selected.quantity,
    price: totalPrice.value.totalCakePrice,
    cake_size_id: selected.size,
});

watch(
    () => totalPrice.value.totalCakePrice,
    (newPrice) => {
        form.price = newPrice;
    },
);

const isCakeCustomized = computed(() => {
    return props.cake?.personalization_type === "customized";
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

/**
 * Submits the form to add a new item to the shopping cart.
 *
 * This function performs an AJAX POST request to the route "add-chart-item" with the form data.
 * On success, it updates the chartItem state with the new item, sets the success message and
 * shows the PreviewChartItem component.
 *
 * If there is an error, it sets the errorResponses state with the error messages and scrolls
 * the page to the top.
 *
 * It also dispatches a custom event "update:cartItemCount" with the new cart items count.
 *
 * @return {Promise<void>}
 */
const addItemToChart = async () => {
    try {
        const response = await axios.post(route("add-chart-item"), form);

        chartItem.value = response.data.cartItem;
        successMessage.value = response.data.message;

        isSubmitting.value = true;

        setTimeout(function () {
            isSubmitting.value = false;

            isPreviewOpen.value = true;
            errorResponses.value = {};

            window.dispatchEvent(
                new CustomEvent("update:cartItemCount", {
                    detail: {
                        cartItems: response.data.cartItems,
                    },
                }),
            );
        }, 2000);
    } catch (error) {
        isSubmitting.value = true;

        setTimeout(function () {
            isSubmitting.value = false;

            window.scrollTo({ top: 0, behavior: "smooth" });
            errorResponses.value = error.response.data.errors;
        }, 2000);
    }
};
</script>

<style scoped>
/* Custom input and select styles to match design system */
:deep(.input) {
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 1rem;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    color: #1f2937;
    min-height: 3.5rem;
}

:deep(.input:focus-within) {
    border-color: #d946ef;
    box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1);
    background-color: #ffffff;
    outline: none;
}

:deep(.input input) {
    background: transparent;
    border: none;
    outline: none;
    color: #1f2937;
}

:deep(.input input::placeholder) {
    color: #9ca3af;
}

:deep(.input:hover) {
    border-color: #cbd5e1;
}

/* Error state */
:deep(.input.border-error) {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Focus state for icons */
:deep(.input:focus-within svg) {
    color: #d946ef;
}

/* Select dropdown styling */
:deep(.select) {
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 1rem;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    color: #1f2937;
    min-height: 3.5rem;
}

:deep(.select:focus) {
    border-color: #d946ef;
    box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1);
    background-color: #ffffff;
    outline: none;
}

:deep(.select:hover) {
    border-color: #cbd5e1;
}

/* Radio button styling */
:deep(input[type="radio"]) {
    accent-color: #d946ef;
}

:deep(input[type="radio"]:checked) {
    background-color: #d946ef;
    border-color: #d946ef;
}

/* Checkbox styling */
:deep(input[type="checkbox"]) {
    accent-color: #d946ef;
}

:deep(input[type="checkbox"]:checked) {
    background-color: #d946ef;
    border-color: #d946ef;
}

/* Custom form controls */
:deep(.form-control) {
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

:deep(.form-control:focus) {
    border-color: #d946ef;
    box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1);
    background-color: #ffffff;
}

/* Range input styling */
:deep(input[type="range"]) {
    accent-color: #d946ef;
}

:deep(input[type="range"]::-webkit-slider-thumb) {
    background-color: #d946ef;
}

:deep(input[type="range"]::-moz-range-thumb) {
    background-color: #d946ef;
    border-color: #d946ef;
}
</style>
