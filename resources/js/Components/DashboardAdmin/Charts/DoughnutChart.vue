<template>
    <div>
        <canvas ref="root"></canvas>
    </div>
</template>
<script setup>
import { computed, onMounted, ref, watch } from "vue";
import {
    Chart,
    DoughnutController,
    ArcElement,
    Tooltip,
    Legend,
} from "chart.js";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

let chart;
const root = ref(null);

onMounted(() => {
    chart = new Chart(root.value, {
        type: "doughnut",
        data: props.data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "left",
                    align: "start",
                    labels: {
                        generateLabels: (chart) => {
                            const datasets = chart.data.datasets;
                            const labels = chart.data.labels;

                            if (!datasets.length) {
                                return [];
                            }

                            return datasets[0].data.map((_, i) => {
                                return {
                                    text: `${labels[i]}: ${datasets[0].data[i]} Pcs`,
                                    fillStyle: datasets[0].backgroundColor[i],
                                    hidden:
                                        isNaN(datasets[0].data[i]) ||
                                        datasets[0].data[i] === 0,
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

watch(chartData, (data) => {
    if (chart) {
        chart.data = data;
        chart.update();
    }
});
</script>
