<template>
    <div
        class="navbar px-5 py-4 fixed top-0 transition-all z-50 duration-300 hover:bg-base-200"
        :class="headerClass"
        ref="navbar"
    >
        <div class="navbar-start gap-3">
            <div class="avatar">
                <div class="w-24 lg:w-16 rounded-full">
                    <img
                        src="/assets/image/logo-dreamdessert.webp"
                        alt="ini gambar"
                    />
                </div>
            </div>
            <inertia-link
                :href="route('home')"
                class="text-xl font-bold text-primary-color cursor-pointer"
                >Dream Dessert
            </inertia-link>
        </div>
        <ul class="navbar-center flex gap-8">
            <SearchBar />
        </ul>
        <div class="navbar-end flex gap-5">
            <section class="flex justify-center items-center gap-2">
                <ShoppingChart link="#" :products="items" />
                <NotificationUser
                    :notification="notification"
                    :link="route('/order')"
                />
            </section>

            <!-- <div
                class="dropdown dropdown-end"
                :class="user ? 'block' : 'hidden'"
            >
                <div
                    tabindex="0"
                    role="button"
                    class="btn btn-ghost btn-circle avatar"
                >
                    <div
                        class="w-10 rounded-full ring ring-primary-color ring-offset-base-100 ring-offset-2"
                    >
                        <img
                            alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"
                        />
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
                >
                    <li>
                        <a class="justify-between"> Profile </a>
                    </li>
                    <li><a>Settings</a></li>
                    <li>
                        <button @click="logout">Logout</button>
                    </li>
                </ul>
            </div> -->
            <Sidebar
                :menu="menu"
                :menuAuthenticated="menuAuthenticated"
                :user="user"
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
import { ref, reactive, watch, computed, onMounted, onUnmounted } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Loading from "vue-loading-overlay";
import Sidebar from "@/Components/Sidebar.vue";
import ShoppingChart from "@/Components/ShoppingChart.vue";
import NotificationUser from "@/Components/NotificationUser.vue";
import SearchBar from "@/Components/SearchBar.vue";
import "vue-loading-overlay/dist/css/index.css";

const page = usePage();

const user = computed(() => page.props.value.auth.user);

const state = reactive({
    backgroundColor: "bg-transparent",
});

const isLoading = ref(false);

const logout = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        Inertia.post(route("logout"));
    }, 5000);
};

const menu = [
    {
        name: "Catalouge",
        link: route("products"),
    },
    {
        name: "Order",
        link: route("/order"),
    },
];

const menuAuthenticated = [
    {
        name: "Profile",
        link: "#",
    },
    {
        name: "Order History",
        link: "#",
    },
    {
        name: "Logout",
        link: logout,
    },
];

const handleScroll = () => {
    const scrollPositition = window.scrollY;
    if (scrollPositition > 50) {
        state.backgroundColor = "bg-base-200";
    } else {
        state.backgroundColor = "bg-transparent";
    }
};

const headerClass = computed(() => state.backgroundColor);

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const notification = [
    {
        cakeImageUrl: "/assets/image/pastry.png",
        message: `Your Order Has Been Process.`,
        timestamp: `1 minutes ago`,
    },
    {
        cakeImageUrl: "/assets/image/pastry.png",
        message: `Your Order Has Been Packing.`,
        timestamp: `1 minutes ago`,
    },
];

const items = [
    {
        name: `Wedding Cake`,
        flavour: `Stroberry`,
        toppings: `Choco, Bluberry`,
        quantity: 2,
        price: 44000,
    },
    {
        name: `Birthday Cake`,
        flavour: `Red Velvet`,
        toppings: `Cherry`,
        quantity: 1,
        price: 55000,
    },
    {
        name: `Pudding`,
        flavour: ``,
        toppings: ``,
        quantity: 1,
        price: 14000,
    },
];
</script>
