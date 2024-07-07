<template>
    <Splide :options="options" @splide:moved="onMoved">
        <slot></slot>
    </Splide>
</template>

<script setup>
import { Splide } from "@splidejs/vue-splide";

const props = defineProps({
    options: {
        type: Object,
    },
    onMoved: {
        type: Function,
    },
});
</script>
