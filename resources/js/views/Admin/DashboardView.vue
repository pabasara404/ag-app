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
            <div class="bar-chart-container ">
                <BarChart></BarChart>
            </div>
        </div>
      <div class="m-2 border-solid border-2 p-2 w-100 rounded-md">
        <canvas ref="lineChart"></canvas>
      </div>
      <div
        class="m-2 basis-1/4 max-h-90 border-solid border-2 w-100   rounded-md w-96 p-2"
      >
        <canvas ref="donutChart"></canvas>
      </div>
    </div>

  <!--  pending approval, issued permits, weekly highest permit count,
new user registrations with days
--></template>

//
<script setup>
import { ref, onMounted } from "vue";
import Chart from "chart.js/auto";
import BarChart from "@/components/BarChart.vue";
import PageHeader from "@/components/PageHeader.vue";

const donutChart = ref(null);
const lineChart = ref(null);

onMounted(() => {
 renderDonutChart();
 renderLineChart();
});

const renderDonutChart = () => {
 const ctx = donutChart.value.getContext("2d");
 new Chart(ctx, {
   type: "doughnut",
   data: {
     labels: ["TCP", "TTP", "BRC", "IC", "ATP", "PL", "EL", "VR"],
     datasets: [
       {
         label: "Permit Count",
         data: [300, 50, 100, 40, 120, 80, 30, 70],
         backgroundColor: [
           "rgb(255, 99, 132)",
           "rgb(54, 162, 235)",
           "rgb(255, 205, 86)",
           "rgb(75, 192, 192)",
           "rgb(153, 102, 255)",
           "rgb(255, 159, 64)",
           "rgb(0, 255, 255)",
           "rgb(255, 0, 255)",
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
 const myChart = new Chart(ctx, {
   type: "line",
   data: {
     labels: [
       "Day 1",
       "Day 2",
       "Day 3",
       "Day 4",
       "Day 5",
       "Day 6",
       "Day 7",
       "Day 8",
       "Day 9",
       "Day 10",
       "Day 11",
       "Day 12",
       "Day 13",
       "Day 14",
       "Day 15",
       "Day 16",
       "Day 17",
       "Day 18",
       "Day 19",
       "Day 20",
       "Day 21",
       "Day 22",
       "Day 23",
       "Day 24",
       "Day 25",
       "Day 26",
       "Day 27",
       "Day 28",
       "Day 29",
       "Day 30",
       "Day 31",
     ],
     datasets: [
       {
         label: "Monthly Total Income",
         data: [
             6700, 3700, 9300, 7500, 4900, 8900, 7100, 8100, 7700, 5300, 6100, 6300, 7900, 5100, 9100, 9700, 3500, 5700, 7300, 8300, 6500, 5500, 5700, 8700, 4500, 4700, 4300, 3900, 4200, 8500, 4300
         ],
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
