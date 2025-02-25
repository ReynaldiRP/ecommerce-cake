<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <!--     Heading and export report button        -->
            <section class="flex justify-between items-center">
                <div class="flex flex-col">
                    <h1 class="font-bold text-2xl">Dashboard Home</h1>
                    <small class="text-lg"
                        >Data pemesanan dalam kurun waktu 3 bulan
                        terkahir</small
                    >
                </div>
                <button
                    class="btn btn-outline btn-info"
                    @click="modalActive = true"
                >
                    <i class="fa-solid fa-file-export"></i>
                    Export Laporan
                </button>
                <CardBoxModal
                    v-model="modalActive"
                    title="Export Laporan"
                    class="backdrop-contrast-50"
                    button-label="Download Laporan"
                    button="success"
                    :click-handler="exportReport"
                >
                    <label class="form-control w-full max-w-xs">
                        <span class="text-sm m-0 p-0">
                            Pilih jenis laporan.
                        </span>
                        <select
                            class="select select-ghost select-bordered w-full max-w-xs"
                            @change="
                                onChangeReportType($event.target.selectedIndex)
                            "
                        >
                            <option disabled selected>
                                Pilih Jenis Laporan
                            </option>
                            <option
                                v-for="(report, index) in reportType"
                                :value="report.value"
                                :key="index"
                            >
                                {{ report.name }}
                            </option>
                        </select>
                    </label>
                    <section class="flex gap-4">
                        <label class="form-control w-full max-w-xs">
                            <span class="text-sm m-0 p-0">
                                Pilih periode tahun.
                            </span>
                            <select
                                class="select select-ghost select-bordered w-full max-w-xs"
                                @change="
                                    onChangeExportYear(
                                        $event.target.selectedIndex,
                                    )
                                "
                            >
                                <option disabled selected>
                                    Pilih Periode Tahun
                                </option>
                                <option
                                    v-for="(year, index) in years"
                                    :value="year.value"
                                    :key="index"
                                >
                                    {{ year.name }}
                                </option>
                            </select>
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <span class="text-sm m-0 p-0">
                                Pilih periode laporan.
                            </span>
                            <select
                                class="select select-ghost select-bordered w-full max-w-xs"
                                @change="
                                    onChangeExportMonth(
                                        $event.target.selectedIndex,
                                    )
                                "
                            >
                                <option disabled selected>
                                    Pilih Periode Laporan
                                </option>
                                <option
                                    v-for="(month, index) in months"
                                    :value="month.value"
                                    :key="index"
                                >
                                    {{ month.name }}
                                </option>
                            </select>
                        </label>
                    </section>
                </CardBoxModal>
            </section>
            <!--     Report card data       -->
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
                    :icon="mdiCash"
                    label="Rata - Rata Pendapatan"
                    :value="formatPrice(averageRevenue)"
                    :trend="evaluateTrend(averageRevenue, 0)"
                    :trend-type="evaluateTrend(averageRevenue, 0)"
                    color="text-base-300 dark:text-white"
                />
                <!--                <CardBoxWidget-->
                <!--                    :icon="mdiChartBellCurveCumulative"-->
                <!--                    label="Persentase Pertumbuhan Pendapatan"-->
                <!--                    suffix="%"-->
                <!--                    :number="growthRevenuePerMonthByPercentage"-->
                <!--                    :trend="evaluateTrend(growthRevenuePerMonthByPercentage, 0)"-->
                <!--                    :trend-type="-->
                <!--                        evaluateTrend(growthRevenuePerMonthByPercentage, 0)-->
                <!--                    "-->
                <!--                    color="text-base-300 dark:text-white"-->
                <!--                />-->
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
            <!--     Chart data       -->
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
                            <option value="2025">2025</option>
                        </select>
                    </label>
                </div>
                <CardBox>
                    <LineChart :data="chartRevenueData" class="h-96" />
                </CardBox>
                <div class="flex justify-between items-center">
                    <h1 class="font-bold text-2xl">Grafik Penjualan Kue</h1>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text font-bold ms-auto"
                                >Pilih Tahun Transaksi</span
                            >
                        </div>
                        <select
                            class="select select-bordered"
                            v-model="form.selectedYearCakeSold"
                        >
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </label>
                </div>
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
                            <option value="2025">2025</option>
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
import { Inertia } from "@inertiajs/inertia";
import NumberDynamic from "@/Components/DashboardAdmin/NumberDynamic.vue";
import BaseLevel from "@/Components/DashboardAdmin/BaseLevel.vue";
import PillTagTrend from "@/Components/DashboardAdmin/PillTagTrend.vue";
import DoughnutChart from "@/Components/DashboardAdmin/Charts/DoughnutChart.vue";
import BarChart from "@/Components/DashboardAdmin/Charts/BarChart.vue";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import axios from "axios";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";

