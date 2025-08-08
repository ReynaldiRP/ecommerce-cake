<template>
    <div class="h-screen w-full">
        <header>
            <Navbar />
        </header>

        <slot></slot>

        <Footer>
            <Footer />
        </Footer>
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
</script>
