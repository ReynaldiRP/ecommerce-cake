<template>
    <div class="form-control">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="checkbox"
                v-model="model"
                :value="id"
                class="checkbox btn-outline [--chkbg:theme(colors.pink.400)] [--chkfg:white] checked:border-pink-400"
            />
            <span class="text-base text-color font-medium">
                {{ label }}
                <span v-show="isTotalDataAvailable"
                    >({{ totalData != null ? totalData : 0 }})</span
                >
            </span>
        </label>
    </div>
</template>

<script setup>
import { computed } from "vue";

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
});

const isTotalDataAvailable = computed(() => {
    return props.totalData != null;
});
</script>

<style scoped>
.text-color {
    color: v-bind(textColor);
}
</style>
