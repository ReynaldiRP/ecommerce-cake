<template>
    <App>
        <section class="min-h-screen w-full py-28 px-10">
            <!-- breadcrumbs page -->
            <aside class="breadcrumbs text-sm me-auto relative">
                <ul>
                    <li>
                        <inertia-link :href="route('home')">Home</inertia-link>
                    </li>
                    <li>
                        <inertia-link :href="route('order.history')"
                            >Transaction History
                        </inertia-link>
                    </li>
                </ul>
            </aside>

            <!-- header content -->
            <section class="flex items-center gap-2 mt-4">
                <h1 class="text-2xl font-bold">Transaction Lists</h1>
                <div
                    class="px-3 rounded-lg bg-primary-color text-black font-medium text-lg"
                >
                    transaksi total
                </div>
            </section>

            <!-- transaction history filter -->
            <section class="mt-4 flex items-center justify-between">
                <section class="flex flex-col gap-2">
                    <div role="tablist" class="tabs tabs-boxed font-bold">
                        <a
                            v-for="(filter, index) in transactionFilter"
                            :key="index"
                            role="tab"
                            class="tab"
                            :class="{
                                'tab-active': transactionTabsClicked[index],
                            }"
                            @click="handleTransactionTabClick(index)"
                            >{{ filter }}</a
                        >
                    </div>

                    <div
                        v-if="transactionTabsClicked[1]"
                        role="tablist"
                        class="tabs tabs-boxed font-medium"
                    >
                        <a
                            v-for="(status, index) in orderStatus"
                            role="tab"
                            class="tab"
                            :class="{
                                'tab-active': orderStatusTabsClicked[index],
                            }"
                            @click="handleOrderStatusTabClick(index)"
                            >{{ status }}</a
                        >
                    </div>
                </section>

                <select class="select select-bordered w-full max-w-xs">
                    <option disabled selected>Select Transaction Monts</option>
                    <option v-for="(month, index) in months">
                        {{ month }}
                    </option>
                </select>
            </section>

            <!-- transaction history content -->
            <section
                class="flex flex-col gap-4 mt-4 p-4 border-2 border-neutral rounded-lg shadow-lg"
            >
                <section
                    v-for="item in 3"
                    class="rounded-lg flex flex-col gap-4 border-2 border-neutral p-4"
                >
                    <!-- Transaction Detail -->
                    <section class="flex items-center gap-2 text-xl">
                        <p>Transaction Date</p>
                        <div class="badge badge-success font-medium">
                            Berhasil
                        </div>
                        <p class="font-extralight">Transaction Id</p>
                    </section>

                    <!-- Transaction Image -->
                    <section class="flex items-center justify-between">
                        <!-- Cake details -->
                        <div class="flex gap-4">
                            <div class="avatar">
                                <div class="w-28 rounded">
                                    <img src="/assets/image/default-img.jpg" />
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-lg font-bold">Cake Name (Cake size)</p>
                                <p class="font-medium">Cake Flavour | Cake Toppings</p>
                                <p class="font-light">Cake Quantity x Total Cake Price</p>
                            </div>
                        </div>

                        <div class="flex flex-col text-xl pr-40">
                            <p>Total Belanja</p>
                            <strong>Rp.150000</strong>
                        </div>
                    </section>

                    <!-- Transaction CTA -->
                    <section class="ms-auto flex gap-4 items-center">
                        <inertia-link
                            href="#"
                            class="text-primary-color font-bold"
                            >See Detail Transaction</inertia-link
                        >
                        <button class="btn btn-success font-semibold">
                            Buy Again
                        </button>
                    </section>
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import { ref, onMounted, onUnmounted } from "vue";

const transactionFilter = ["All", "Ongoing", "Succesfull"];
const orderStatus = ["Wait for confirmation", "Order processed", "Delivered"];
const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

const transactionTabsClicked = ref(
    new Array(transactionFilter.length).fill(false)
);

const orderStatusTabsClicked = ref(new Array(orderStatus.length).fill(false));

/**
 * Handles the click event for transaction tabs.
 * Updates the `transactionTabsClicked` array to set the clicked tab as active.
 *
 * @param {number} index - The index of the clicked tab.
 */
const handleTransactionTabClick = (index) => {
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === index
    );
};

/**
 * Handles the click event on an order status tab.
 * Updates the `orderStatusTabsClicked` array to reflect the clicked tab.
 *
 * @param {number} index - The index of the clicked tab.
 */
const handleOrderStatusTabClick = (index) => {
    orderStatusTabsClicked.value = orderStatusTabsClicked.value.map(
        (_, i) => i === index
    );
};

onMounted(() => {
    // When loading i want the tab to be active default in first index
    transactionTabsClicked.value = transactionTabsClicked.value.map(
        (_, i) => i === 0
    );
});

onUnmounted(() => {
    // When unmounted reset the tab to be active default in first index
    transactionTabsClicked.value = new Array(transactionFilter.length).fill(
        false
    );
});
</script>
