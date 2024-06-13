<template>
    <label for="email" class="text-lg font-bold"
        >{{ label
        }}<span
            v-show="required"
            class="relative bottom-2 text-lg font-medium text-red-500"
            >*</span
        ></label
    >
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    label: {
        type: String,
        required: true,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>
