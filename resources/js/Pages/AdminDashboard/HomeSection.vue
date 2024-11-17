<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <h1 class="font-bold text-2xl">Dashboard Home</h1>
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
                    <section class="flex flex-col gap-4">
                        <section class="flex items-center justify-between">
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Kue Paling Populer
                            </h3>
                            <BaseIcon :path="mdiCakeLayered" :size="32" />
                        </section>
                        <section class="flex items-center gap-2">
                            <div class="avatar w-fit">
                                <div class="w-20 rounded-lg">
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
                    </section>
                </CardBox>
                <CardBox>
                    <section class="flex flex-col gap-4">
                        <section class="flex items-center justify-between">
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Kategori Kue Paling Populer
                            </h3>
                            <BaseIcon :path="mdiCakeVariant" :size="32" />
                        </section>
                        <section class="flex items-center gap-2">
                            <section
                                class="flex flex-col justify-center relative top-2.5"
                            >
                                <h1 class="text-xl leading-tight font-semibold">
                                    {{ mostPopularCakeCategory.category_name }}
                                </h1>
                                <label
                                    class="text-sm leading-tight text-gray-500 dark:text-slate-400"
                                >
                                    <NumberDynamic
                                        :value="
                                            mostPopularCakeCategory.total_sold
                                        "
                                        suffix=" terjual"
                                    />
                                </label>
                            </section>
                        </section>
                    </section>
                </CardBox>
            </section>
            <CardBox>
                <LineChart :data="chartData" class="h-96" />
            </CardBox>
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
import LineChart from "@/Components/DashboardAdmin/Charts/LineChart.vue";
import { onMounted, ref } from "vue";
import NumberDynamic from "@/Components/DashboardAdmin/NumberDynamic.vue";

const props = defineProps({
    totalRevenue: Number,
    totalCakeSold: Number,
    mostPopularCake: Object,
    mostPopularCakeCategory: Object,
    chartData: Object,
});

const minimumRevenue = 1000000;
const minimumCakeSold = 5;
const chartData = ref({});

// TODO: fix the implementation of extractMonthLabels and totalRevenueEachMonth for the chartData

const sampleChartData = {
    labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Okt",
        "Nov",
        "Des",
    ],
    datasets: [
        {
            label: "Pendapatan",
            data: props.chartData.map((data) => data.total_revenue),
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
        },
    ],
};

const fillChartData = () => {
    chartData.value = sampleChartData;
};

onMounted(() => {
    fillChartData();
});

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
