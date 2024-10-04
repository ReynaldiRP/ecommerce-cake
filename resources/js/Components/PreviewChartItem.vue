<template>
    <div>
        <dialog
            id="my_modal_3"
            class="modal"
            :class="isPreviewOpen ? 'modal-open' : ''"
        >
            <div class="modal-box w-11/12 max-w-5xl flex flex-col gap-4">
                <div class="flex justify-between items-center text-xl">
                    <h3 class="font-bold">{{ successMessage }}</h3>
                    <button
                        class="btn btn-circle btn-ghost text-xl"
                        @click="$emit('update:isPreviewOpen', false)"
                    >
                        ✕
                    </button>
                </div>

                <div
                    class="p-4 bg-base-300 shadow-xl rounded-xl flex gap-2 items-center justify-between"
                >
                    <div class="flex items-center gap-4">
                        <div class="avatar">
                            <div class="w-16 rounded">
                                <img
                                    :src="
                                        chart.image
                                            ? chart.cake_image
                                            : '/assets/image/default-img.jpg'
                                    "
                                    alt="Tailwind-CSS-Avatar-component"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 text-balance">
                            <p>{{ chart.cake_name }}</p>
                            <div
                                class="flex gap-1"
                                v-if="chart.cake_flavour_name"
                            >
                                <p>{{ chart.cake_flavour_name }}</p>
                                <span
                                    v-show="
                                        chart.cake_flavour_name &&
                                        chart.cake_toppings.length > 1
                                    "
                                    >|</span
                                >
                                <p>{{ chart.cake_toppings.join(", ") }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col-reverse md:flex-row items-center gap-2 font-medium"
                    >
                        <inertia-link
                            :href="route('products')"
                            class="btn btn-md btn-neutral"
                        >
                            Continue Shopping
                        </inertia-link>
                        <inertia-link
                            :href="route('detail-chart')"
                            class="btn btn-md text-black bg-primary-color hover:bg-base-300 hover:text-white"
                        >
                            See Chart
                        </inertia-link>
                    </div>
                </div>
            </div>
        </dialog>
    </div>
</template>

<script setup>
const props = defineProps({
    isPreviewOpen: {
        type: Boolean,
        default: false,
    },
    chart: {
        type: Object,
        default: null,
    },
    successMessage: {
        type: String,
        default: null,
    },
});
</script>
