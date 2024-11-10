<template>
    <section class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1">
                <h2 class="text-2xl font-bold">Rasa Kue</h2>
                <small class="text-primary-color font-medium"
                    >Rasa kue harus dipilih
                    <span class="text-neutral-content">. Pilih 1</span></small
                >
            </div>
            <BaseAlert
                v-if="errorResponses.cake_flavour_id"
                class="w-fit"
                type="alert-error"
                >{{ errorResponses.cake_flavour_id[0] }}</BaseAlert
            >
        </div>
        <section class="grid grid-cols-2 lg:grid-cols-4 items-center gap-4">
            <div
                v-for="(flavour, index) in props.flavours"
                :key="index"
                class="flex flex-col"
            >
                <BaseRadio
                    text-size="1rem"
                    :id="flavour?.id"
                    v-model="model"
                    text-color="#A6ADBB"
                    :label="flavour?.name"
                    @change="updateFlavourPrice"
                />
                <label for="" class="ps-8 font-extralight"
                    >({{ formatPrice(flavour.price) }})</label
                >
            </div>
        </section>
    </section>
</template>

<script setup>
import BaseRadio from "@/Components/BaseRadio.vue";
import BaseAlert from "@/Components/BaseAlert.vue";

const props = defineProps({
    flavours: {
        type: Array,
    },
    errorResponses: {
        type: Object,
        default: null,
    },
    formatPrice: {
        type: Function,
    },
});

const model = defineModel();
const emit = defineEmits(["update-flavour-price"]);

const updateFlavourPrice = () => {
    const selectedFlavour = props.flavours.find(
        (flavour) => flavour.id === model.value,
    );

    if (selectedFlavour) {
        emit("update-flavour-price", selectedFlavour.price);
    } else {
        console.warn("Flavour not found");
    }
};
</script>
