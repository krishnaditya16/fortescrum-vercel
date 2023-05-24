var flowEfficiencyData = JSON.parse(
    document
        .getElementById("flowEfficiencyChart")
        .getAttribute("data-efficiency")
);
// Get the canvas element
var chartCanvas = document.getElementById("flowEfficiencyChart");

// Extract the flow efficiency values and labels from the data
var flowEfficiencyValues = [];
var flowEfficiencyLabels = [];
flowEfficiencyData.forEach(function (item) {
    flowEfficiencyValues.push(item.flowEfficiency);
    flowEfficiencyLabels.push(item.task.title);
});

// Create the chart using Chart.js
var flowEfficiencyChart = new Chart(chartCanvas, {
    type: "bar",
    data: {
        labels: flowEfficiencyLabels,
        datasets: [
            {
                label: "Flow Efficiency",
                data: flowEfficiencyValues,
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                title: {
                    display: true,
                    text: "Flow Efficiency (%)",
                },
            },
            x: {
                title: {
                    display: true,
                    text: "Task",
                },
            },
        },
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});
