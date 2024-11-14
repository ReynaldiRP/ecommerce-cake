<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2 gap-2 place-items-center pt-28 lg:py-0"
        >
            <section class="flex flex-col gap-10">
                <aside
                    class="breadcrumbs text-sm me-auto relative"
                    :class="
                        props.cake?.personalization_type === 'customized'
                            ? '-bottom-4'
                            : 'lg:bottom-0'
                    "
                >
                    <ul>
                        <li>
                            <inertia-link :href="route('home')"
                                >Beranda</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('products')"
                                >Katalog</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Detail Kue</inertia-link>
                        </li>
                    </ul>
                </aside>
                <ProductImage
                    :class="
                        props.cake?.personalization_type === 'customized'
                            ? 'w-[450px] h-[450px] lg:w-[600px] lg:h-[600px]'
                            : 'w-[450px] h-[450px]'
                    "
                    :cake-image="props.cake.image_url"
                />
            </section>
            <form
                @submit.prevent="addItemToChart"
                class="h-full w-full flex flex-col justify-center px-8 py-10 mt-10 gap-6"
            >
                <input type="text" hidden v-model="form.cake_id" />
                <ProductDetail :cake="totalPrice" :format-price="formatPrice" />

                <ProductFlavour
                    v-if="isCakeCustomized"
                    :flavours="props.flavour"
                    v-model="form.cake_flavour_id"
                    @update-flavour-price="handleUpdateFlavourPrice"
                    :error-responses="errorResponses"
                    :format-price="formatPrice"
                />
                <ProductTopping
                    v-if="isCakeCustomized"
                    :toppings="props.topping"
                    v-model="form.toppings"
                    @update-topping-price="handleUpdateToppingPrice"
                    :error-responses="errorResponses"
                    :format-price="formatPrice"
                />
                <ProductSize
                    v-if="isCakeCustomized"
                    v-model="form.cake_size_id"
                    :cake-size="props.size"
                    :error-responses="errorResponses"
                    @update-cake-size-price="handleUpdateCakeSizePrice"
                />
                <ProductQuantity
                    v-model="form.quantity"
                    :quantity="qty"
                    @update-quantity-price="handleUpdateQuantityPrice"
                />

                <AddToChartButton type="submit" :is-submitting="isSubmitting" />
            </form>
        </section>
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
    const totalCakePrice =
        (props.cake.base_price +
            sizePrice.value +
            flavourPrice.value +
            toppingPrice.value) *
        quantityPrice.value;
    return {
        ...props.cake,
        totalCakePrice,
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

        console.log(response.data);

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
