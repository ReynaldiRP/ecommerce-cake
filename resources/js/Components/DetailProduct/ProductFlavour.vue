<template>
    <section class="flex flex-col gap-4">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold">Flavour</h2>
            <small class="text-primary-color font-medium"
                >Flavor is required
                <span class="text-neutral-content">. Choose 1</span></small
            >
        </div>
        <section class="grid grid-cols-2 lg:grid-cols-4 items-center gap-4">
            <BaseRadio
                text-size="1rem"
                v-for="(flavour, index) in props.flavours"
                :id="flavour?.id"
                :key="index"
                v-model="model"
                text-color="#A6ADBB"
                :label="flavour?.name"
                @change="updateFlavourPrice"
            />
        </section>
    </section>
</template>

<script setup>
import BaseRadio from "@/Components/BaseRadio.vue";

const props = defineProps({
    flavours: {
        type: Array,
    },
});

const model = defineModel();
const emit = defineEmits(["update-flavour-price"]);

const updateFlavourPrice = () => {
    const selectedFlavour = props.flavours.find(
        (flavour) => flavour.id === model.value
    );

    if (selectedFlavour) {
        emit("update-flavour-price", selectedFlavour.price);
    } else {
        console.warn("Flavour not found");
    }
};
</script>