const props = defineProps({
    totalRevenue: Number,
    totalCakeSold: Number,
    mostPopularCake: Object,
    mostPopularCakeType: Object,
    mostPopularCakeCategory: Object,
    growthRevenuePerMonthByPercentage: Number,
    averageRevenue: Number,
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
const modalActive = ref(false);

const years = [
    { name: "2020", value: "2020" },
    { name: "2021", value: "2021" },
    { name: "2022", value: "2022" },
    { name: "2023", value: "2023" },
    { name: "2024", value: "2024" },
    { name: "2025", value: "2025" },
];
const months = [
    { name: "Januari", value: "01" },
    { name: "Februari", value: "02" },
    { name: "Maret", value: "03" },
    { name: "April", value: "04" },
    { name: "Mei", value: "05" },
    { name: "Juni", value: "06" },
    { name: "Juli", value: "07" },
    { name: "Agustus", value: "08" },
    { name: "September", value: "09" },
    { name: "Oktober", value: "10" },
    { name: "November", value: "11" },
    { name: "Desember", value: "12" },
];

const reportType = [
    {
        name: "Laporan Penjualan Kue Terlaris",
        value: "product-performance-report",
    },
    { name: "Laporan Transaksi Penjualan", value: "sales-performance-report" },
];

const form = reactive({
    selectedReportType: "",
    selectedExportMonth: "",
    selectedExportYear: "",
    selectedYearTransaction: "2024",
    selectedYearRevenue: "2024",
    selectedYearCakeSold: "2024",
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
                "rgba(255, 99, 132)",
                "rgba(255, 159, 64)",
                "rgba(255, 205, 86)",
                "rgba(75, 192, 192)",
                "rgba(54, 162, 235)",
                "rgba(153, 102, 255)",
                "rgba(201, 203, 207)",
                "rgba(255, 99, 71)",
                "rgba(144, 238, 144)",
                "rgba(173, 216, 230)",
                "rgba(255, 182, 193)",
            ],
            borderWidth: 1,
        },
    ],
};

/**
 * Aggregates the chart data for cakes sold by summing the sold quantities of cakes with the same name.
 *
 * @param {Array} chartData - The array of chart data objects, each containing `cake_name` and `sold_quantity`.
 * @returns {Array} - The aggregated chart data with unique cake names and their total sold quantities.
 */
const aggregateChartDataCakeSold = (chartData) => {
    return chartData.reduce((acc, data) => {
        const existingData = acc.find(
            (item) => item.cake_name === data.cake_name,
        );

        if (existingData) {
            existingData.sold_quantity += data.sold_quantity;
        } else {
            acc.push({ ...data });
        }

        return acc;
    }, []);
};
const dataCakeSold = {
    labels: props.chartDataCakeSold.map((data) => data.cake_name) ?? [],
    datasets: [
        {
            label: "Terjual",
            data:
                aggregateChartDataCakeSold(props.chartDataCakeSold).map(
                    (data) => data.sold_quantity,
                ) ?? [],
            backgroundColor: props.chartDataCakeSold.map(() => {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                return `rgba(${r}, ${g}, ${b})`;
            }),
            hoverOffset: 4,
        },
    ],
};

/**
 * Handles the change of export report month based on the selected index.
 *
 * @param {number} index - The index of the selected date in the months array.
 */
const onChangeReportType = (index) => {
    // Get the transaction date based on the selected date
    form.selectedReportType = reportType[index - 1].value;
};

/**
 * Handles the change of export report month based on the selected index.
 *
 * @param {number} index - The index of the selected date in the months array.
 */
const onChangeExportYear = (index) => {
    // Get the transaction date based on the selected date
    form.selectedExportYear = years[index - 1].value;
    console.log(form.selectedExportYear);
};

/**
 * Handles the change of export report month based on the selected index.
 *
 * @param {number} index - The index of the selected date in the months array.
 */
const onChangeExportMonth = (index) => {
    // Get the transaction date based on the selected date
    form.selectedExportMonth = months[index - 1].value;
};

/**
 * Fetches the report data for the selected year and updates the chart data.
 *
 * @async
 * @function fetchDataReportSelectedYear
 * @returns {Promise<void>} - A promise that resolves when the data is fetched and charts are updated.
 */
const fetchDataReportSelectedYear = async () => {
    try {
        const response = await axios.post(route("dashboard-home"), {
            selectedTransactionYear: form.selectedYearTransaction,
            selectedRevenueYear: form.selectedYearRevenue,
            selectedCakeSoldYear: form.selectedYearCakeSold,
        });

        const {
            chartDataTotalTransaction,
            chartDataRevenue,
            chartDataCakeSold,
        } = response.data;

        if (!chartDataTotalTransaction.length) {
            chartTransactionData.value = {};
            return;
        }

        if (!chartDataCakeSold.length) {
            chartCakeSoldData.value = {};
            return;
        }

        if (!chartDataRevenue.length) {
            chartRevenueData.value = {};
            return;
        }

        dataRevenue.labels = chartDataRevenue.map((data) => data.month);
        dataRevenue.datasets[0].data = chartDataRevenue.map(
            (data) => data.total_revenue,
        );

        dataCakeSold.labels = chartDataCakeSold.map((data) => data.cake_name);
        dataCakeSold.datasets[0].data = aggregateChartDataCakeSold(
            chartDataCakeSold,
        ).map((data) => data.sold_quantity);

        dataTransaction.labels = chartDataTotalTransaction.map(
            (data) => data.month,
        );
        dataTransaction.datasets[0].data = chartDataTotalTransaction.map(
            (data) => data.total_transaction,
        );

        chartRevenueData.value = { ...dataRevenue };
        chartCakeSoldData.value = { ...dataCakeSold };
        chartTransactionData.value = { ...dataTransaction };
    } catch (e) {
        console.error(e);
    }
};

watch(
    [
        () => form.selectedYearTransaction,
        () => form.selectedYearRevenue,
        () => form.selectedYearCakeSold,
    ],
    async () => {
        // Fetch data based on the selected year
        await fetchDataReportSelectedYear();
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

/**
 * Export report based on selected report.
 *
 * @returns {void}
 */
const exportReport = () => {
    Inertia.get(route(`export.${form.selectedReportType}`), {
        year: form.selectedExportYear,
        month: form.selectedExportMonth,
    });
};
</script>
