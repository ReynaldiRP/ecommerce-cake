<template>
    <div class="card-product group cursor-pointer">
        <inertia-link :href="route('detail-product', cakes.id)" class="block">
            <!-- Image Container -->
            <div class="relative overflow-hidden rounded-xl mb-4">
                <img
                    :src="cakes.image_url"
                    :alt="cakes.name"
                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110"
                />

                <!-- Discount Badge -->
                <div
                    v-if="cakes.discount"
                    class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg"
                >
                    {{ cakes.discount.discount_percentage }}% OFF
                </div>

                <!-- Quick View Overlay -->
                <div
                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                >
                    <div class="bg-white/10 backdrop-blur-sm rounded-full p-3">
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-2 py-1">
                <!-- Category Badge -->
                <div class="flex items-center gap-2 mb-4">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full"
                    >
                        <i
                            v-if="cakes.personalization_type === 'customized'"
                            class="fa-solid fa-cake-candles text-primary"
                        ></i>
                        <i v-else class="fa-solid fa-cookie text-secondary"></i>
                        {{
                            cakes.personalization_type === "customized"
                                ? "Custom"
                                : "Ready"
                        }}
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1.5 bg-primary/15 text-primary text-xs font-semibold rounded-full"
                    >
                        {{ cakes.category.name }}
                    </span>
                </div>

                <!-- Title -->
                <h3
                    class="text-lg font-heading font-semibold text-gray-900 mb-4 line-clamp-2 group-hover:text-primary transition-colors leading-snug"
                >
                    {{ cakes.name }}
                </h3>

                <!-- Price Section -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <div v-if="cakes.discount" class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold text-red-600">
                                    {{ formatPrice(cakes.discounted_price) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-sm text-gray-500 line-through"
                                >
                                    {{ formatPrice(cakes.base_price) }}
                                </span>
                                <span
                                    class="text-xs text-red-600 font-semibold bg-red-50 px-2 py-1 rounded-md"
                                >
                                    Save
                                    {{ cakes.discount.discount_percentage }}%
                                </span>
                            </div>
                        </div>
                        <div v-else>
                            <span class="text-xl font-bold text-gray-900">
                                {{ formatPrice(cakes.base_price) }}
                            </span>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button
                        class="p-3 bg-primary/10 text-primary rounded-xl hover:bg-primary hover:text-white transition-colors group/btn shadow-sm hover:shadow-md ml-3"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Rating Stars -->
                <div
                    class="flex items-center gap-1 pt-4 border-t border-gray-100"
                >
                    <div class="flex items-center gap-0.5">
                        <svg
                            class="w-4 h-4 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                        <svg
                            class="w-4 h-4 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                        <svg
                            class="w-4 h-4 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                        <svg
                            class="w-4 h-4 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                        <svg
                            class="w-4 h-4 text-gray-300"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700 ml-2 font-medium"
                        >4.8</span
                    >
                    <span class="text-sm text-gray-500 ml-1">(124)</span>
                </div>
            </div>
        </inertia-link>
    </div>
</template>

<script setup>
const props = defineProps({
    cakes: Object,
    formatPrice: Function,
});

const isCustomizedBadge = () => {
    return props.cakes.personalization_type === "customized"
        ? "bg-primary-color border border-primary-color text-base-100"
        : " badge-neutral";
};
</script>
