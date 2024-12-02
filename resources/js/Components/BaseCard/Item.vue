<template>
    <div>
        <inertia-link :href="route('detail-product', cakes.id)">
            <figure>
                <img
                    :src="cakes.image_url"
                    alt="Shoes"
                    class="h-[180px] object-cover w-full rounded-lg"
                />
                <div
                    class="avatar placeholder absolute top-2 right-2 tooltip"
                    :data-tip="`Berlaku hingga, ${cakes.discount?.end_date}`"
                >
                    <div
                        v-if="cakes.discount"
                        class="bg-red-500 text-white w-6 rounded-full"
                    >
                        <span class="text-xs">
                            <i
                                class="fa-solid fa-percent"
                                style="color: #ffffff"
                            ></i>
                        </span>
                    </div>
                </div>
            </figure>
            <div class="card-body gap-1 text-base-content">
                <h2 class="text-base font-medium">
                    {{ cakes.name }}
                </h2>
                <section>
                    <section v-if="cakes.discount">
                        <p class="text-lg font-bold text-red-500">
                            {{ formatPrice(cakes.discounted_price) }}
                        </p>
                        <div class="flex gap-1 items-center">
                            <p class="text-lg font-light line-through">
                                {{ formatPrice(cakes.base_price) }}
                            </p>
                            <span class="text-xs text-red-400"
                                >({{
                                    cakes.discount.discount_percentage
                                }}%)</span
                            >
                        </div>
                    </section>
                    <p v-else class="text-lg font-bold">
                        {{ formatPrice(cakes.base_price) }}
                    </p>
                </section>
                <div class="flex flex-col gap-2">
                    <div
                        class="flex gap-2 items-center badge"
                        :class="isCustomizedBadge()"
                    >
                        <i
                            v-if="cakes.personalization_type === 'customized'"
                            class="fa-solid fa-cake-candles"
                        ></i>
                        <i v-else class="fa-solid fa-cookie"></i>
                        <p class="font-medium text-nowrap">
                            {{ cakes.personalization_type }}
                        </p>
                    </div>
                    <div class="badge badge-outline badge-light">
                        {{ cakes.category.name }}
                    </div>
                </div>
            </div>
        </inertia-link>
    </div>
</template>

<script setup>
const props = defineProps({
    cakes: Object,
    formatPrice: Function,
});

const isCustomizedBadge = () => {
    return props.cakes.personalization_type === "customized"
        ? "badge-secondary "
        : " badge-neutral";
};
</script>
