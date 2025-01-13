<template>
    <highcharts :options="chartOptions" ref="barChart"></highcharts>
</template>

<script>
import HighchartsVue from "highcharts-vue";
import Highcharts from "highcharts";

export default {
    name: "BarChart",
    components: {
        highcharts: HighchartsVue.component,
    },
    props: {
        chartData: {
            type: Array,
            required: true,
        },
        colors: {
            type: Array,
            required: true,
        },
    },
    computed: {
        chartOptions() {
            return {
                chart: {
                    type: "column",
                },
                title: {
                    text: "Asset Distribution",
                },
                xAxis: {
                    categories: this.barChartCategories,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "Value",
                    },
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                        },
                    },
                },
                colors: this.colors,
                series: [
                    {
                        name: "Distribution",
                        data: this.chartData.map((y, index) => ({
                            y,
                            color: this.colors[index],
                        })),
                        colorByPoint: true, // Ensures each bar has its own color
                    },
                ],
            };
        },
    },
    data() {
        return {
            barChartCategories: [], // Categories will come from the main chart
        };
    },
};
</script>
