<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2 gap-2 place-items-center pt-28 lg:py-0"
        >
            <section class="flex flex-col gap-10">
                <div
                    class="breadcrumbs text-sm me-auto relative top-2 lg:right-28"
                >
                    <ul>
                        <li>
                            <inertia-link :href="route('/home')"
                                >Home</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('/products')"
                                >Catalouge</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('/detail-product')"
                                >Detail Product</inertia-link
                            >
                        </li>
                    </ul>
                </div>
                <ProductImage url="assets/image/home-image-cake.png" />
            </section>
            <section
                class="h-full w-full flex flex-col justify-center px-8 mt-10 gap-6"
            >
                <ProductDetail
                    :cake-name="detailProduct.name"
                    :cake-price="detailProduct.price"
                    :cake-description="detailProduct.description"
                />
                <ProductFlavour :data="data" />
                <ProductTopping :toppings="toppings" />
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

const detailProduct = {
    name: "Cake Name",
    price: 15000,
    description: `Lorem, ipsum dolor sit amet consectetur
    adipisicing elit. Sunt corporis numquam rem sequi consequuntur
    inventore minus excepturi. Animi tempore dignissimos, delectus iusto nisi
    eligendi vero inventore ex, sapiente expedita impedit. Lorem ipsum dolor sit amet
    consectetur adipisicing elit. Laudantium, repellat optio mollitia iure,
    dicta reiciendis, laborum quibusdam repellendus expedita cumque error
    obcaecati dolorem architecto consequuntur ratione! Ipsum deserunt cupiditate beatae.`,
};
const data = [
    {
        name: "Vanilla",
    },
    {
        name: "Red Velvet",
    },
    {
        name: "Matcha",
    },
];

const toppings = [
    {
        label: "Choco",
    },
    {
        label: "Banana",
    },
    {
        label: "Berry",
    },
];
</script>
