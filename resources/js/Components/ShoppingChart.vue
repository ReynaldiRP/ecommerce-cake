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
                <span class="badge badge-sm indicator-item">{{
                    products.length
                }}</span>
            </div>
        </div>
        <div
            tabindex="0"
            class="z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow"
        >
            <div class="card-body gap-4">
                <inertia-link
                    class="flex justify-between items-center gap-2 bg-[#A6ADBB] rounded-lg shadow-xl"
                    v-for="(items, index) in products"
                    :key="index"
                    :href="link"
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
                            <h1 class="font-bold text-lg m-0">
                                {{ items.name }}
                            </h1>
                            <div
                                class="flex text-base-200 text-sm font-medium text-opacity-70"
                                :class="{
                                    hidden: !items.flavour && !items.toppings,
                                }"
                            >
                                <p>{{ items.flavour }}</p>
                                <p>, {{ items.toppings }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center text-base-200 gap-1 me-2 font-bold"
                    >
                        <p>{{ items.quantity }}</p>
                        <p>x</p>
                        <p>Rp{{ items.price }}</p>
                    </div>
                </inertia-link>
                <div class="card-actions">
                    <inertia-link
                        :href="route('/detail-chart')"
                        class="btn btn-sm bg-primary-color text-slate-700 hover:text-white btn-block"
                    >
                        View cart ({{ products.length }})
                    </inertia-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    link: {
        type: String,
    },
    products: {
        type: Array,
    },
});
</script>
