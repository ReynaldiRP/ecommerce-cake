<template>
    <App>
        <section class="min-h-screen flex flex-col justify-center">
            <div
                class="breadcrumbs text-sm me-auto relative top-32 lg:top-[88px] left-8"
            >
                <ul>
                    <li>
                        <inertia-link :href="route('home')">Home</inertia-link>
                    </li>
                    <li>
                        <inertia-link :href="route('products')"
                            >Catalouge</inertia-link
                        >
                    </li>
                </ul>
            </div>
            <section
                class="w-full grid grid-cols-12 lg:grid-cols-6 place-items-center gap-8 px-8"
            >
                <section
                    class="h-fit w-[250px] col-span-4 lg:col-span-1 flex flex-col items-center mb-auto gap-2 py-36 lg:py-24"
                >
                    <div
                        class="w-full px-4 lg:px-0 flex items-center gap-2 relative right-4 lg:right-0 lg:left-4"
                    >
                        <div
                            tabindex="0"
                            class="lg:hidden collapse collapse-arrow bg-base-300"
                        >
                            <div class="collapse-title text-lg font-medium">Filter</div>
                            <div class="collapse-content">
                                <FilterItem filtering-name="Personalization">
                                    <BaseRadio
                                        v-for="(
                                            cakePersonalizationType, index
                                        ) in cakePersonalizationType"
                                        :key="index"
                                        :label="cakePersonalizationType.name"
                                    />
                                </FilterItem>
                                <FilterItem
                                    class="my-4"
                                    filtering-name="Cake Size"
                                >
                                    <BaseCheckbox
                                        v-for="cakeSize in props.cakeSizes"
                                        :key="cakeSize?.id"
                                        :label="`${cakeSize?.size} Cm`"
                                    />
                                </FilterItem>
                            </div>
                        </div>
                        <h1 class="hidden lg:block text-lg font-medium me-auto">
                            Filter
                        </h1>
                    </div>

                    <FilterLayout>
                        <FilterItem
                            class="hidden lg:flex"
                            filtering-name="Personalization"
                        >
                            <BaseRadio
                                v-for="(
                                    cakePersonalizationType, index
                                ) in cakePersonalizationType"
                                :key="index"
                                :label="cakePersonalizationType.name"
                            />
                        </FilterItem>
                        <FilterItem
                            class="hidden lg:flex"
                            filtering-name="Cake Size"
                        >
                            <BaseCheckbox
                                v-for="cakeSize in props.cakeSizes"
                                :key="cakeSize?.id"
                                :label="`${cakeSize?.size} Cm`"
                            />
                        </FilterItem>
                    </FilterLayout>
                </section>
                <section
                    class="col-span-8 lg:col-span-5 flex flex-col items-center gap-8 py-44 lg:py-32"
                >
                    <section
                        class="w-full grid grid-cols-2 lg:grid-cols-4 gap-8"
                    >
                        <CardLayout v-for="cakes in totalPrice" :key="cakes.id">
                            <CardItem
                                :cake-id="cakes.id"
                                :cake-name="cakes.name"
                                :cake-size="cakes.cake_size?.size"
                                :cake-price="formatPrice(cakes.totalCakePrice)"
                                :image-url="cakes.image_url"
                                :cake-personalization-type="
                                    cakes.personalization_type
                                "
                            />
                        </CardLayout>
                    </section>
                    <Pagination
                        :links="props.cakes.links"
                        :next-page-url="props.cakes.next_page_url"
                        :previous-page-url="props.cakes.prev_page_url"
                    />
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import CardLayout from "@/Components/BaseCard/Layout.vue";
import CardItem from "@/Components/BaseCard/Item.vue";
import FilterLayout from "@/Components/FilterProduct/Layout.vue";
import FilterItem from "@/Components/FilterProduct/Item.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BaseRadio from "@/Components/BaseRadio.vue";
import Pagination from "@/Components/Pagination.vue";
import { computed } from "vue";

const props = defineProps({
    cakes: {
        type: Object,
    },
    cakeSizes: {
        type: Object,
    },
});

const totalPrice = computed(() => {
    return props.cakes.data.map((cake) => {
        const cakeSizedPrice = cake.cake_size ? cake.cake_size.price : 0;
        const totalCakePrice = cake.base_price + cakeSizedPrice;
        return {
            ...cake,
            totalCakePrice,
        };
    });
});

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};

console.log(formatPrice());

const cakePersonalizationType = [
    {
        id: 1,
        name: "Customized",
    },
    {
        id: 2,
        name: "Non-Customized",
    },
];
</script>
