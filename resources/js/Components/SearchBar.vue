<template>
    <div>
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
                @focusout="onOutFocusHandler"
            />
        </label>
        <div
            v-show="onSearchClicked == true || onFocus == true"
            class="absolute top-[5.20rem] w-[450px] h-fit rounded-lg border border-[#383F47] bg-base-100"
            :class="
                onSearchClicked == true || onFocus == true
                    ? 'outline outline-[#383F47] outline-offset-2 '
                    : ''
            "
        >
            <ul
                tabindex="0"
                class="dropdown-content menu rounded-box z-[1] w-full p-2 shadow"
            >
                <li v-for="(cake, index) in results" :key="cake.id">
                    <a>{{ cake.name }}</a>
                </li>
                <li v-if="results.length <= 0">
                    <a>No results found</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { debounce } from "lodash";

const page = usePage();

const searchQuery = ref(page.props.value.search?.query || "");
const search = ref(searchQuery.value);

const searchResults = computed(
    () => page.props.value.search?.searchResult || []
);
const results = ref(searchResults.value);

const onSearchClicked = ref(false);
const onFocus = ref(false);

/**
 * Fetches search results from the server based on the provided query.
 *
 * @param {string} query - The search query to be sent to the server.
 * @return {void}
 */
const fetchSearchResults = async (query) => {
    const response = await fetch(`/search?search=${encodeURIComponent(query)}`);
    const data = await response.json();

    results.value = data.searchResults || [];
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
 * Handles keyup event on the search input field.
 * Updates the onSearchClicked state based on the input field's value and focus state.
 *
 * @return {void}
 */
const keyupSearch = () => {
    if (search.value.length > 0) {
        onSearchClicked.value = true;
        debouncedFetchSearchResults(search.value);
    } else {
        onSearchClicked.value = false;
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
 * Handles the event when the search input field loses focus.
 * Resets the onSearchClicked and onFocus states to false.
 *
 * @return {void}
 */
const onOutFocusHandler = () => {
    onFocus.value = false;
    onSearchClicked.value = false;
};
</script>
