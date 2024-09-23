<template>
    <div
        tabindex="0"
        class="card card-compact dropdown-content w-96 bg-base-100 shadow"
    >
        <div class="card-body">
            <div class="flex flex-col gap-1">
                <h1 class="text-center text-lg font-bold">
                    Shopping Chart is Empty
                </h1>
                <p class="text-center font-light">
                    Add to cart and sweeten your day!
                </p>
            </div>
            <inertia-link
                :href="route('home')"
                class="mx-auto btn btn-sm text-black hover:text-white bg-primary-color"
            >
                Start shopping
            </inertia-link>
            <img
                src="/assets/image/cake-not-found.gif"
                class="rounded-xl"
                alt="image not found"
            />
        </div>
    </div>
</template>

<script setup></script>
