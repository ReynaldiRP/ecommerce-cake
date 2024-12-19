<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="flex flex-col">
                <h1 class="font-bold text-2xl">Dashboard Home</h1>
                <small class="text-lg"
                    >Data pemesanan dalam kurun waktu 3 bulan terkahir</small
                >
            </div>
            <section class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <CardBoxWidget
                    :icon="mdiCash"
                    label="Total Pendapatan"
                    :value="formatPrice(totalRevenue)"
                    :trend="evaluateTrend(totalRevenue, minimumRevenue)"
                    :trend-type="evaluateTrend(totalRevenue, minimumRevenue)"
                    color="text-base-300 dark:text-white"
                />
                <CardBoxWidget
                    :icon="mdiChartBellCurveCumulative"
                    label="Persentase Pertumbuhan Pendapatan"
                    suffix="%"
                    :number="growthRevenuePerMonthByPercentage"
                    :trend="evaluateTrend(growthRevenuePerMonthByPercentage, 0)"
                    :trend-type="
                        evaluateTrend(growthRevenuePerMonthByPercentage, 0)
                    "
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
                                                mostPopularCake.cake_image ??
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
                <!--                <CardBox>-->
                <!--                    <section class="flex flex-col gap-4">-->
                <!--                        <BaseLevel mobile>-->
                <!--                            <PillTagTrend trend="up" trend-type="up" small />-->
                <!--                            <h3-->
                <!--                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"-->
                <!--                            >-->
                <!--                                Kategori Kue Terpopuler-->
                <!--                            </h3>-->
                <!--                        </BaseLevel>-->
                <!--                        <BaseLevel class="mt-3" mobile>-->
                <!--                            <section class="flex flex-col gap-1">-->
                <!--                                <h1 class="text-xl leading-tight font-semibold">-->
                <!--                                    {{-->
                <!--                                        mostPopularCakeCategory.category_name ??-->
                <!--                                        "N/A"-->
                <!--                                    }}-->
                <!--                                </h1>-->
                <!--                                <label-->
                <!--                                    class="text-sm leading-tight text-gray-500 dark:text-slate-400"-->
                <!--                                >-->
                <!--                                    <NumberDynamic-->
                <!--                                        :value="-->
                <!--                                            mostPopularCakeCategory.total_sold ??-->
                <!--                                            0-->
                <!--                                        "-->
                <!--                                        suffix=" terjual"-->
                <!--                                    />-->
                <!--                                </label>-->
                <!--                            </section>-->
                <!--                            <BaseIcon-->
                <!--                                :path="mdiCakeVariant"-->
                <!--                                :size="48"-->
                <!--                                w=""-->
                <!--                                h="h-16"-->
                <!--                                class="text-base-300 dark:text-white"-->
                <!--                            />-->
                <!--                        </BaseLevel>-->
                <!--                    </section>-->
                <!--                </CardBox>-->
                <CardBox>
                    <section class="flex flex-col gap-4">
                        <BaseLevel mobile>
                            <PillTagTrend trend="up" trend-type="up" small />
                            <h3
                                class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                            >
                                Total Transaksi
                            </h3>
                        </BaseLevel>
                        <BaseLevel class="mt-3" mobile>
                            <section class="flex flex-col gap-1">
                                <label
                                    class="text-xl leading-tight font-semibold text-gray-500 dark:text-slate-400"
                                >
                                    <NumberDynamic
                                        :value="totalTransaction ?? 0"
                                        suffix=" Transaksi"
                                    />
                                </label>
                            </section>
                            <BaseIcon
                                :path="mdiInvoiceTextArrowLeftOutline"
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
                <div class="flex justify-between items-center">
                    <h1 class="font-bold text-2xl">
                        Grafik Pendapatan Perbulan
                    </h1>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text font-bold ms-auto"
                                >Pilih Tahun Transaksi</span
                            >
                        </div>
                        <select
                            class="select select-bordered"
                            v-model="form.selectedYearRevenue"
                        >
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                        </select>
                    </label>
                </div>
                <CardBox>
                    <LineChart :data="chartRevenueData" class="h-96" />
                </CardBox>
                <h1 class="font-bold text-2xl">Grafik Penjualan Kue</h1>
                <CardBox>
                    <DoughnutChart :data="chartCakeSoldData" class="h-96" />
                </CardBox>
                <div class="flex justify-between items-center">
                    <h1 class="font-bold text-2xl">
                        Grafik Jumlah Transaksi Perbulan
                    </h1>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text font-bold ms-auto"
                                >Pilih Tahun Transaksi</span
                            >
                        </div>
                        <select
                            class="select select-bordered"
                            v-model="form.selectedYearTransaction"
                        >
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                        </select>
                    </label>
                </div>
                <CardBox>
                    <BarChart :data="chartTransactionData" class="h-96" />
                </CardBox>
            </section>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import {
    mdiCakeVariant,
    mdiCash,
    mdiChartBellCurveCumulative,
    mdiInvoiceTextArrowLeftOutline,
} from "@mdi/js";
import CardBoxWidget from "@/Components/DashboardAdmin/CardBoxWidget.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import LineChart from "@/Components/DashboardAdmin/Charts/LineChart.vue";
import { computed, onMounted, reactive, ref, watch } from "vue";
import NumberDynamic from "@/Components/DashboardAdmin/NumberDynamic.vue";
import BaseLevel from "@/Components/DashboardAdmin/BaseLevel.vue";
import PillTagTrend from "@/Components/DashboardAdmin/PillTagTrend.vue";
import DoughnutChart from "@/Components/DashboardAdmin/Charts/DoughnutChart.vue";
import BarChart from "@/Components/DashboardAdmin/Charts/BarChart.vue";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import axios from "axios";

