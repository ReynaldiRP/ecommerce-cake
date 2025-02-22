<template>
    <div
        class="col-span-8 flex items-start gap-4 px-4 py-12 bg-neutral rounded-lg"
    >
        <img
            src="/assets/image/cake-not-found.gif"
            class="w-64 h-64 rounded-xl"
            alt="image not found"
        />
        <div class="flex flex-col gap-4 justify-center">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-bold">
                    Ups! Keranjangmu masih kosong...
                </h1>
                <p class="text-lg font-light">
                    Saatnya mengisinya dengan kelezatan! 🍰
                </p>
            </div>

            <inertia-link
                :href="route('home')"
                class="btn text-black hover:text-white bg-primary-color w-1/2"
            >
                Start shopping
            </inertia-link>
        </div>
    </div>
</template>

<script setup></script>
