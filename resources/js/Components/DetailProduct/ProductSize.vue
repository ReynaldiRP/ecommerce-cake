<template>
    <section class="flex flex-col gap-4">
        <section class="flex justify-between">
            <div class="flex flex-col gap-1">
                <h2 class="text-2xl font-bold text-base-100">Ukuran Kue</h2>
                <small class="text-base-200 font-medium"
                    >Ukuran kue harus dipilih
                    <span class="text-red-600 font-medium"
                        >. Pilih 1</span
                    ></small
                >
            </div>
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
                {{ cake_size.size }} Cm ({{
                    props.formatPrice(cake_size.price)
                }})
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
    formatPrice: {
        type: Function,
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
