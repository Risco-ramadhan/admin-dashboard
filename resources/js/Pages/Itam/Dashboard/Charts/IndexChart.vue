<template>
  <div class="container my-4">
    <h5 class="fw-bold mb-3">Charts and Maps</h5>
    <hr />
    <div class="row">
      <div class="col-lg-6 col-12 my-3">
        <div class="chart-container border p-3 shadow-sm">
          <!-- Loading indicator for Pie Chart -->
          <div v-if="isLoading" class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <!-- Pie Chart -->
          <PieChart v-else :chartData="pieChartData" :colors="chartColors" />
        </div>
      </div>
      <div class="col-lg-6 col-12 my-3">
        <div class="chart-container border p-3 shadow-sm">
          <!-- Loading indicator for Bar Chart -->
          <div v-if="isLoading" class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <!-- Bar Chart -->
          <BarChart v-else :chartData="barChartData" :colors="chartColors" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import PieChart from "@/Pages/Itam/Dashboard/Charts/PieCharts.vue";
import BarChart from "@/Pages/Itam/Dashboard/Charts/BarChart.vue";

export default {
  name: "MainChart",
  components: {
    PieChart,
    BarChart,
  },
  data() {
    return {
      isLoading: true,
      pieChartData: [],
      barChartData: [],
      chartColors: [],
    };
  },
  mounted() {
    this.fetchChartData();
  },
  methods: {
    async fetchChartData() {
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_API_BASE_URL}/api/itam/dashboard/get-charts`
        );

        if (response.data.success && response.data.render) {
          const { chart, colors } = response.data.render.charts;

          // Prepare data for Pie chart
          this.pieChartData = chart.map((item) => ({
            name: item.name,
            y: item.y,
          }));

          // Prepare data for Bar chart
          this.barChartData = chart.map((item) => item.y);
          this.barChartCategories = chart.map((item) => item.name);

          // Set chart colors
          this.chartColors = colors;

          // Stop loading once data is fetched
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Failed to fetch chart data:", error);
      }
    },
  },
};
</script>

<style scoped>
.chart-container {
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  background: #f7f7f7;
}
</style>
