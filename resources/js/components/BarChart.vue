<template>
    <div class="bar-chart-container">
        <Bar :data="chartData" :options="chartOptions" />
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip,
    Legend
} from 'chart.js';

ChartJS.register(BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend);

export default defineComponent({
    name: 'BarChart',
    components: {
        Bar
    },
    setup() {
        const statuses = [
            'Submitted',
            'Pending',
            'Resubmitted',
            'Escalated',
            'Approved',
            'Rejected',
            'Awaiting Payment',
            'Issued',
            'Ceased'
        ];

        const colors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(0, 255, 255)',
            'rgb(255, 0, 255)'
        ];

        const chartData = ref({
            labels: statuses,
            datasets: [
                {
                    label: 'Total Permits by Status',
                    backgroundColor: colors,
                    data: generateDummyData(statuses.length)
                }
            ]
        });

        const chartOptions = ref({
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Status'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    beginAtZero: true
                }
            }
        });

        function generateDummyData(length) {
            const data = [];
            for (let i = 0; i < length; i++) {
                data.push(Math.floor(Math.random() * 100));
            }
            return data;
        }

        return {
            chartData,
            chartOptions
        };
    }
});
</script>

<style scoped>
.bar-chart-container {
    position: relative;
    width: 100%;
    height: 400px;
}
</style>
