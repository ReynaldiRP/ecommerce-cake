<template>
    <section class="flex flex-col gap-4">
        <section class="flex justify-between">
            <h2 class="text-2xl font-bold">Ukuran Kue</h2>
            <BaseAlert
                v-if="errorResponses.cake_size_id"
                class="w-fit"
                type="alert-error"
                >{{ errorResponses.cake_size_id[0] }}</BaseAlert
            >
        </section>
        <select class="select select-bordered w-full" v-model="model">
            <option value="" disabled>Pilih ukuran kue</option>
            <option
                v-for="(cake_size, index) in props.cakeSize"
                :key="index"
                :value="cake_size.id"
            >
                {{ cake_size.size }} Cm
            </option>
        </select>
    </section>
</template>

<script setup>
import { watch } from "vue";
import BaseAlert from "@/Components/BaseAlert.vue";

const props = defineProps({
    cakeSize: {
        type: Array,
        required: true,
    },
    errorResponses: {
        type: Object,
        default: null,
    },
});

const model = defineModel();
const emit = defineEmits(["update-cake-size-price", "update:modelValue"]);

watch(model, (newVal) => {
    emit("update:modelValue", newVal);
    emit("update-cake-size-price", newVal);
});
</script>
