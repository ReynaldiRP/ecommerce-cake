<template>
    <section class="flex items-center justify-center space-x-2">
        <!-- Previous Button -->
        <button
            @click="handlePagination(previousPageUrl)"
            :disabled="!previousPageUrl || loading"
            class="px-3 sm:px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-1 sm:space-x-2"
            :class="{
                'bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-primary shadow-soft':
                    previousPageUrl && !loading,
                'bg-gray-100 text-gray-400 cursor-not-allowed':
                    !previousPageUrl || loading,
            }"
        >
            <i class="fas fa-chevron-left text-xs"></i>
            <span class="hidden sm:inline">Sebelumnya</span>
        </button>

        <!-- Page Numbers -->
        <div class="flex items-center space-x-1">
            <button
                v-for="link in filteredLinks"
                :key="link.label"
                @click="handlePagination(link.url)"
                :disabled="link.active || !link.url || loading"
                class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl font-semibold text-sm transition-all duration-200 relative overflow-hidden"
                :class="{
                    'bg-gradient-to-r from-primary to-accent text-white shadow-soft':
                        link.active,
                    'bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-primary shadow-soft hover:shadow-card':
                        !link.active && link.url && !loading,
                    'bg-gray-100 text-gray-400 cursor-not-allowed':
                        !link.url || loading,
                }"
            >
                {{ link.label }}
            </button>
        </div>

        <!-- Next Button -->
        <button
            @click="handlePagination(nextPageUrl)"
            :disabled="!nextPageUrl || loading"
            class="px-3 sm:px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-1 sm:space-x-2"
            :class="{
                'bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-primary shadow-soft':
                    nextPageUrl && !loading,
                'bg-gray-100 text-gray-400 cursor-not-allowed':
                    !nextPageUrl || loading,
            }"
        >
            <span class="hidden sm:inline">Selanjutnya</span>
            <i class="fas fa-chevron-right text-xs"></i>
        </button>
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
    loading: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["paginate"]);

const filteredLinks = computed(() => {
    return props.links.filter((link) => !isNaN(link.label));
});

const handlePagination = (url) => {
    if (url && !props.loading) {
        emit("paginate", url);
    }
};
</script>
