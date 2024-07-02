<template>
    <section class="card card-compact h-full width bg-base-300 shadow-xl">
        <slot></slot>
    </section>
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
