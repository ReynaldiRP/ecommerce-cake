<template>
    <App>
        <section class="min-h-screen container">
            <section
                class="min-h-screen flex flex-col py-[132px] lg:py-28 px-10 gap-8"
            >
                <div class="flex gap-4">
                    <div class="flex flex-col gap-2 justify-center">
                        <h1 class="text-3xl font-bold">
                            Order details {OrderId}
                        </h1>
                        <span class="text-sm">Date: 08/11/2024</span>
                    </div>
                    <div
                        class="badge text-xl bg-neutral text-primary-color py-4 px-6 rounded-lg font-bold relative top-1"
                    >
                        Order Confirmed
                    </div>
                </div>

                <section class="w-full my-8 flex justify-center items-center">
                    <ul
                        class="timeline timeline-vertical lg:timeline-horizontal"
                    >
                        <li class="h-[250px] lg:w-[250px]">
                            <div class="timeline-end lg:timeline-start">
                                <div
                                    class="flex flex-col gap-1 lg:items-center"
                                >
                                    <span class="text-lg font-medium"
                                        >Order Confirmed</span
                                    >
                                    <span class="text-sm font-light"
                                        >08.00, 24 February 2024</span
                                    >
                                </div>
                            </div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr class="bg-primary" />
                        </li>
                        <li class="h-[250px] lg:w-[250px]">
                            <hr class="bg-primary" />
                            <div class="timeline-start">
                                <div
                                    class="flex flex-col gap-1 lg:items-center"
                                >
                                    <span class="text-lg font-medium"
                                        >Order Process</span
                                    >
                                    <span class="text-sm font-light"
                                        >08.00, 24 February 2024</span
                                    >
                                </div>
                            </div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr class="bg-primary" />
                        </li>
                        <li class="h-[250px] lg:w-[250px]">
                            <hr class="bg-primary" />
                            <div class="timeline-end">
                                <div
                                    class="flex flex-col gap-1 lg:items-center"
                                >
                                    <span class="text-lg font-medium"
                                        >Order Packaging</span
                                    >
                                    <span class="text-sm font-light"
                                        >08.00, 24 February 2024</span
                                    >
                                </div>
                            </div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <hr class="bg-primary" />
                        </li>
                        <li>
                            <hr class="bg-primary" />
                            <div class="timeline-start">
                                <div
                                    class="flex flex-col gap-1 items-end lg:items-center"
                                >
                                    <span
                                        class="text-lg text-end lg:text-center font-medium"
                                        >Order Ready for Pickup/Delivery</span
                                    >
                                    <span class="text-sm font-light"
                                        >08.00, 24 February 2024</span
                                    >
                                </div>
                            </div>
                            <div class="timeline-middle">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="text-primary h-5 w-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </li>
                    </ul>
                </section>

                <div class="flex flex-col gap-4 mt-6">
                    <h1 class="text-2xl font-bold">Item ordered</h1>
                    <div class="w-full px-8 bg-neutral rounded-lg">
                        <div
                            class="flex justify-between items-center px-4 py-6"
                            v-for="items in 3"
                        >
                            <div class="flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-16 lg:w-20 rounded">
                                        <img
                                            src="assets/image/default-img.jpg"
                                            alt="Tailwind-CSS-Avatar-component"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h1
                                        class="font-bold text-base md:text-lg lg:text-xl m-0"
                                    >
                                        Base Cake
                                    </h1>
                                    <div
                                        class="flex flex-col lg:flex-row gap-0 lg:gap-1  text-sm md:text-base lg:text-lg font-medium text-opacity-70"
                                    >
                                        <p>Chocolate</p>
                                        <p>Stroberry, Manggo</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-lg">2x</p>
                            <p class="text-lg">Rp4000</p>
                        </div>
                    </div>
                    <div
                        class="w-fit ms-auto px-12 py-4 flex flex-col gap-12 bg-neutral rounded-lg"
                    >
                        <div class="flex gap-24">
                            <h1 class="text-xl font-bold">Product Total:</h1>
                            <span class="text-lg font-bold">Rp40000</span>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
</script>
