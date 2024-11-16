<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <h1 class="font-bold text-2xl">Dashboar Home</h1>
            <section class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <CardBoxWidget
                    :icon="mdiCash"
                    label="Total Pendapatan"
                    :number="totalRevenue"
                    :trend="evaluateTrend(totalRevenue, minimumRevenue)"
                    :trend-type="evaluateTrend(totalRevenue, minimumRevenue)"
                    color="text-base-300 dark:text-white"
                />
                <CardBoxWidget
                    :icon="mdiCakeVariant"
                    label="Total Kue Terjual"
                    :number="totalCakeSold"
                    :trend="evaluateTrend(totalCakeSold, minimumCakeSold)"
                    :trend-type="evaluateTrend(totalCakeSold, minimumCakeSold)"
                    color="text-base-300 dark:text-white"
                />
                <CardBox>
                    <section class="flex items-center justify-between">
                        <h3
                            class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                        >
                            Kue Paling Populer
                        </h3>
                        <BaseIcon :path="mdiCakeLayered" :size="32" />
                    </section>
                    <section class="flex items-center relative right-5">
                        <div class="avatar w-fit rounded-lg">
                            <div class="w-20">
                                <img
                                    :src="
                                        mostPopularCake.cake_image
                                            ? mostPopularCake.cake_image
                                            : '/assets/image/default-img.jpg'
                                    "
                                    alt="Tailwind-CSS-Avatar-component"
                                />
                            </div>
                        </div>
                        <section
                            class="flex flex-col justify-center relative top-2.5"
                        >
                            <h1 class="text-xl leading-tight font-semibold">
                                {{ mostPopularCake.cake_name }}
                            </h1>
                            <label
                                class="text-sm leading-tight text-gray-500 dark:text-slate-400"
                            >
                                {{ mostPopularCake.total_sold }} terjual
                            </label>
                        </section>
                    </section>
                </CardBox>
            </section>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import { mdiCakeLayered, mdiCakeVariant, mdiCash } from "@mdi/js";
import CardBoxWidget from "@/Components/DashboardAdmin/CardBoxWidget.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";

const props = defineProps({
    totalRevenue: Number,
    totalCakeSold: Number,
    mostPopularCake: Object,
});

const minimumRevenue = 1000000;
const minimumCakeSold = 5;

/**
 * Evaluates the trend based on the total and minimum values.
 *
 * @param {number} total - The total number of items.
 * @param {number} minimum - The minimum threshold value.
 * @returns {string} - Returns "up" if the total is greater than the minimum, otherwise "down".
 */
const evaluateTrend = (total, minimum) => {
    if (total > minimum) {
        return "up";
    }

    return "down";
};
</script>

<style lang="scss" scoped></style>
