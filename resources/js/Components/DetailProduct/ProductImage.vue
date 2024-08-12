<template>
    <figure
        class="w-[450px] h-[450px] shadow-xl bg-base-300 bg-opacity-65 rounded-xl"
    >
        <img :src="cakeImage" alt="pastry" class="h-full" />
    </figure>
</template>

<script setup>
const props = defineProps({
    cakeImage: {
        type: String,
        default: `assets/image/default-img.jpg`,
    },
});
</script>
