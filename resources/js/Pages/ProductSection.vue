<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-12 lg:grid-cols-6 place-items-center gap-8 px-8 py-40"
        >
            <section
                class="col-span-4 lg:col-span-1 h-fit w-full flex flex-col mb-auto gap-2 relative bottom-9"
            >
                <h1 class="text-lg font-medium me-auto">Filter</h1>
                <FilterLayout>
                    <FilterItem filtering-name="Personalization">
                        <BaseRadio :data="data" />
                    </FilterItem>
                    <FilterItem filtering-name="Category">
                        <BaseCheckbox label="Tart" />
                        <BaseCheckbox label="Wedding Cake" />
                        <BaseCheckbox label="Pastry" />
                        <BaseCheckbox label="Pudding" />
                    </FilterItem>
                </FilterLayout>
            </section>
            <section
                class="col-span-8 lg:col-span-5 flex flex-col items-center justify-center gap-8"
            >
                <section class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                    <CardLayout :width="56" v-for="items in 6" :key="items">
                        <CardItem
                            :url="route('/detail-product')"
                            image-url="assets/image/pastry.png"
                            cake-name="Wedding Cake"
                            :cake-price="15000"
                            cake-flavour="Vanilla"
                            cake-toppings="Berry, Choco"
                        />
                    </CardLayout>
                </section>
                <Pagination :numberPagination="3" />
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
</script>
