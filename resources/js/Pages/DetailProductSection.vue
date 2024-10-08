<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2 gap-2 place-items-center pt-28 lg:py-0"
        >
            <section class="flex flex-col gap-10">
                <aside
                    class="breadcrumbs text-sm me-auto relative"
                    :class="
                        props.cake?.personalization_type == 'customized'
                            ? '-bottom-4'
                            : 'lg:bottom-0'
                    "
                >
                    <ul>
                        <li>
                            <inertia-link :href="route('home')"
                                >Home</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('products')"
                                >Catalouge</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Detail Product</inertia-link>
                        </li>
                    </ul>
                </aside>
                <ProductImage
                    :class="
                        props.cake?.personalization_type == 'customized'
                            ? 'w-[450px] h-[450px] lg:w-[600px] lg:h-[600px]'
                            : 'w-[450px] h-[450px]'
                    "
                    :cake-image="props.cake.image_url"
                />
            </section>
            <form
                @submit.prevent="submit"
                class="h-full w-full flex flex-col justify-center px-8 py-10 mt-10 gap-6"
            >
                <input type="text" hidden v-model="form.cake_id" />
                <ProductDetail :cake="totalPrice" />

                <ProductFlavour
                    v-show="isCakeCustomized"
                    :flavours="props.flavour"
                    v-model="form.cake_flavour_id"
                    @update-flavour-price="handleUpdateFlavourPrice"
                    :error-responses="errorResponses"
                />
                <ProductTopping
                    v-show="isCakeCustomized"
                    :toppings="props.topping"
                    v-model="form.toppings"
                    @update-topping-price="handleUpdateToppingPrice"
                    :error-responses="errorResponses"
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
            :successMessage="succesMessage"
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
import { computed, ref, reactive, watch } from "vue";
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
});

const qty = [1, 2, 3, 4, 5];

const selected = reactive({
    flavour: null,
    topping: [],
    quantity: qty[0],
});

const flavourPrice = ref(0);
const toppingPrice = ref(0);
const quantityPrice = ref(1);
const isPreviewOpen = ref(false);
const chartItem = ref([]);
const succesMessage = ref("");
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
 * @param {number} quantity - The new quantity value
 * @return {void}
 */
const handleUpdateQuantityPrice = (quantity) => {
    quantityPrice.value = quantity;
};

/**
 * Computes the total price of the cake based on its base price, flavour price, cake size and quantity.
 *
 * @return {object} An object containing the cake details and the calculated total price
 */
const totalPrice = computed(() => {
    const cakeSizedPrice = props.cake.cake_size
        ? props.cake.cake_size.price
        : 0;
    const totalCakePrice =
        (props.cake.base_price +
            cakeSizedPrice +
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
});

watch(
    () => totalPrice.value.totalCakePrice,
    (newPrice) => {
        form.price = newPrice;
    }
);

const isCakeCustomized = computed(() => {
    return props.cake?.personalization_type === "customized";
});

/**
 * Adds an item to the chart.
 *
 * @return {Promise<void>} - A promise that resolves when the item is added to the chart.
 */
const addItemToChart = async () => {
    try {
        const response = await axios.post(route("add-chart-item"), form);

        chartItem.value = response.data.cartItem;
        succesMessage.value = response.data.message;

        window.dispatchEvent(
            new CustomEvent("update:cartItemCount", {
                detail: {
                    cartItems: response.data.cartItems,
                },
            })
        );

        return response.data;
    } catch (error) {
        return { error: true, message: error.response.data.errors };
    }
};

/**
 * Submits the form and adds the item to the chart after a 3-second delay.
 *
 * @return {void}
 */
const submit = async () => {
    try {
        isSubmitting.value = true;
        console.log(form);

        const results = await addItemToChart();

        setTimeout(function () {
            isSubmitting.value = false;
            window.scrollTo({ top: 0, behavior: "smooth" });

            if (results && !results.error) {
                isPreviewOpen.value = true;
            } else {
                errorResponses.value = results.message;
            }
        }, 2000);
    } catch (error) {
        console.error("Request failed:", error);
    }
};
</script>
