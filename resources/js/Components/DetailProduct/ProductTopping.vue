<template>
    <section class="flex flex-col gap-4 text-base-100">
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1">
                <h2 class="text-2xl font-bold">Topping</h2>
                <small class="text-base-200 font-medium"
                    >Toppings opsional
                    <span class="text-red-600 font-medium"
                        >. Pilih maximal 4
                    </span></small
                >
            </div>
            <BaseAlert
                v-if="errorResponses.toppings"
                class="w-fit"
                type="alert-error"
                >{{ errorResponses.toppings[0] }}</BaseAlert
            >
        </div>
        <section class="grid grid-cols-2 lg:grid-cols-4 items-center gap-4">
            <div
                class="flex flex-col"
                v-for="(toppings, index) in toppings"
                :key="toppings.id"
            >
                <BaseCheckbox
                    :id="toppings.id"
                    v-model="model"
                    text-color="text-base-100"
                    :label="toppings.name"
                    @change="updateToppingPrice"
                />
                <label for="" class="ps-8 font-extralight"
                    >({{ formatPrice(toppings.price) }})</label
                >
            </div>
        </section>
    </section>
</template>

<script setup>
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BaseAlert from "@/Components/BaseAlert.vue";

const model = defineModel({
    type: Array,
    default: () => [],
});

const emit = defineEmits(["update-topping-price"]);

const props = defineProps({
    toppings: {
        type: Array,
    },
    errorResponses: {
        type: Object,
    },
    formatPrice: {
        type: Function,
    },
});

/**
 * Calculates the total price of the selected toppings and emits the updated price.
 *
 * @return {number} The total price of the selected toppings
 */
const updateToppingPrice = () => {
    const selectedToppingsPrice = props.toppings
        .filter((topping) => model.value.includes(topping.id))
        .reduce((totalPrice, topping) => totalPrice + topping.price, 0);

    emit("update-topping-price", selectedToppingsPrice);
};
</script>
