<template>
    <div class="drawer drawer-end w-fit z-50">
        <input
            id="my-drawer-4"
            type="checkbox"
            class="drawer-toggle"
            v-model="isSidebarOpen"
        />
        <div class="drawer-content">
            <label
                for="my-drawer-4"
                class="btn btn-ghost btn-circle w-fit hover:bg-white/20 transition-all duration-300"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 transition-colors duration-300 stroke-gray-800"
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
                class="drawer-overlay bg-black/60"
            ></label>

            <!-- Modern Sidebar Panel -->
            <div
                class="min-h-full w-80 sm:w-96 bg-white/95 border-l border-gray-200 shadow-2xl"
            >
                <!-- Header Section -->
                <div class="p-6 border-b border-gray-100/50">
                    <div class="flex items-center justify-between mb-4">
                        <h2
                            class="text-2xl font-heading font-bold text-gray-900"
                        >
                            Menu
                        </h2>
                        <label
                            for="my-drawer-4"
                            class="btn btn-sm btn-circle btn-ghost hover:bg-gray-100 transition-colors duration-200"
                        >
                            <svg
                                class="w-5 h-5 text-gray-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </label>
                    </div>

                    <!-- User Profile Section -->
                    <div
                        v-if="user"
                        class="bg-gradient-to-r from-primary/10 to-accent/10 rounded-2xl p-4 border border-primary/20"
                    >
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div
                                    class="w-12 h-12 rounded-2xl ring-2 ring-primary/30 ring-offset-2 ring-offset-white overflow-hidden"
                                >
                                    <img
                                        alt="User Avatar"
                                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ user.username }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ user.email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="flex-1 p-6">
                    <nav class="space-y-2">
                        <!-- Main Menu Items -->
                        <div class="space-y-1">
                            <h3
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3"
                            >
                                Navigasi
                            </h3>
                            <inertia-link
                                v-for="(menuItem, index) in menu"
                                :key="index"
                                :href="menuItem.link"
                                class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-2xl hover:bg-gradient-to-r hover:from-primary/10 hover:to-accent/10 hover:text-primary transition-all duration-200 group"
                            >
                                <div
                                    class="w-2 h-2 bg-gray-400 rounded-full group-hover:bg-primary transition-colors duration-200"
                                ></div>
                                <span class="font-medium">{{
                                    menuItem.name
                                }}</span>
                            </inertia-link>
                        </div>

                        <!-- Authenticated Menu Items -->
                        <div
                            v-if="user"
                            class="space-y-1 pt-4 border-t border-gray-100"
                        >
                            <h3
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3"
                            >
                                Akun Saya
                            </h3>
                            <button
                                v-for="(menuItem, index) in menuAuthenticated"
                                :key="index"
                                @click="handlerClick(menuItem.link)"
                                class="w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-2xl hover:bg-gradient-to-r hover:from-primary/10 hover:to-accent/10 hover:text-primary transition-all duration-200 group text-left"
                            >
                                <div
                                    class="w-2 h-2 bg-gray-400 rounded-full group-hover:bg-primary transition-colors duration-200"
                                ></div>
                                <span class="font-medium">{{
                                    menuItem.name
                                }}</span>
                            </button>
                        </div>
                    </nav>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-gray-100/50 space-y-3">
                    <!-- Logout Button for Authenticated Users -->
                    <form v-if="user" @submit.prevent="logoutHandler">
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] font-medium"
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
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                ></path>
                            </svg>
                            Keluar
                        </button>
                    </form>

                    <!-- Auth Buttons for Guest Users -->
                    <div v-else class="space-y-3">
                        <inertia-link
                            :href="route('login.index')"
                            class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-primary to-accent text-white rounded-2xl hover:from-primary-hover hover:to-accent-hover transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] font-medium"
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
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                                ></path>
                            </svg>
                            Masuk
                        </inertia-link>
                        <inertia-link
                            :href="route('register.index')"
                            class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white border-2 border-primary text-primary rounded-2xl hover:bg-primary hover:text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] font-medium"
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
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                ></path>
                            </svg>
                            Daftar Akun
                        </inertia-link>
                    </div>
                </div>
            </div>
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
    // Close sidebar after navigation
    isSidebarOpen.value = false;
};
</script>

<style scoped>
/* Custom glassmorphism and responsive styling */
.drawer-side {
    z-index: 60;
}

/* Smooth transitions for all interactive elements */
.drawer-content label {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced hover states */
.drawer-content label:hover {
    transform: scale(1.05);
}

/* Mobile responsive adjustments */
@media (max-width: 640px) {
    .w-80 {
        width: 100vw;
        max-width: 320px;
    }

    .sm\\:w-96 {
        width: 100vw;
        max-width: 320px;
    }

    .p-6 {
        padding: 1rem;
    }

    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }

    .px-4 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .py-3 {
        padding-top: 0.625rem;
        padding-bottom: 0.625rem;
    }
}

/* Medium screens */
@media (min-width: 641px) and (max-width: 1024px) {
    .w-80 {
        width: 22rem;
    }

    .sm\\:w-96 {
        width: 24rem;
    }
}

/* Large screens */
@media (min-width: 1025px) {
    .w-80 {
        width: 20rem;
    }

    .sm\\:w-96 {
        width: 24rem;
    }
}

/* Animation for menu items */
.group {
    position: relative;
    overflow: hidden;
}

.group::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(217, 70, 239, 0.1),
        transparent
    );
    transition: left 0.5s ease;
}

.group:hover::before {
    left: 100%;
}

/* Custom scrollbar for long menus */
.drawer-side > div {
    scrollbar-width: thin;
    scrollbar-color: rgba(217, 70, 239, 0.3) transparent;
}

.drawer-side > div::-webkit-scrollbar {
    width: 6px;
}

.drawer-side > div::-webkit-scrollbar-track {
    background: transparent;
}

.drawer-side > div::-webkit-scrollbar-thumb {
    background-color: rgba(217, 70, 239, 0.3);
    border-radius: 3px;
}

.drawer-side > div::-webkit-scrollbar-thumb:hover {
    background-color: rgba(217, 70, 239, 0.5);
}

/* Enhanced focus states for accessibility */
.drawer-content label:focus-visible {
    outline: 2px solid #d946ef;
    outline-offset: 2px;
}

button:focus-visible,
a:focus-visible {
    outline: 2px solid #d946ef;
    outline-offset: 2px;
    border-radius: 1rem;
}

/* Loading animation for buttons */
@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Smooth height transitions */
.space-y-1 > * + *,
.space-y-2 > * + *,
.space-y-3 > * + * {
    transition: margin-top 0.2s ease;
}

/* Enhanced shadow effects */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.shadow-lg {
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
