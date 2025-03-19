<template>
    <div class="drawer drawer-end w-fit z-50">
        <input
            id="my-drawer-4"
            type="checkbox"
            class="drawer-toggle"
            v-model="isSidebarOpen"
        />
        <div class="drawer-content">
            <label for="my-drawer-4" class="btn btn-ghost btn-circle w-fit">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    :class="
                        isNavbarHovered
                            ? 'stroke-neutral-content'
                            : 'stroke-base-100'
                    "
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h7"
                    />
                </svg>
            </label>
        </div>
        <div class="drawer-side">
            <label
                for="my-drawer-4"
                aria-label="close sidebar"
                class="drawer-overlay"
            ></label>
            <ul
                tabindex="0"
                class="menu z-[1] shadow bg-base-200 rounded-box min-h-full w-80 p-4"
            >
                <li :class="user ? 'block border-b-2 pb-2' : 'hidden'">
                    <div class="avatar flex gap-4">
                        <div
                            class="w-10 rounded-full ring ring-primary-color ring-offset-base-100 ring-offset-2"
                        >
                            <img
                                alt="Tailwind CSS Navbar component"
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"
                            />
                        </div>
                        <p class="text-lg font-medium">
                            {{ user ? user.username : "" }}
                        </p>
                    </div>
                </li>
                <li
                    v-for="(menus, index) in menu"
                    :key="index"
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                >
                    <inertia-link :href="menus.link">{{
                        menus.name
                    }}</inertia-link>
                </li>
                <li
                    v-for="(menus, index) in menuAuthenticated"
                    :key="index"
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                    :class="user ? 'block' : 'hidden'"
                >
                    <inertia-link
                        :href="`#`"
                        @click="handlerClick(menus.link)"
                        >{{ menus.name }}</inertia-link
                    >
                </li>
                <li
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                    :class="user ? 'block' : 'hidden'"
                >
                    <form @submit.prevent="logoutHandler">
                        <button type="submit">Logout</button>
                    </form>
                </li>
                <li
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                    :class="user ? 'hidden' : 'block'"
                >
                    <inertia-link :href="route('login.index')"
                        >Login</inertia-link
                    >
                </li>
                <li
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                    :class="user ? 'hidden' : 'block'"
                >
                    <inertia-link :href="route('register.index')"
                        >Create New Account</inertia-link
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const isSidebarOpen = ref(false);

const props = defineProps({
    menu: {
        type: Array,
        default: null,
    },
    menuAuthenticated: {
        type: [Array, Function],
        default: null,
    },
    logoutHandler: {
        type: Function,
    },
    isNavbarHovered: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const user = page.props.value.authenticated;

const handlerClick = (link) => {
    if (typeof link === "string") {
        route(link);
    } else if (typeof link === "function") {
        link();
    }
};
</script>
