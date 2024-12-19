<template>
    <div>
        <canvas ref="root"></canvas>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Legend,
    Tooltip,
} from "chart.js";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Legend,
    Tooltip,
);

let chart;
const root = ref(null);

onMounted(() => {
    chart = new Chart(root.value, {
        type: "bar",
        data: props.data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    ticks: {
                        stepSize: 1,
                    },
                },
            },
            plugins: {
                legend: {
                    display: true,
                    position: "left",
                    align: "start",
                    labels: {
                        generateLabels: (chart) => {
                            const datasets = chart.data.datasets;
                            const labels = chart.data.labels;

                            if (!datasets.length) {
                                return [];
                            }

                            return datasets[0].data.map((data, i) => {
                                return {
                                    text: `${labels[i]} :  ${data} Transaksi`,
                                    fillStyle: datasets[0].backgroundColor[i],
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
