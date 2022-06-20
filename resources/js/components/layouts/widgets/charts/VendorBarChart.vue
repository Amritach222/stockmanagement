<template>
    <div
        class="chart_container mt-2"
        style="position: relative; height: 285px; width: auto"
        v-if="(currentState = 'requset')"
    >
        <canvas id="bar-chart" :style="{ height: '100%', width: '100%' }"></canvas>
    </div>
</template>
<script>
import Chart from "chart.js/auto";
import store from "../../../../store/index.js";
export default {
    name: "VendorBarChart",
    data() {
        return {
            chart: "",
            chartData: {
                type: "bar",
                data: {
                    labels: ["Proposal Request", "Quotations", "Purchase Order", "Invoices"],
                    datasets: [
                        {
                            // label: 'Purchasing Request',
                            data: [12,24,32,16],
                            backgroundColor: [
                                "rgba(25, 135, 84,0.2)",
                                "rgba(144, 238, 144,0.2)",
                                "rgba(255, 0, 0,0.2)",
                                "rgba(249,177,21,0.2)",
                            ],
                            borderColor: [
                                "rgb(25, 135, 84)",
                                "rgb(144, 238, 144)",
                                "rgb(255, 0, 0)",
                                "rgb(249,177,21)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.yLabel;
                                },
                            },
                        },
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: false,
                                },
                            },
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }

                                    },
                                },
                                gridLines: {
                                    display: false,
                                },
                            },
                        ],
                    },
                },
            },
        };
    },
    mounted() {
        const ctx = document.getElementById("bar-chart");
        this.chart = new Chart(ctx, this.chartData);
    },
    computed: {

    },
    methods: {
        chartDataValue() {
            let data = store.getters["home/getTabContent"];
            return [data.approved, 0, data.rejected, data.pending];
        },
    },
};
</script>
