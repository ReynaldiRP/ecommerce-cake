<template>
    <div class="h-screen flex flex-col justify-center items-center">
        <article
            class="h-3/4 lg:h-full grid grid-cols-2 bg-[url('/assets/image/home-image-cake.png')] bg-no-repeat bg-center bg-contain lg:bg-none"
        >
            <section
                class="relative top-32 lg:top-0 w-full lg:col-span-1 col-span-2 px-10 lg:px-0"
            >
                <section
                    class="min-h-1/2 w-full lg:h-full lg:px-28 bg-base-200 lg:bg-base-100 py-4 px-8 lg:p-0 rounded-lg flex flex-col justify-center gap-6"
                >
                    <div class="flex flex-col text-xl lg:text-2xl gap-3">
                        <h1 class="font-bold uppercase text-primary-color">
                            Create your perfect cake just for you!
                        </h1>
                        <p class="text-lg lg:text-xl text-justify">
                            Welcome to DreamDessert, where your dream cake
                            becomes a reality! From elegant wedding cakes to
                            delicious brownies and delightful pastries, we offer
                            a wide range of options to satisfy your sweet tooth.
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <inertia-link
                            :href="route('products')"
                            class="btn btn-xs sm:btn-sm lg:btn-md text-black bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none"
                        >
                            Discovery Our Catalogs >
                        </inertia-link>
                    </div>
                </section>
            </section>

            <section
                class="hidden lg:flex lg:bg-[url('/assets/image/home-image-cake.png')] bg-no-repeat bg-center bg-contain"
            ></section>
        </article>
    </div>
</template>

<script setup></script>
