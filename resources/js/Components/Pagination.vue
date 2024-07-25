<template>
    <section class="join">
        <button class="join-item btn">«</button>
        <button
            v-for="item in numberPagination"
            :key="item"
            class="join-item btn btn-square"
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
