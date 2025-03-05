<template>
    <App>
        <section class="pt-10 pb-96 md:pb-28 lg:py-0 bg-primary-color-light">
            <HeroSection />
            <CustomizeProductSection :cakes="props.cakes" />
            <AboutSection />
            <TestimonySection />
        </section>
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
