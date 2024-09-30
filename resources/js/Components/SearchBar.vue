<template>
    <div @click="handleClick" ref="container">
        <label class="w-[450px] input input-bordered flex items-center gap-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70"
            >
                <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd"
                />
            </svg>
            <input
                type="text"
                class="grow"
                placeholder="Search"
                v-model="search"
                @keyup="keyupSearch"
                @focus="onFocusHandler"
            />
        </label>
        <div
            v-show="onFocus"
            class="absolute top-[5.20rem] w-[450px] h-fit rounded-lg border border-[#383F47] bg-base-100"
            :class="
                onFocus ? 'outline outline-[#383F47] outline-offset-2 ' : ''
            "
            ref="resultsContainer"
        >
            <ul
                tabindex="0"
                class="dropdown-content menu rounded-box z-[1] w-full p-2 shadow"
            >
                <li v-for="(cake, index) in results" :key="cake.id">
                    <inertia-link
                        class="flex justify-between"
                        :href="route('detail-product', { cakeId: cake.id })"
                    >
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span class="ml-1">{{ cake.name }}</span>
                            <span class="font-bold" v-show="cake.cake_size"
                                >({{ cake.cake_size?.size }}Cm)</span
                            >
                        </div>
                        <p>
                            Rp{{
                                cake.base_price + (cake.cake_size?.price ?? 0)
                            }}
                        </p>
                    </inertia-link>
                </li>
                <li v-if="results.length <= 0">
                    <a>No results found</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { debounce } from "lodash";
import axios from "axios";

const page = usePage();

const searchQuery = ref(page.props.value.search?.query || "");
const search = ref(searchQuery.value);

const searchResults = computed(
    () => page.props.value.search?.searchResult || []
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

    console.log(response.data);
    console.log(query);

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
</script>
