<template>
  <MainLayout>
    <div class="container my-4">
      <h5 class="fw-bold mb-3">Charts and Maps</h5>
      <hr />
      <div class="row">
        <div class="col-lg-6 col-12 my-3">
          <div class="chart-container border p-3 shadow-sm">
            <highcharts :options="chartOptions"></highcharts>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import "highcharts/modules/accessibility";
import Highcharts from "highcharts";
import HighchartsVue from "highcharts-vue";
import axios from "axios";

export default {
  name: "ItamPieChart",
  components: {
    highcharts: HighchartsVue.component,
  },

  data() {
    return {
      chartOptions: {
        chart: {
          type: "pie",
        },
        title: {
          text: "Sales Distribution by Product",
        },
        plotOptions: {
          pie: {
            innerSize: "50%", // Donut style
            dataLabels: {
              enabled: true,
              format: "{point.name}: {point.percentage:.1f}%", // Formatting the data labels
            },
          },
        },
        colors: ["#FF5733", "#33FF57", "#3357FF"], // Customize segment colors
        legend: {
          enabled: true, // Enable the legend
          layout: "horizontal", // Align the legend horizontally
          align: "center", // Center the legend
          verticalAlign: "bottom", // Place the legend at the bottom
          borderWidth: 0, // Remove the border of the legend
          itemStyle: {
            fontSize: "14px", // Set the legend font size
          },
        },
        series: [
          {
            name: "Sales Distribution", // Series name
            data: [
              { value: "Product A", y: 29.9 },
              { value: "Product B", y: 71.5 },
              { value: "Product C", y: 106.4 },
            ],
          },
        ],
      },
    };
  },
};
</script>

<style scoped>
.chart-container {
  height: 400px; /* Set a fixed height for the chart */
}

.highcharts-figure {
  width: 100%;
}
</style>
