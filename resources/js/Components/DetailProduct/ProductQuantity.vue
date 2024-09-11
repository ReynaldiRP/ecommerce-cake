<template>
    <section class="flex flex-col gap-4">
        <h2 class="text-2xl font-bold">Quatity</h2>
        <select
            class="select select-bordered w-full"
            v-model="model"
            @change="updateQuantityPrice"
        >
            <option v-for="(qty, index) in props.quantity" :key="index">
                {{ qty }}
            </option>
        </select>
    </section>
</template>

<script setup>
const props = defineProps({
    quantity: {
        type: Array,
    },
});

const model = defineModel({
    type: Array[Number],
});

const emit = defineEmits(["update-quantity-price"]);

const updateQuantityPrice = () => {
    emit("update-quantity-price", model.value);
};
</script>
