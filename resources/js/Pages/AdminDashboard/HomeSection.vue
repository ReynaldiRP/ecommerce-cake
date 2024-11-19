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
                    :icon="mdiChartBellCurveCumulative"
                    label="Persentase Pertumbuhan Pendapatan"
                    suffix="%"
                    :number="growthRevenuePerMonthByPercentage"
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
                        <BaseLevel mobile>
                            <PillTagTrend trend="up" trend-type="up" small />
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Kue Terpopuler
                            </h3>
                        </BaseLevel>
                        <BaseLevel class="mt-3" mobile>
                            <section class="flex items-center mt-3 gap-2">
                                <div class="avatar w-fit">
                                    <div class="w-16 rounded-lg">
                                        <img
                                            :src="
                                                mostPopularCake.image_url ??
                                                'https://via.placeholder.com/150'
                                            "
                                            alt="Tailwind-CSS-Avatar-component"
                                        />
                                    </div>
                                </div>
                                <section
                                    class="flex flex-col justify-center relative top-2.5"
                                >
                                    <h1
                                        class="text-xl leading-tight font-semibold"
                                    >
                                        {{ mostPopularCake.cake_name ?? "N/A" }}
                                    </h1>
                                    <label
                                        class="text-sm leading-tight text-gray-500 dark:text-slate-400"
                                    >
                                        {{ mostPopularCake.total_sold ?? 0 }}
                                        terjual
                                    </label>
                                </section>
                            </section>
                            <BaseIcon
                                :path="mdiCakeVariant"
                                :size="48"
                                w=""
                                h="h-16"
                                class="text-base-300 dark:text-white"
                            />
                        </BaseLevel>
                    </section>
                </CardBox>
                <CardBox>
                    <section class="flex flex-col gap-4">
                        <BaseLevel mobile>
                            <PillTagTrend trend="up" trend-type="up" small />
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Tipe Kue Terpopuler
                            </h3>
                        </BaseLevel>
                        <BaseLevel class="mt-3" mobile>
                            <section class="flex flex-col gap-1">
                                <h1 class="text-xl leading-tight font-semibold">
                                    {{
                                        mostPopularCakeType.cake_type_name ??
                                        "N/A"
                                    }}
                                </h1>
                                <label
                                    class="text-sm leading-tight text-gray-500 dark:text-slate-400"
                                >
                                    <NumberDynamic
                                        :value="
                                            mostPopularCakeType.total_sold ?? 0
                                        "
                                        suffix=" terjual"
                                    />
                                </label>
                            </section>
                            <BaseIcon
                                :path="mdiCakeVariant"
                                :size="48"
                                w=""
                                h="h-16"
                                class="text-base-300 dark:text-white"
                            />
                        </BaseLevel>
                    </section>
                </CardBox>
                <CardBox>
                    <section class="flex flex-col gap-4">
                        <BaseLevel mobile>
                            <PillTagTrend trend="up" trend-type="up" small />
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Kategori Kue Terpopuler
                            </h3>
                        </BaseLevel>
                        <BaseLevel class="mt-3" mobile>
                            <section class="flex flex-col gap-1">
                                <h1 class="text-xl leading-tight font-semibold">
                                    {{
                                        mostPopularCakeCategory.category_name ??
                                        "N/A"
                                    }}
                                </h1>
                                <label
                                    class="text-sm leading-tight text-gray-500 dark:text-slate-400"
                                >
                                    <NumberDynamic
                                        :value="
                                            mostPopularCakeCategory.total_sold ??
                                            0
                                        "
                                        suffix=" terjual"
                                    />
                                </label>
                            </section>
                            <BaseIcon
                                :path="mdiCakeVariant"
                                :size="48"
                                w=""
                                h="h-16"
                                class="text-base-300 dark:text-white"
                            />
                        </BaseLevel>
                    </section>
                </CardBox>
            </section>

            <section class="flex flex-col gap-4 mt-8">
                <h1 class="font-bold text-2xl">Grafik Pendapatan Perbulan</h1>
                <CardBox>
                    <LineChart :data="chartData" class="h-96" />
                </CardBox>
            </section>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import { mdiCakeVariant, mdiCash, mdiChartBellCurveCumulative } from "@mdi/js";
import CardBoxWidget from "@/Components/DashboardAdmin/CardBoxWidget.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import LineChart from "@/Components/DashboardAdmin/Charts/LineChart.vue";
import { computed, onMounted, ref } from "vue";
import NumberDynamic from "@/Components/DashboardAdmin/NumberDynamic.vue";
import BaseLevel from "@/Components/DashboardAdmin/BaseLevel.vue";
import PillTagTrend from "@/Components/DashboardAdmin/PillTagTrend.vue";

const props = defineProps({
    totalRevenue: Number,
    totalCakeSold: Number,
    mostPopularCake: Object,
    mostPopularCakeType: Object,
    mostPopularCakeCategory: Object,
    growthRevenuePerMonthByPercentage: Object,
    chartData: Object,
});

const minimumRevenue = 1000000;
const minimumCakeSold = 5;
const chartData = ref({});

const growthRevenuePerMonthByPercentage = computed(() => {
    return growthRevenuePerMonthByPercentage.length > 0
        ? growthRevenuePerMonthByPercentage[0].growth_percentage
        : 0;
});

// TODO: fix the implementation of extractMonthLabels and totalRevenueEachMonth for the chartData

const sampleChartData = {
    labels: props.chartData.map((data) => data.month) ?? [],
    datasets: [
        {
            label: "Pendapatan",
            data: props.chartData.map((data) => data.total_revenue) ?? [],
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
