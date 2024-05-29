<template>
  <n-h2 class="p-2">Guest Dashboard</n-h2>
  <div class="bg-emerald-100">
    <div class="grid grid-rows-4 grid-flow-col gap-4">
      <div class="row-span-4 col-span-2 bg-emerald-300">
        <div class="grid grid-cols-3 grid-rows-4 gap-4">
          <div class="row-span-2 bg-teal-500"><n-card>No title</n-card></div>
          <div class="row-span-2 bg-teal-500">dgsd</div>
          <div class="row-span-2 bg-teal-500">dgsd</div>
        </div>
      </div>
      <div class="col-span-2 row-span-2 bg-teal-500">
        <div class="grid grid-cols-2 gap-4">
          <div>01</div>
          <div>02</div>
        </div>
      </div>
      <div class="col-span-2 row-span-2 bg-cyan-400">
        <div class="grid grid-cols-2 gap-4">
          <div>01</div>
          <div>02</div>
        </div>
      </div>
    </div>
  </div>

  <!--  <div class="flex flex-row">-->
  <!--    <div class="basis-3/4">-->
  <!--      <canvas ref="lineChart"></canvas>-->
  <!--    </div>-->
  <!--    <div-->
  <!--      class="basis-1/4 max-h-80 border-solid border-2 border-green-500 rounded-md w-96 p-2"-->
  <!--    >-->
  <!--      <canvas ref="donutChart"></canvas>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--  pending approval, issued permits, weekly highest permit count,
new user registrations with days
--></template>

//
<script setup>
//import { ref, onMounted } from "vue";
//import Chart from "chart.js/auto";
//
//const donutChart = ref(null);
//const lineChart = ref(null);
//
//onMounted(() => {
//  renderDonutChart();
//  renderLineChart();
//});
//
//const renderDonutChart = () => {
//  const ctx = donutChart.value.getContext("2d");
//  new Chart(ctx, {
//    type: "doughnut",
//    data: {
//      labels: ["TCP", "TTP", "BRC", "IC", "ATP", "PL", "EL", "VR"],
//      datasets: [
//        {
//          label: "Permit Count",
//          data: [300, 50, 100, 40, 120, 80, 30, 70],
//          backgroundColor: [
//            "rgb(255, 99, 132)",
//            "rgb(54, 162, 235)",
//            "rgb(255, 205, 86)",
//            "rgb(75, 192, 192)",
//            "rgb(153, 102, 255)",
//            "rgb(255, 159, 64)",
//            "rgb(0, 255, 255)",
//            "rgb(255, 0, 255)",
//          ],
//          hoverOffset: 4,
//        },
//      ],
//    },
//    options: {
//      responsive: true,
//      plugins: {
//        legend: {
//          position: "top",
//        },
//        title: {
//          display: true,
//          text: "Weekly Permit Count",
//        },
//      },
//    },
//  });
//};
//
//const renderLineChart = () => {
//  const ctx = lineChart.value.getContext("2d");
//  const myChart = new Chart(ctx, {
//    type: "line",
//    data: {
//      labels: [
//        "Day 1",
//        "Day 2",
//        "Day 3",
//        "Day 4",
//        "Day 5",
//        "Day 6",
//        "Day 7",
//        "Day 8",
//        "Day 9",
//        "Day 10",
//        "Day 11",
//        "Day 12",
//        "Day 13",
//        "Day 14",
//        "Day 15",
//        "Day 16",
//        "Day 17",
//        "Day 18",
//        "Day 19",
//        "Day 20",
//        "Day 21",
//        "Day 22",
//        "Day 23",
//        "Day 24",
//        "Day 25",
//        "Day 26",
//        "Day 27",
//        "Day 28",
//        "Day 29",
//        "Day 30",
//        "Day 31",
//      ],
//      datasets: [
//        {
//          label: "Total Permits",
//          data: [
//            10, 15, 20, 18, 25, 22, 27, 30, 28, 35, 40, 38, 42, 45, 47, 50, 48,
//            55, 52, 57, 60, 58, 65, 62, 67, 70, 68, 75, 72, 77, 80,
//          ],
//        },
//      ],
//    },
//    options: {
//      responsive: true,
//      maintainAspectRatio: false,
//      scales: {
//        y: {
//          beginAtZero: true,
//        },
//      },
//    },
//  });
//};
</script>

<style scoped>
template {
  background-color: darkseagreen;
}
</style>
