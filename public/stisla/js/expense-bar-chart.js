var expensesData = JSON.parse(document.getElementById('expensesChart').getAttribute('data-expenses'));

// Get unique dates
var uniqueDates = Array.from(new Set(expensesData.map(expense => expense.expenses_date)));

// Define an array of colors for each category
var categoryColors = [
    '#63ed7a',
    '#ffa426',
    '#fc544b',
    '#6777ef',
];

// Map category values to names
var categoryNames = [
    'Services',
    'Wages',
    'Accounting Services',
    'Office Supplies'
];

var datasets = categoryNames.map((category, index) => {
    var data = uniqueDates.map(date => {
        var matchingExpenses = expensesData.filter(expense => expense.expenses_date === date && expense.expenses_category === index);
        if (matchingExpenses.length > 0) {
            var totalAmount = matchingExpenses.reduce((sum, expense) => sum + expense.ammount, 0);
            return totalAmount;
        } else {
            return 0;
        }
    });

    return {
        label: category,
        data: data,
        backgroundColor: categoryColors[index],
        borderWidth: 0
    };
});

var ctx = document.getElementById('expensesChart').getContext('2d');
var expensesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: uniqueDates,
        datasets: datasets
    },
    options: {
        responsive: true,
        scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 0,
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function (context) {
                        var index = context[0].dataIndex;
                        return 'Date: ' + uniqueDates[index];
                    },
                    label: function (context) {
                        var index = context.dataIndex;
                        var datasetIndex = context.datasetIndex;
                        var categoryLabel = datasets[datasetIndex].label;
                        var amount = datasets[datasetIndex].data[index];

                        var matchingExpenses = expensesData.filter(expense => expense.expenses_date === uniqueDates[index] && expense.expenses_category === datasetIndex);
                        var tooltipLabel = 'Description: ' + matchingExpenses[0].description + ', Category: ' + categoryLabel + ', Amount: $' + amount;

                        return tooltipLabel;
                    }
                }
            }
        }
    }
});
