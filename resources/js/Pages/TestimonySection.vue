<template>
    <section class="h-screen py-[5%] my-4 px-10 flex flex-col items-center">
        <h1
            class="relative bottom-10 lg:bottom-16 text-3xl lg:text-4xl font-semibold text-base-100"
        >
            Apa Yang Dikatan Pelanggan Kami
        </h1>
        <section
            class="h-full grid lg:grid-cols-3 gap-4 place-items-center items-center"
        >
            <article
                class="h-full w-full bg-primary-color-light shadow-xl rounded-xl flex flex-col items-center"
                v-for="item in 3"
                :key="item"
            >
                <div class="avatar relative bottom-6 lg:bottom-10">
                    <div class="w-16 lg:w-24 rounded-full">
                        <img src="/assets/image/default-img.jpg" />
                    </div>
                </div>
                <div
                    class="flex flex-col items-center py-4 px-6 text-justify relative bottom-6"
                >
                    <h1 class="font-bold text-lg lg:text-xl text-base-100">
                        Pelanggan
                    </h1>
                    <p
                        class="font-medium textarea-sm lg:textarea-lg text-base-200"
                    >
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. In atque, mollitia, laboriosam, aliquid corrupti
                        nisi enim similique expedita vel saepe error dolorum ea
                        impedit cupiditate vero ipsa accusamus ut inventore!
                    </p>
                </div>
            </article>
        </section>
    </section>
</template>

<script setup></script>
