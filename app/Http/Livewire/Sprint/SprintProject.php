<?php

namespace App\Http\Livewire\Sprint;

use App\Models\Project;
use Livewire\Component;

class SprintProject extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.sprint.sprint-project');
    }
}
