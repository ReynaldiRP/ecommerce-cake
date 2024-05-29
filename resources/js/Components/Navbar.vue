<template>
    <div class="navbar px-5 py-4 bg-base-200">
        <div class="navbar-start gap-3">
            <div class="avatar">
                <div class="w-24 lg:w-16 rounded-full">
                    <img
                        src="/assets/image/logo-dreamdessert.webp"
                        alt="ini gambar"
                    />
                </div>
            </div>
            <a
                href="#"
                class="text-xl font-bold text-primary-color cursor-pointer"
                >Dream Dessert</a
            >
        </div>
        <ul class="navbar-center hidden lg:flex gap-8">
            <li
                v-for="(menu, index) in menu"
                class="text-lg font-medium cursor-pointer transition-all hover:text-primary-color"
            >
                <inertia-link :href="`/${menu.toLowerCase()}`">
                    {{ menu }}
                </inertia-link>
            </li>
        </ul>
        <div class="navbar-end flex flex-row-reverse justify-stretch lg:hidden">
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
                        <inertia-link :href="`/${menus}`">{{
                            menus
                        }}</inertia-link>
                    </li>
                </ul>
            </div>
            <div class="flex gap-5">
                <div class="flex justify-center items-center">
                    <div class="dropdown dropdown-end hidden">
                        <div
                            tabindex="0"
                            role="button"
                            class="btn btn-ghost btn-circle avatar"
                        >
                            <div class="w-10 rounded-full">
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
                            <li><a>Logout</a></li>
                        </ul>
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
                                <span class="badge badge-sm indicator-item"
                                    >8</span
                                >
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
                </div>
                <div class="flex justify-center items-center">
                    <div class="dropdown dropdown-end">
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
                            <li><a>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-end hidden lg:flex gap-5">
            <div
                class="flex flex-row-reverse justify-center items-center gap-2"
            >
                <div class="dropdown dropdown-end hidden">
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
                        <li><a>Logout</a></li>
                    </ul>
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
            </div>
            <div class="flex gap-1">
                <inertia-link
                    :href="route('authentication.login')"
                    class="btn btn-ghost"
                    >Login</inertia-link
                >
                <inertia-link
                    href=""
                    class="btn btn-md bg-pink-200 bg-opacity-25 text-primary-color hover:text-white"
                    >Create New Account</inertia-link
                >
            </div>
        </div>
    </div>
</template>

<script setup>
const menu = ["Home", "About", "Catalog", "Contact"];
</script>
