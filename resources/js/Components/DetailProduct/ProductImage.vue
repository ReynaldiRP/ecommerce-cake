<template>
    <figure
        class="w-[450px] h-[450px] shadow-xl bg-base-300 bg-opacity-65 rounded-xl"
    >
        <img :src="url" alt="" class="h-full" />
    </figure>
</template>

<script setup>
defineProps({
    url: {
        type: String,
    },
});
</script>
