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
            </span>
        </label>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
    },
    textColor: {
        type: String,
    },
    textSize: {
        type: String,
    },
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
