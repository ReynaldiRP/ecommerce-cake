<template>
    <App>
        <section
            class="min-h-screen w-full grid grid-cols-5 place-items-center gap-4 px-16 py-36 m-0 overflow-hidden"
        >
            <section
                class="col-span-1 h-fit w-full flex flex-col mb-auto gap-2 relative bottom-9"
            >
                <h1 class="text-lg font-medium me-auto">Filter</h1>
                <section
                    class="h-full w-[90%] rounded-xl bg-white flex flex-col gap-4 px-6 py-4"
                >
                    <section class="flex flex-col gap-3">
                        <h1 class="text-lg font-bold text-base-200">
                            Personalization
                        </h1>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Customized</span
                                >
                            </label>
                        </div>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Non Customized</span
                                >
                            </label>
                        </div>
                    </section>
                    <section class="flex flex-col gap-3">
                        <h1 class="text-lg font-bold text-base-200">
                            Category
                        </h1>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Tart</span
                                >
                            </label>
                        </div>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Wedding Cake</span
                                >
                            </label>
                        </div>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Pastry</span
                                >
                            </label>
                        </div>
                        <div class="form-control">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox btn-outline hover:bg-base-200"
                                />
                                <span
                                    class="text-base text-base-200 font-medium"
                                    >Pudding</span
                                >
                            </label>
                        </div>
                    </section>
                </section>
            </section>
            <section
                class="col-span-4 flex flex-col items-center justify-center gap-8"
            >
                <section class="grid lg:grid-cols-4 gap-4">
                    <CardLayout :width="56" v-for="items in 6" :key="items">
                        <CardItem
                            image-url="assets/image/pastry.png"
                            cake-name="Wedding Cake"
                            :cake-price="`Rp ${price}`"
                            cake-flavour="Vanilla"
                            cake-toppings="Berry, Choco"
                        />
                    </CardLayout>
                </section>
                <div class="join">
                    <button class="join-item btn">«</button>
                    <button class="join-item btn" v-for="item in 4" :key="item">
                        {{ item }}
                    </button>
                    <button class="join-item btn">»</button>
                </div>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import CardLayout from "@/Components/BaseCard/Layout.vue";
import CardItem from "@/Components/BaseCard/Item.vue";

const price = 15000;
</script>
