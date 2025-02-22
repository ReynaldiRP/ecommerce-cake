<template>
    <section class="flex flex-col gap-2 py-4 px-2">
        <h1 class="font-medium text-xl text-black">Ringkasan Pesanan</h1>
        <section class="grid grid-cols-12">
            <!--            <section-->
            <!--                class="flex flex-col gap-1 text-md text-neutral col-span-6"-->
            <!--            >-->
            <!--                <p>Harga Kue</p>-->
            <!--                <p>Diskon Kue</p>-->
            <!--            </section>-->
            <!--            <section-->
            <!--                class="col-span-6 flex flex-col gap-1 text-md text-neutral"-->
            <!--            >-->
            <!--                <div class="flex items-center justify-between">-->
            <!--                    <p>{{ order.order_items.length }} Kue</p>-->
            <!--                    <p>{{ formatPrice(orderSubtotal) }}</p>-->
            <!--                </div>-->
            <!--                <p class="ms-auto">- {{ formatPrice(orderDiscount) }}</p>-->
            <!--            </section>-->
        </section>
        <section class="flex justify-between items-center mt-2">
            <p class="text-lg font-medium text-neutral">Total Harga</p>
            <p class="text-lg font-medium text-neutral">
                {{ order.order_items.length }} Kue
            </p>
            <p class="text-lg font-medium text-neutral">
                {{ formatPrice(orderSubtotal) }}
            </p>
        </section>
    </section>
</template>

<script setup>
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

const props = defineProps({
    order: Object,
    orderSubtotal: Number,
});

const { formatPrice } = useAdminDashboardStore();
</script>
