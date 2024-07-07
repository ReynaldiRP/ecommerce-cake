<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2 gap-2 place-items-center py-10 lg:py-0"
        >
            <figure
                class="h-[450px] w-[450px] lg:h-full lg:w-full bg-[url('assets/image/login-background.webp')] bg-cover bg-no-repeat bg-center"
            ></figure>
            <section
                class="h-full w-full flex flex-col justify-center px-8 mt-6 gap-6"
            >
                <section class="flex flex-col gap-2">
                    <h1 class="text-3xl font-bold">Cake Name</h1>
                    <h2 class="text-2xl font-bold">Rp 10000</h2>
                    <p class="text-lg">
                        Lorem, ipsum dolor sit amet consectetur adipisicing
                        elit. Sunt corporis numquam rem sequi consequuntur
                        inventore minus excepturi. Animi tempore dignissimos,
                        delectus iusto nisi eligendi vero inventore ex, sapiente
                        expedita impedit. Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Laudantium, repellat optio mollitia
                        iure, dicta reiciendis, laborum quibusdam repellendus
                        expedita cumque error obcaecati dolorem architecto
                        consequuntur ratione! Ipsum deserunt cupiditate beatae.
                    </p>
                </section>
                <section class="flex flex-col gap-4">
                    <h2 class="text-2xl font-bold">Flavour</h2>
                    <section class="flex items-center gap-4">
                        <BaseRadio text-size="1rem" :data="data" />
                    </section>
                </section>
                <section class="flex flex-col gap-4">
                    <h2 class="text-2xl font-bold">Topping</h2>
                    <section class="flex items-center gap-4">
                        <BaseCheckbox
                            v-for="(toppings, index) in toppings"
                            :key="index"
                            text-color="#A6ADBB"
                            :label="toppings.label"
                        />
                    </section>
                </section>
                <section class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold">Quatity</h2>
                    <select class="select select-bordered w-fit max-w-xs">
                        <option v-for="(quantity, index) in 4" :key="index">
                            {{ quantity }}
                        </option>
                    </select>
                </section>
                <button
                    class="btn btn-block text-base-300 hover:text-white bg-primary-color"
                >
                    Add to Chart
                </button>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseRadio from "@/Components/BaseRadio.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";

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
