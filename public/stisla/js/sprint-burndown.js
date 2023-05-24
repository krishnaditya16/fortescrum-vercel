document.addEventListener('DOMContentLoaded', function () {
    const chartData = JSON.parse(
        document
            .getElementById("burndownChart")
            .getAttribute("data-sprint")
    );
    const idealBurndownData = JSON.parse(
        document
            .getElementById("burndownChart")
            .getAttribute("data-ideal")
    );

    const ctx = document.getElementById('burndownChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(data => data.date),
            datasets: [
                {
                    label: 'Actual Effort',
                    data: chartData.map(data => data.remaining_sp),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false,
                },
                {
                    label: 'Ideal Effort',
                    data: idealBurndownData.map(data => data.remaining_sp),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false,
                }
            ],
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Remaining Story Points'
                    }
                }
            },
        },
    });
});