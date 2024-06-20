<template>
    <div class="h-screen flex flex-col">
        <section
            class="hero min-h-screen"
            style="
                background-image: url(/assets/image/register-background.webp);
            "
        >
            <div class="hero-overlay bg-opacity-60"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-2xl p-10">
                    <h1 class="mb-5 text-4xl font-bold text-primary-color">
                        Create Your Perfect Cake Just for You!
                    </h1>
                    <p class="mb-5 text-justify">
                        Welcome to DreamDessert, where your dream cake becomes a
                        reality! From elegant wedding cakes to delicious
                        brownies and delightful pastries, we offer a wide range
                        of options to satisfy your sweet tooth. Select from an
                        array of flavors and mix-and-match your favorite
                        toppings to design a cake that's uniquely yours. Whether
                        it's for a birthday, wedding, or any special occasion,
                        our customization options ensure every treat is made to
                        suit your taste and style. Start crafting your perfect
                        dessert today and make your celebration unforgettable!
                    </p>
                    <div class="flex justify-center gap-2">
                        <button
                            class="btn btn-outline btn-md text-white hover:bg-primary-color hover:opacity-65 hover:text-black border-primary-color"
                        >
                            Order Now
                        </button>
                        <button
                            class="btn btn-md text-black bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none"
                        >
                            Discovery Our Catalogs
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- <article class="h-full flex justify-center items-center">
            <section class="h-full w-1/2 flex justify-center">
                <p>test</p>
            </section>
            <section
                class="hero-image h-full w-1/2 flex justify-center"
            ></section>
        </article> -->
    </div>
</template>

<script setup></script>

<style scoped>
.hero-image {
    background-image: url(/assets/image/hero-image.png);
    background-position: 55% 15%;
    background-repeat: no-repeat;
    background-size: 400px;
}
</style>
