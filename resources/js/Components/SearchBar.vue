<template>
    <div @click="handleClick" ref="container" class="relative w-[400px] max-w-lg">
        <label
            class="w-full input flex items-center gap-3 transition-all duration-300"
            :class="
                isNavbarHovered
                    ? 'input-bordered bg-white/95 backdrop-blur-sm shadow-soft'
                    : 'bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white shadow-soft'
            "
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                class="h-5 w-5 transition-colors duration-300 flex-shrink-0"
                :class="isNavbarHovered ? 'text-gray-500' : 'text-white/80'"
            >
                <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd"
                />
            </svg>
            <input
                type="text"
                class="grow text-sm font-medium text-gray-900 transition-colors duration-300 bg-transparent border-0 focus:outline-none focus:ring-0"
                placeholder="Cari kue impian Anda..."
                v-model="search"
                @keyup="keyupSearch"
                @focus="onFocusHandler"
            />
        </label>

        <!-- Search Results Dropdown -->
        <div
            v-show="onFocus"
            class="absolute top-full mt-2 w-full bg-white/95 backdrop-blur-lg rounded-2xl shadow-card-lg border border-white/20 overflow-hidden z-50"
            ref="resultsContainer"
        >
            <div class="p-2">
                <div
                    v-if="results.length > 0"
                    class="space-y-1 max-h-80 overflow-y-auto custom-scrollbar"
                >
                    <div
                        v-for="(cake, index) in results"
                        :key="cake.id"
                        class="group"
                    >
                        <inertia-link
                            class="flex items-center justify-between p-3 rounded-xl hover:bg-primary/10 transition-all duration-200 group-hover:shadow-soft"
                            :href="route('detail-product', { cakeId: cake.id })"
                        >
                            <div class="flex items-center space-x-3 flex-1">
                                <div
                                    class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center"
                                >
                                    <i
                                        class="fa-solid fa-cake-candles text-primary text-sm"
                                    ></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-semibold text-gray-900 truncate"
                                    >
                                        {{ cake.name }}
                                        <span
                                            v-if="cake.cake_size"
                                            class="text-primary font-medium"
                                        >
                                            ({{ cake.cake_size?.size }}cm)
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Kue
                                        {{ cake.category?.name || "Premium" }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-primary">
                                    {{
                                        formatPrice(
                                            cake.base_price +
                                                (cake.cake_size?.price ?? 0),
                                        )
                                    }}
                                </p>
                            </div>
                        </inertia-link>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="p-6 text-center">
                    <div
                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3"
                    >
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-900 mb-1">
                        Kue tidak ditemukan
                    </p>
                    <p class="text-xs text-gray-500">
                        Coba dengan kata kunci yang berbeda
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { debounce } from "lodash";
import axios from "axios";

const props = defineProps({
    isNavbarHovered: {
        type: Boolean,
    },
});
const page = usePage();

const searchQuery = ref(page.props.value.search?.query || "");
const search = ref(searchQuery.value);

const searchResults = computed(
    () => page.props.value.search?.searchResult || [],
);
const results = ref(searchResults.value);

const onFocus = ref(false);
const container = ref(null);
const resultsContainer = ref(null);

/**
 * Fetches search results from the server based on the provided query.
 *
 * @param {string} query - The search query to be sent to the server.
 * @return {void}
 */
const fetchSearchResults = async (query) => {
    const response = await axios.get(route("search"), {
        params: { search: query },
    });

    results.value = response.data.searchResults || [];
};

/**
 * Debounces the fetchSearchResults function to prevent multiple requests being sent in quick succession.
 *
 * @param {string} query - The search query to be sent to the server.
 * @return {void}
 */
const debouncedFetchSearchResults = debounce((query) => {
    fetchSearchResults(query);
}, 500);

/**
 * Handles keyup event on the search input field and updates the search results accordingly.
 *
 * @return {void}
 */
const keyupSearch = () => {
    if (search.value.length > 0) {
        debouncedFetchSearchResults(search.value);
    } else {
        results.value = searchResults.value;
    }
};

/**
 * Watches the search input field and calls the keyupSearch function whenever its value changes.
 */
watch(search, keyupSearch);

/**
 * Sets the focus state to true.
 *
 * @return {void}
 */
const onFocusHandler = () => {
    onFocus.value = true;
};

/**
 * Handles clicks outside the container to hide the results.
 *
 * @param {Event} event - The click event.
 * @return {void}
 */
const handleClick = (event) => {
    if (container.value && !container.value.contains(event.target)) {
        onFocus.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handleClick);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClick);
});

/**
 * Formats the price of an item by multiplying the price with the quantity.
 *
 * @param {number} price - The price of the item.
 * @returns {string} - The formatted price.
 */
const formatPrice = (price = 0) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};
</script>

<style scoped>
/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #d946ef, #ec4899);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #c026d3, #db2777);
}
</style>
