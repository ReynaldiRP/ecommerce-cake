<template>
    <div class="form-control">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="radio"
                name="radio-1"
                class="radio btn-outline checked:bg-pink-400 checked:outline-white"
            />
            <span class="text-size text-color font-medium"
                >{{ props.label }}
                <span v-show="isTotalDataAvailable"
                    >({{ props.totalData != null ? props.totalData : 0 }})</span
                >
            </span>
        </label>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    label: {
        type: String,
    },
    totalData: {
        type: Number,
        default: null,
    },
    textColor: {
        type: String,
    },
    textSize: {
        type: String,
    },
});

const isTotalDataAvailable = computed(() => {
    return props.totalData != null;
});
</script>

<style scoped>
.text-size {
    font-size: v-bind(textSize);
}
.text-color {
    color: v-bind(textColor);
}
</style>
