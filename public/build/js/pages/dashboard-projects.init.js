/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Project Dashboard init js
*/


// get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                    else return newValue;;
                } else {
                    var val = value.split(',');
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        } else {
            console.warn('data-colors Attribute not found on:', chartId);
        }
    }
}



//Radial chart data
var isApexSeriesData = {};
var isApexSeries = document.querySelectorAll("[data-chart-series]");
if (isApexSeries) {
    Array.from(isApexSeries).forEach(function (element) {
        var isApexSeriesVal = element.attributes;
        if (isApexSeriesVal["data-chart-series"]) {
            isApexSeriesData.series = isApexSeriesVal["data-chart-series"].value.toString();
            var radialbarhartoneColors = getChartColorsArray(isApexSeriesVal["id"].value.toString());
            var options = {
                series: [isApexSeriesData.series],

                chart: {
                    type: 'radialBar',
                    width: 36,
                    height: 36,
                    sparkline: {
                        enabled: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: '50%'
                        },
                        track: {
                            margin: 1
                        },
                        dataLabels: {
                            show: false
                        }
                    }
                },
                colors: radialbarhartoneColors
            };

            var chart = new ApexCharts(document.querySelector("#" + isApexSeriesVal["id"].value.toString()), options);
            chart.render();

        }
    })
}

// Project Status charts
var donutchartProjectsStatusColors = getChartColorsArray("prjects-status");
if (donutchartProjectsStatusColors) {
    var options = {
        series: [125, 42, 58, 89],
        labels: ["Completed", "In Progress", "Yet to Start", "Cancelled"],
        chart: {
            type: "donut",
            height: 230,
        },
        plotOptions: {
            pie: {
                size: 100,
                offsetX: 0,
                offsetY: 0,
                donut: {
                    size: "90%",
                    labels: {
                        show: false,
                    }
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        stroke: {
            lineCap: "round",
            width: 0
        },
        colors: donutchartProjectsStatusColors,
    };
    var chart = new ApexCharts(document.querySelector("#prjects-status"), options);
    chart.render();
}

// chat
var currentChatId = "users-chat";
scrollToBottom(currentChatId);

// Scroll to Bottom
function scrollToBottom(id) {
    setTimeout(() => {
        var scrollEl = new SimpleBar(document.getElementById('chat-conversation'));
        scrollEl.getScrollElement().scrollTop = document.getElementById("users-conversation").scrollHeight;
    }, 100);
}