const props = defineProps({
    totalRevenue: Number,
    totalCakeSold: Number,
    mostPopularCake: Object,
    mostPopularCakeType: Object,
    mostPopularCakeCategory: Object,
    growthRevenuePerMonthByPercentage: Number,
    totalTransaction: Number,
    chartData: Object,
    chartDataCakeSold: Object,
    chartDataTotalTransaction: Object,
});

const { formatPrice } = useAdminDashboardStore();
const minimumRevenue = 1000000;
const minimumCakeSold = 5;
const chartRevenueData = ref({});
const chartCakeSoldData = ref({});
const chartTransactionData = ref({});

const form = reactive({
    selectedYearTransaction: "2024",
    selectedYearRevenue: "2024",
});

// Growth Revenue Per Month By Percentage
const growthRevenuePerMonthByPercentage = computed(() => {
    return props.growthRevenuePerMonthByPercentage !== 0
        ? Math.round(props.growthRevenuePerMonthByPercentage)
        : 0;
});

// Chart Data
const dataRevenue = {
    labels: props.chartData.map((data) => data.month) ?? [],
    datasets: [
        {
            label: "Pendapatan",
            data: props.chartData.map((data) => data.total_revenue) ?? [],
            backgroundColor: "rgba(255, 99, 132)",
            borderColor: "rgba(255, 99, 132)",
            tension: 0.1,
        },
    ],
};
let dataTransaction = {
    labels: props.chartDataTotalTransaction.map((data) => data.month) ?? [],
    datasets: [
        {
            label: "Jumlah Transaksi",
            data: props.chartDataTotalTransaction.map(
                (data) => data.total_transaction,
            ),
            backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(255, 159, 64, 0.2)",
                "rgba(255, 205, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(201, 203, 207, 0.2)",
            ],
            borderColor: [
                "rgb(255, 99, 132)",
                "rgb(255, 159, 64)",
                "rgb(255, 205, 86)",
                "rgb(75, 192, 192)",
                "rgb(54, 162, 235)",
                "rgb(153, 102, 255)",
                "rgb(201, 203, 207)",
            ],
            borderWidth: 1,
        },
    ],
};
const dataCakeSold = {
    labels: props.chartDataCakeSold.map((data) => data.cake_name) ?? [],
    datasets: [
        {
            label: "Terjual",
            data:
                props.chartDataCakeSold.map((data) => data.sold_quantity) ?? [],
            backgroundColor: [
                "rgba(255, 99, 132)",
                "rgba(54, 162, 235)",
                "rgba(255, 206, 86)",
                "rgba(75, 192, 192)",
                "rgba(153, 102, 255)",
                "rgba(255, 159, 64)",
            ],
            hoverOffset: 4,
        },
    ],
};

// TODO: Implement filtering data based on the selected year
const fecthDataReportSelectedYear = async () => {
    try {
        const response = await axios.post(route("dashboard-home"), {
            selectedTransactionYear: form.selectedYearTransaction,
            selectedRevenueYear: form.selectedYearRevenue,
        });

        if (!response.data.chartDataTotalTransaction.length) {
            chartTransactionData.value = {};
            return;
        }

        if (!response.data.chartDataRevenue.length) {
            chartRevenueData.value = {};
            return;
        }

        dataRevenue.labels = response.data.chartDataRevenue.map(
            (data) => data.month,
        );

        dataRevenue.datasets[0].data = response.data.chartDataRevenue.map(
            (data) => data.total_revenue,
        );

        dataTransaction.labels = response.data.chartDataTotalTransaction.map(
            (data) => data.month,
        );

        dataTransaction.datasets[0].data =
            response.data.chartDataTotalTransaction.map(
                (data) => data.total_transaction,
            );

        chartRevenueData.value = { ...dataRevenue };
        chartTransactionData.value = { ...dataTransaction };
    } catch (e) {
        console.error(e);
    }
};

watch(
    () => form.selectedYearTransaction,
    async () => {
        // Fetch data based on the selected year
        await fecthDataReportSelectedYear();
    },
);

watch(
    () => form.selectedYearRevenue,
    async () => {
        // Fetch data based on the selected year
        await fecthDataReportSelectedYear();
    },
);

const fillChartData = () => {
    chartRevenueData.value = dataRevenue;
    chartCakeSoldData.value = dataCakeSold;
    chartTransactionData.value = dataTransaction;
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
