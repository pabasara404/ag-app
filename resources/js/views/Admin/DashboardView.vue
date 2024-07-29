<template>
    <PageHeader title="Admin Dashboard" />
    <n-grid x-gap="12" :cols="4" class="white-background">
        <n-gi>
            <div class="light-green p-2 hover-card">
                <n-h5>Monthly Transported Animal Count: 20</n-h5>
            </div>
        </n-gi>
        <n-gi>
            <div class="green p-2 hover-card">
                <n-h5>Annual Total Issued Permit Count: 53</n-h5>
            </div>
        </n-gi>
        <n-gi>
            <div class="light-green p-2 hover-card">
                <n-h5>Monthly Felled Tree Count: 12</n-h5>
            </div>
        </n-gi>
        <n-gi>
            <div class="green p-2 hover-card">
                <n-h5>Annual Registered User Count: 193</n-h5>
            </div>
        </n-gi>
    </n-grid>
    <div class="flex flex-row">
        <div id="app" class="m-2 border-solid border-2 w-100 p-2 h-90 rounded-md">
            <div class="bar-chart-container">
                <BarChart></BarChart>
            </div>
        </div>
        <div class="m-2 border-solid border-2 p-2 w-100 rounded-md">
            <canvas ref="lineChart"></canvas>
        </div>
        <div class="m-2 basis-1/4 max-h-90 border-solid border-2 w-100 rounded-md w-96 p-2">
            <canvas ref="donutChart"></canvas>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from "vue";
import Chart from "chart.js/auto";
import BarChart from "@/components/BarChart.vue";
import PageHeader from "@/components/PageHeader.vue";
import axios from 'axios';
import Http from "@/services/http.js";

const donutChart = ref(null);
const lineChart = ref(null);

onMounted(() => {
    fetchDonutChartData();
    renderLineChart();
});

const fetchDonutChartData = async () => {
    try {
        const response = await Http.get('/issuedApplicationCountsByMonthly');
        const data = response.data;
        renderDonutChart(data);
    } catch (error) {
        console.error('Failed to fetch donut chart data:', error);
    }
};

const renderDonutChart = (data) => {
    const ctx = donutChart.value.getContext("2d");
    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["TCP", "TTP", "IBRC", "FRC", "IC", "ATP", "VC"],
            datasets: [
                {
                    label: "Permit Count",
                    data: [
                        data.timber_cutting_permit_applications,
                        data.timber_transporting_applications,
                        data.individual_businesses,
                        data.firms,
                        data.income_certificates,
                        data.animal_transports,
                        data.valuations
                    ],
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)",
                        "rgb(153, 102, 255)",
                        "rgb(255, 159, 64)",
                        "rgb(0, 255, 255)"
                    ],
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Monthly Permit Count",
                },
            },
        },
    });
};

const renderLineChart = () => {
    const ctx = lineChart.value.getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: Array.from({length: 31}, (_, i) => `Day ${i + 1}`),
            datasets: [
                {
                    label: "Monthly Total Income",
                    data: Array.from({length: 31}, () => Math.floor(Math.random() * 10000)), // Dummy data
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};
</script>

<style scoped>
template {
    background-color: darkseagreen;
}

.white-background {
    background-color: white;
    padding: 10px;
    border-radius: 10px;
}

.light-green {
    height: 90px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
}

.green {
    height: 90px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
}

.hover-card {
    transition: box-shadow 0.3s ease-in-out;
}

.hover-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
