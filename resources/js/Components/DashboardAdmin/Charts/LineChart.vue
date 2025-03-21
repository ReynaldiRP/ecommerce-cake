<script setup>
import { ref, watch, computed, onMounted } from "vue";
import {
    Chart,
    LineElement,
    PointElement,
    LineController,
    LinearScale,
    CategoryScale,
    Tooltip,
} from "chart.js";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const { formatPrice } = useAdminDashboardStore();
const root = ref(null);

let chart;

Chart.register(
    LineElement,
    PointElement,
    LineController,
    LinearScale,
    CategoryScale,
    Tooltip,
);

onMounted(() => {
    chart = new Chart(root.value, {
        type: "line",
        data: props.data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    display: false,
                },
                x: {
                    display: true,
                },
            },
            plugins: {
                legend: {
                    display: true,
                    align: "start",
                    position: "left",
                    labels: {
                        generateLabels: (chart) => {
                            const datasets = chart.data.datasets;
                            const labels = chart.data.labels;

                            if (!datasets.length) {
                                return [];
                            }

                            return datasets[0].data.map((data, i) => {
                                return {
                                    text: `${labels[i]} :  ${formatPrice(data)}`,
                                    fillStyle: datasets[0].backgroundColor,
                                    index: i,
                                };
                            });
                        },
                    },
                },
            },
        },
    });
});

const chartData = computed(() => props.data);

watch(
    chartData,
    (data) => {
        if (chart) {
            chart.data = data;
            chart.update();
        }
    },
    { deep: true },
);
</script>

<template>
    <canvas ref="root" />
</template>
