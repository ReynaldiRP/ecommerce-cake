<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold text-base-100">Jumlah Kue</h2>
        <select class="select select-bordered w-full" v-model="model">
            <option
                v-for="(qty, index) in props.quantity"
                :key="index"
                :value="qty"
            >
                {{ qty }}
            </option>
        </select>
    </section>
</template>

<script setup>
import { watch } from "vue";

const props = defineProps({
    quantity: {
        type: Array,
        required: true,
    },
});

const model = defineModel({
    type: Number,
    default: 1,
});

const emit = defineEmits(["update-quantity-price"]);

watch(model, (newVal) => {
    emit("update-quantity-price", newVal);
});
</script>
