<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
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
            class="mt-3 z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow"
        >
            <div class="card-body gap-4">
                <div
                    class="flex justify-between items-center gap-2 bg-[#A6ADBB] rounded-lg shadow-xl"
                    v-for="(items, index) in 3"
                    :key="index"
                >
                    <div class="flex items-center gap-2">
                        <div class="avatar">
                            <div class="w-16 rounded">
                                <img
                                    src="assets/image/default-img.jpg"
                                    alt="Tailwind-CSS-Avatar-component"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col text-base-200">
                            <h1 class="font-bold text-lg m-0">Cake Name</h1>
                            <div class="flex text-sm font-medium">
                                <p>Flavour</p>
                                <p>, Toppings</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center text-base-200 gap-1 me-2 font-bold"
                    >
                        <p>2</p>
                        <p>x</p>
                        <p>Rp400000</p>
                    </div>
                </div>
                <div class="card-actions">
                    <button
                        class="btn btn-sm bg-primary-color text-slate-700 hover:text-white btn-block"
                    >
                        View cart (Jumlah Pesanan)
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
