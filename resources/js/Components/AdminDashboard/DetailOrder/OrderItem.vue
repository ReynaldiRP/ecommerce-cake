<template>
    <section class="border-b border-neutral py-2 px-2">
        <h1 class="font-medium text-xl text-black">Pesanan Kue</h1>
        <section
            v-for="(item, index) in order.order_items"
            :key="item.id"
            class="flex flex-col py-2 gap-2"
        >
            <section class="flex items-center justify-between">
                <section class="flex gap-2 items-center">
                    <div class="avatar">
                        <div class="w-16 rounded-lg">
                            <img :src="item.cake?.image_url" />
                        </div>
                    </div>
                    <aside class="flex flex-col">
                        <small class="text-neutral-500">{{
                            item.cake?.category?.name
                        }}</small>
                        <p class="font-medium text-neutral">
                            {{ item.cake?.name }}
                            <span v-if="item.cake_size">
                                ({{ item.cake_size.size }}Cm)
                            </span>
                        </p>
                        <div
                            class="flex flex-col md:flex-row md:gap-2 md:items-center text-neutral-500"
                        >
                            <small>{{ item.cake_flavour?.name }}</small>
                            <span
                                v-if="item.cake_flavour && item.cake_topping"
                                class="hidden lg:inline"
                                >|</span
                            >
                            <template v-if="item.cake_topping[index]">
                                <small
                                    v-for="toppings in toppingsName"
                                    :key="toppings.id"
                                >
                                    {{ toppings }}
                                </small>
                            </template>
                        </div>
                    </aside>
                </section>
                <h3 class="text-lg text-neutral">
                    {{ item.quantity }} x {{ formatPrice(item.price) }}
                </h3>
            </section>
        </section>
    </section>
</template>

<script setup>
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import { computed } from "vue";

const props = defineProps({
    order: Object,
});

const { formatPrice } = useAdminDashboardStore();

const toppingsName = computed(() => {
    return props.order.order_items.map((item) => {
        return item.cake_topping.map((topping) => topping.name).join(", ");
    });
});
</script>
