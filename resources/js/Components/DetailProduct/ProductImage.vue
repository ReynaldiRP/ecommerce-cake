<template>
    <figure
        class="relative overflow-hidden bg-white rounded-3xl shadow-card group"
    >
        <div
            class="aspect-square w-full bg-gradient-to-br from-gray-50 to-gray-100"
        >
            <img
                :src="cakeImage"
                alt="Product Image"
                class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                loading="lazy"
            />
        </div>

        <!-- Overlay Gradient -->
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
        ></div>

        <!-- Zoom Icon -->
        <div
            class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0"
        >
            <svg
                class="w-5 h-5 text-gray-700"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                ></path>
            </svg>
        </div>
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
