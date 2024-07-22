<template>
    <div class="chart-container">
      <canvas ref="pieChart"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import { Pie } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale } from 'chart.js';

  ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

  const props = defineProps({
    chartData: {
      type: Object,
      required: true,
    },
  });

  const pieChart = ref(null);

  onMounted(() => {
    new Pie(pieChart.value.getContext('2d'), {
      data: props.chartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    });
  });
  </script>

  <style scoped>
  .chart-container {
    position: relative;
    width: 100%;
    height: 300px;
  }
  </style>
