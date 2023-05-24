<?php

namespace App\Http\Livewire\Expense;

use App\Models\Project;
use Livewire\Component;

class ExpenseProject extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.expense.expense-project');
    }
}
