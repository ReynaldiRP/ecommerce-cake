<template>
    <div role="alert" :class="`alert ${props.type}`">
        <component :is="icon"></component>
        <slot></slot>
    </div>
</template>

<script setup>
import { defineProps, computed } from "vue";
import IconAlertError from "@/Components/Icons/IconAlertError.vue";
import IconAlertSuccess from "@/Components/Icons/IconAlertSuccess.vue";
import IconAlertInfo from "@/Components/Icons/IconAlertInfo.vue";

const props = defineProps({
    type: {
        type: String,
    },
});

const icon = computed(() => {
    return {
        "alert-success": IconAlertSuccess,
        "alert-error": IconAlertError,
        "alert-info": IconAlertInfo,
    }[props.type];
});
</script>
