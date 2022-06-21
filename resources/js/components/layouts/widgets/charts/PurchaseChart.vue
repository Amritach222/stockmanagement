<template>
    <div
        class="chart_container mt-2"
        style="position: relative; height: 260px; width: auto"
    >
        <canvas id="bar-chart" :style="{ height: '100%', width: '100%' }"></canvas>
    </div>
</template>
<script>
import Chart from "chart.js/auto";
import store from "../../../../store/index.js";
export default {
    name: "PurchaseChart",
    data() {
        return {
            chart: "",
            chartData: {
                type: "bar",
                data: {
                    labels: ["Approved", "Rejected", "Pending"],
                    datasets: [
                        {
                            // label: 'Purchasing Request',
                            data: this.chartDataValue(),
                            backgroundColor: [
                                "rgba(25, 135, 84,0.2)",
                                "rgba(255, 0, 0,0.2)",
                                "rgba(249,177,21,0.2)",
                            ],
                            borderColor: [
                                "rgb(25, 135, 84)",
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
    methods: {
        chartDataValue() {
            let data = store.getters["home/getTabContent"];
            return [data.approved, data.rejected, data.pending];
        },
    },

};
</script>
