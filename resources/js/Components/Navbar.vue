<template>
    <div
        class="navbar px-5 py-4 fixed top-0 transition-all z-50 duration-300"
        :class="headerClass"
        ref="navbar"
    >
        <div class="navbar-start gap-3">
            <div class="avatar">
                <div class="w-16 rounded-full">
                    <img
                        src="/assets/image/logo-dreamdessert.webp"
                        alt="ini gambar"
                    />
                </div>
            </div>
            <inertia-link
                :href="route('home')"
                :class="textColor"
                class="text-md font-bold cursor-pointer"
                >Dream Dessert
            </inertia-link>
        </div>
        <ul class="navbar-center hidden lg:flex gap-8">
            <SearchBar :is-navbar-hovered="isNavbarHovered" />
        </ul>
        <div class="navbar-end flex gap-2">
            <section class="flex justify-center items-center">
                <ShoppingChart :is-navbar-hovered="isNavbarHovered" />
                <NotificationUser
                    v-if="user"
                    :link="route('order.status')"
                    :is-navbar-hovered="isNavbarHovered"
                />
            </section>
            <Sidebar
                :menu="menu"
                :menuAuthenticated="menuAuthenticated"
                :user="user"
                :logout-handler="logout"
                :is-navbar-hovered="isNavbarHovered"
            />
        </div>
    </div>

    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        :is-full-page="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import Sidebar from "@/Components/Sidebar.vue";
import ShoppingChart from "@/Components/ShoppingChart.vue";
import NotificationUser from "@/Components/NotificationUser.vue";
import SearchBar from "@/Components/SearchBar.vue";
import "vue-loading-overlay/dist/css/index.css";

const page = usePage();

const user = computed(() => page.props.value.authenticated);

const state = reactive({
    backgroundColor: "bg-transparent",
    textColor: "text-base-100",
});

const isLoading = ref(false);
const isNavbarHovered = ref(false);

/**
 * Logs out the current user by sending a POST request to the logout route.
 *
 * @return {void}
 */
const logout = () => {
    isLoading.value = true;
    setTimeout(function () {
        Inertia.post(route("logout"));
        isLoading.value = false;
    }, 3000);
};

const menu = [
    {
        name: "Katalog Kue",
        link: route("products"),
    },
];

const menuAuthenticated = [
    {
        name: "Riwayat Transaksi",
        link: route("transaction-history"),
    },
];

/**
 * Updates the background color of the navbar based on the current scroll position.
 *
 * @return {void}
 */
const handleScroll = () => {
    const scrollPositition = window.scrollY;

    if (scrollPositition > 10) {
        isNavbarHovered.value = true;
        state.backgroundColor = "bg-base-200";
        state.textColor = "text-primary-color-light";
    } else {
        isNavbarHovered.value = false;
        state.backgroundColor = "bg-transparent";
        state.textColor = "text-base-100";
    }
};

const headerClass = computed(() => state.backgroundColor);
const textColor = computed(() => state.textColor);

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>
