<template>
    <section class="join">
        <button class="join-item btn">«</button>
        <button
            class="join-item btn"
            v-for="item in numberPagination"
            :key="item"
        >
            {{ item }}
        </button>
        <button class="join-item btn">»</button>
    </section>
</template>

<script setup>
defineProps({
    numberPagination: {
        type: Number,
        default: 2,
    },
});
</script>
