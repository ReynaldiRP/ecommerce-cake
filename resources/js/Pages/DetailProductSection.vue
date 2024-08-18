<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2 gap-2 place-items-center pt-28 lg:py-0"
        >
            <section class="flex flex-col gap-10">
                <div
                    class="breadcrumbs text-sm me-auto relative"
                    :class="props.cake?.personalization_type == 'customized' ? 'lg:bottom-8' : 'lg:bottom-0'"
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
                </div>
                <ProductImage :cake-image="props.cake.image_url" />
            </section>
            <section
                class="h-full w-full flex flex-col justify-center px-8 py-10 mt-10 gap-6"
            >
                <ProductDetail
                    :cake="totalPrice"
                    :cake-description="description"
                />
                <ProductFlavour
                    v-show="props.cake?.personalization_type == 'customized'"
                    :flavours="props.flavour"
                />
                <ProductTopping
                    v-show="props.cake?.personalization_type == 'customized'"
                    :toppings="props.topping"
                />
                <ProductQuantity :quantity="5" />
                <AddToChartButton type="default" />
            </section>
        </section>
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
import { computed } from "vue";

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

const totalPrice = computed(() => {
    const cakeSizedPrice = props.cake.cake_size
        ? props.cake.cake_size.price
        : 0;
    const totalCakePrice = props.cake.base_price + cakeSizedPrice;
    return {
        ...props.cake,
        totalCakePrice,
    };
});

console.log(totalPrice.value);

const description = `Lorem, ipsum dolor sit amet consectetur
    adipisicing elit. Sunt corporis numquam rem sequi consequuntur
    inventore minus excepturi. Animi tempore dignissimos, delectus iusto nisi
    eligendi vero inventore ex, sapiente expedita impedit. Lorem ipsum dolor sit amet
    consectetur adipisicing elit. Laudantium, repellat optio mollitia iure,
    dicta reiciendis, laborum quibusdam repellendus expedita cumque error
    obcaecati dolorem architecto consequuntur ratione! Ipsum deserunt cupiditate beatae.`;
</script>
