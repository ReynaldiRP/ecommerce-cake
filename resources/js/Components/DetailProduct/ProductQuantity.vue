<template>
    <section class="flex items-center gap-4">
        <h2 class="text-2xl font-bold">Quatity</h2>
        <select class="select select-bordered w-fit max-w-xs">
            <option v-for="(qty, index) in quantity" :key="index">
                {{ qty }}
            </option>
        </select>
    </section>
</template>

<script setup>
defineProps({
    quantity: {
        type: Number,
    },
});
</script>
