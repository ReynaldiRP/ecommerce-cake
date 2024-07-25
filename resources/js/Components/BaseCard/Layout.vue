<template>
    <div
        
        class="card card-compact h-full width bg-primary-color shadow-xl"
    >
        <slot></slot>
    </div>
</template>

<script setup>
defineProps({
    width: {
        type: Number,
    },
});
</script>

<style scoped>
.width {
    width: v-bind(width);
}
</style>
