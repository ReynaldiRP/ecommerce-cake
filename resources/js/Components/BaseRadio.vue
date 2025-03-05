<template>
    <div class="form-control">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="radio"
                v-model="model"
                :value="id"
                class="radio btn-outline checked:bg-primary-color"
            />
            <span class="text-size text-color font-medium"
                >{{ props.label }}
                <span v-show="isTotalDataAvailable"
                    >({{ isTotalDataAvailable ? props.totalData : 0 }})</span
                >
            </span>
        </label>
    </div>
</template>

<script setup>
import { computed, watch } from "vue";

const model = defineModel();

const props = defineProps({
    id: {
        type: Number,
    },
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
