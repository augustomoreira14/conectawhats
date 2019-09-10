"use strict";
// Cicle Chart

var $data = $("#lineChart").data('statistics');

Circles.create({
    id: 'task-complete',
    radius: 50,
    value: $data.percent,
    maxValue: 100,
    width: 5,
    text: function (value) {
        return value + '%';
    },
    colors: ['#36a3f7', '#fff'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
});

var lineChart = document.getElementById('lineChart').getContext('2d');

var myLineChart = new Chart(lineChart, {
    type: 'line',
    data: {
        labels: $data.dates,
        datasets: [{
                label: "Convertidos",
                borderColor: "#35cd3a",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#35cd3a",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: $data.data
            }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'bottom',
            labels: {
                padding: 10,
                fontColor: '#333',
            }
        },
        tooltips: {
            bodySpacing: 4,
            mode: "nearest",
            intersect: 0,
            position: "nearest",
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10
        },
        layout: {
            padding: {left: 15, right: 15, top: 15, bottom: 15}
        }
    }
});