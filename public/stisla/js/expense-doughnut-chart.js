// Get data from Laravel backend
var expensesData = JSON.parse(document.getElementById('expensesUsage').getAttribute('data-expenses'));
var projectBudget = JSON.parse(document.getElementById('expensesUsage').getAttribute('data-budget'));

// Calculate total expenses for each category
var categoryExpenses = [];
for (var i = 0; i < 4; i++) {
    var totalExpense = expensesData
        .filter(expense => expense.expenses_category === i)
        .reduce((sum, expense) => sum + expense.ammount, 0);
    categoryExpenses.push(totalExpense);
}

// Calculate remaining budget
var remainingBudget = projectBudget - categoryExpenses.reduce((sum, expense) => sum + expense, 0);

// Create the doughnut chart
var ctx = document.getElementById('expensesUsage').getContext('2d');
var expensesChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Services', 'Wages', 'Accounting Services', 'Office Supplies', 'Remaining Budget'],
        datasets: [{
            data: [...categoryExpenses, remainingBudget],
            backgroundColor: [
                '#63ed7a',
                '#ffa426',
                '#fc544b',
                '#6777ef',
                '#eeeee4',
            ],
            borderWidth: 2 
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Adjust the size of the doughnut chart based on the container
        plugins: {
            title: {
                display: true,
                text: 'Expenses and Remaining Budget'
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var categoryLabel = context.label;
                        var expenseAmount = context.parsed;
                        var percentage = ((expenseAmount / projectBudget) * 100).toFixed(2) + '%';

                        return categoryLabel + ': $' + expenseAmount + ' (' + percentage + ')';
                    }
                }
            }
        }
    }
});
