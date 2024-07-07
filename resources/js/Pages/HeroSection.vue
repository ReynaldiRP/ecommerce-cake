<template>
    <div class="h-screen flex flex-col justify-center items-center">
        <article
            class="h-3/4 lg:h-full flex justify-center items-center bg-[url('/assets/image/home-image-cake.png')] bg-no-repeat bg-center bg-contain lg:bg-none"
        >
            <section
                class="min-h-1/2 w-full lg:h-full lg:w-1/2 lg:px-28 bg-base-200 lg:bg-base-100 p-4 lg:p-0 rounded-lg flex flex-col justify-center gap-6"
            >
                <div class="flex flex-col text-xl lg:text-2xl gap-3">
                    <h1 class="font-bold uppercase text-primary-color">
                        Create your perfect cake just for you!
                    </h1>
                    <p class="text-lg lg:text-xl text-justify">
                        Welcome to DreamDessert, where your dream cake becomes a
                        reality! From elegant wedding cakes to delicious
                        brownies and delightful pastries, we offer a wide range
                        of options to satisfy your sweet tooth.
                    </p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="btn btn-outline btn-xs sm:btn-sm lg:btn-md text-white hover:bg-primary-color hover:opacity-65 hover:text-black border-primary-color"
                    >
                        Order Now
                    </button>
                    <button
                        class="btn btn-xs sm:btn-sm lg:btn-md text-black bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none"
                    >
                        <inertia-link :href="route('/products')"
                            >Discovery Our Catalogs</inertia-link
                        >
                    </button>
                </div>
            </section>
            <section
                class="h-3/4 w-1/2 hidden lg:flex lg:bg-[url('/assets/image/home-image-cake.png')] bg-no-repeat bg-center bg-contain"
            ></section>
        </article>
    </div>
</template>

<script setup></script>
