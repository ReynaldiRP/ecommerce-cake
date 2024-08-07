<template>
    <section class="join">
        <inertia-link :href="previousPageUrl" class="join-item btn"
            >«</inertia-link
        >
        <inertia-link
            v-for="link in filteredLinks"
            :key="link.label"
            :href="link.url"
            class="join-item btn btn-square"
        >
            {{ link.label }}
        </inertia-link>
        <inertia-link :href="nextPageUrl" class="join-item btn">»</inertia-link>
    </section>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    links: {
        type: Array,
        default: [],
    },
    nextPageUrl: {
        type: String,
        default: "",
    },
    previousPageUrl: {
        type: String,
        default: "",
    },
});

const filteredLinks = computed(() => {
    return props.links.filter((link) => !isNaN(link.label));
});
</script>
