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
                :href="route('/home')"
                class="text-xl font-bold text-primary-color cursor-pointer"
                >Dream Dessert
            </inertia-link>
        </div>
        <ul class="navbar-center hidden lg:flex gap-8">
            <label
                class="w-[450px] input input-bordered flex items-center gap-2"
            >
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
                <input type="text" class="grow" placeholder="Search" />
            </label>
        </ul>
        <div class="navbar-end flex gap-5">
            <div class="flex justify-center items-center gap-2">
                <div class="dropdown dropdown-end">
                    <div
                        tabindex="0"
                        role="button"
                        class="btn btn-ghost btn-circle"
                    >
                        <div class="indicator">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            <span class="badge badge-sm indicator-item">8</span>
                        </div>
                    </div>
                    <div
                        tabindex="0"
                        class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow"
                    >
                        <div class="card-body">
                            <span class="font-bold text-lg">8 Items</span>
                            <span class="text-info">Subtotal: $999</span>
                            <div class="card-actions">
                                <button
                                    class="btn bg-primary-color text-slate-700 hover:text-white btn-block"
                                >
                                    View cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown dropdown-end">
                    <div
                        tabindex="0"
                        role="button"
                        class="btn btn-ghost btn-circle"
                    >
                        <div class="indicator">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                                fill="currentColor"
                                class="h-5 w-5"
                                stroke="currentColor"
                            >
                                <path
                                    d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"
                                />
                            </svg>
                            <span class="badge badge-sm indicator-item">8</span>
                        </div>
                    </div>
                    <div
                        tabindex="0"
                        class="mt-3 z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow-xl"
                    >
                        <div
                            class="card-body m-0 p-0"
                            v-for="(notif, index) in notification"
                            :key="index"
                        >
                            <p class="font-bold text-lg">
                                {{ notif.name }}
                            </p>
                            <p class="text-info text-justify">
                                {{ notif.message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div
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
            </div>
            <div class="flex-shrink dropdown dropdown-end">
                <div
                    tabindex="0"
                    role="button"
                    class="btn btn-ghost btn-circle"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"
                        />
                    </svg>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
                >
                    <li
                        v-for="(menus, index) in menu"
                        class="text-lg font-medium cursor-pointer transition-all hover:text-primary-color"
                    >
                        <inertia-link :href="`/${menus.toLowerCase()}`">{{
                            menus
                        }}</inertia-link>
                    </li>
                    <li
                        class="text-lg font-medium cursor-pointer transition-all hover:text-primary-color"
                    >
                        <inertia-link :href="route('login.index')"
                            >Login</inertia-link
                        >
                    </li>
                    <li
                        class="text-lg font-medium cursor-pointer transition-all hover:text-primary-color"
                    >
                        <inertia-link :href="route('register.index')"
                            >Create New Account</inertia-link
                        >
                    </li>
                </ul>
            </div>
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
import "vue-loading-overlay/dist/css/index.css";

const page = usePage();

const user = computed(() => page.props.value.auth.user);

const state = reactive({
    backgroundColor: "bg-transparent",
});

const menu = ["Home", "About", "Catalog", "Contact"];

const isLoading = ref(false);

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

const logout = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        Inertia.post(route("logout"));
    }, 5000);
};

const notification = [
    {
        name: "Budi",
        message: `Hello Budi`,
    },
    {
        name: "Angga",
        message: `Hello Angga`,
    },
];
</script>
