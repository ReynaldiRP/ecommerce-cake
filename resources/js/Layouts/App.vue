<template>
    <div class="min-h-screen flex flex-col">
        <header>
            <Navbar />
        </header>
        <slot></slot>

        <Footer />
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
</script>
