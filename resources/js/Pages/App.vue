<template>
    <Navbar />
    <Home :user="user" />
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Home from "@/Pages/Home.vue";
</script>
