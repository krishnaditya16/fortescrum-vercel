<?php

namespace App\Http\Livewire\Task;

use App\Models\Project;
use Livewire\Component;

class TaskProject extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.task.task-project');
    }
}
