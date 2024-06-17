<template>
    <div class="h-screen flex flex-col">
        <header>
            <Navbar />
        </header>
        <slot></slot>
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
</script>
