<template>
    <App>
        <section
            class="min-h-screen w-full flex flex-col justify-center gap-4 pt-36 pb-14 px-10 lg:px-20"
        >
            <h1 class="text-2xl font-bold">Shopping Chart</h1>
            <section class="grid grid-cols-12 gap-8">
                <section class="min-w-[750px] col-span-8 flex flex-col gap-6">
                    <div class="h-full px-3 py-5 bg-white rounded-t-lg">
                        <BaseCheckbox label="Choose All" text-color="black" />
                    </div>
                    <div class="flex flex-col gap-4">
                        <div
                            class="flex justify-between items-center gap-2 px-3 py-4 bg-white rounded-md"
                            v-for="(items, index) in 5"
                            :key="index"
                        >
                            <div class="flex gap-2">
                                <BaseCheckbox />
                                <div class="flex gap-4">
                                    <div class="avatar rounded-lg outline outline-neutral shadow-lg">
                                        <div class="w-20 rounded">
                                            <img
                                                src="assets/image/default-img.jpg"
                                                alt="Tailwind-CSS-Avatar-component"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <h1 class="text-xl text-base-200">
                                            Product {{ items }}
                                        </h1>
                                        <p
                                            class="text-base text-base-200 text-opacity-75"
                                        >
                                            Product {{ items }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="join">
                                <button
                                    class="btn btn-outline shadow-lg join-item"
                                >
                                    -
                                </button>
                                <input
                                    class="input input-ghost input-bordered text-center w-14 join-item focus:bg-transparent"
                                    :value="items"
                                />
                                <button
                                    class="btn btn-outline shadow-lg join-item"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="h-[28%] col-span-4 flex justify-center">
                    <section
                        class="w-full flex flex-col gap-2 px-5 py-4 bg-white rounded-lg"
                    >
                        <h1 class="text-base-200 text-2xl font-bold">
                            Shopping Summary
                        </h1>
                        <p></p>
                        <div
                            class="flex justify-between text-base-200 font-bold text-lg"
                        >
                            <p>Total</p>
                            <p>Rp100000</p>
                        </div>
                        <button
                            class="btn btn-block mt-auto text-black bg-primary-color hover:bg-primary-color hover:opacity-65 hover:text-slate-500 border-none"
                        >
                            Checkout
                        </button>
                    </section>
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
</script>
