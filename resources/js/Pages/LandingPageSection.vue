<template>
    <App>
        <div class="min-h-screen">
            <!-- Hero Section -->
            <HeroSection />

            <!-- Features Section -->
            <CustomizeProductSection :cakes="props.cakes" />

            <!-- About Section -->
            <AboutSection />

            <!-- Testimonials Section -->
            <TestimonySection />
        </div>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import HeroSection from "@/Pages/HeroSection.vue";
import CustomizeProductSection from "@/Pages/CustomizeProductSection.vue";
import AboutSection from "@/Pages/AboutSection.vue";
import TestimonySection from "@/Pages/TestimonySection.vue";

const props = defineProps({
    cakes: {
        type: Object,
    },
});
</script>
