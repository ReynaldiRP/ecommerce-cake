<template>
    <div class="min-h-screen flex justify-center items-center">
        <h1 class="bg-red-600 p-4 rounded-xl">Hello, {{ name }}</h1>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    name: String,
});
</script>
