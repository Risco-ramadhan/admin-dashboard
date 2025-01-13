<template>
    <highcharts :options="chartOptions" ref="pieChart"></highcharts>
</template>

<script>
import HighchartsVue from "highcharts-vue";
import Highcharts from "highcharts";

export default {
    name: "PieChart",
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
                    type: "pie",
                },
                title: {
                    text: "Asset Distribution",
                },
                plotOptions: {
                    pie: {
                        innerSize: "50%",
                        dataLabels: {
                            enabled: true,
                            format: "{point.name}: {point.percentage:.1f}%",
                        },
                    },
                },
                colors: this.colors,
                series: [
                    {
                        name: "Distribution",
                        data: this.chartData,
                    },
                ],
            };
        },
    },
};
</script>
