<template>
    <div
        tabindex="0"
        :class="{
            'card card-compact dropdown-content w-96 bg-base-100 shadow':
                !isMobileDisplayed,
            hidden: isMobileDisplayed,
        }"
    >
        <div class="card-body">
            <div class="flex flex-col gap-1">
                <h1 class="text-center text-lg font-bold">
                    Keranjang Belanja Kosong
                </h1>
                <p class="text-center font-light">
                    tambahkan pesanan ke keranjang belanja anda!
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

<script setup>
defineProps({
    isMobileDisplayed: {
        type: Boolean,
        default: false,
    },
});
</script>
