<template>
    <figure class="shadow-xl bg-base-300 bg-opacity-65">
        <img :src="cakeImage" alt="pastry" class="h-full w-full rounded-xl" />
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
