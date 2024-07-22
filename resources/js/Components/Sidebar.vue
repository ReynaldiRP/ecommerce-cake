<template>
    <div class="drawer drawer-end w-fit z-50">
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <label for="my-drawer-4" class="btn btn-ghost btn-circle w-fit">
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
                <li
                    v-for="(menus, index) in menu"
                    class="text-lg font-medium cursor-pointer hover:text-primary-color"
                >
                    <inertia-link :href="menus.link">{{ menus.name }}</inertia-link>
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
defineProps({
    menu: {
        type: Array,
    },
    user: {
        type: Object,
    },
});
</script>
