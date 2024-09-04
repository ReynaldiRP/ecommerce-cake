<template>
    <label for="email" class="font-bold" :class="isPageDetailProduct"
        >{{ label
        }}<span
            v-show="required"
            class="relative bottom-2 font-medium text-red-500"
            :class="isPageDetailProduct"
            >*</span
        ></label
    >
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    required: {
        type: Boolean,
        default: false,
    },
    isDetailProductSection: {
        type: Boolean,
        default: false,
    },
});

const isPageDetailProduct = computed(() => {
    return props.isDetailProductSection ? "text-2xl" : "text-lg";
});
</script>
