<?php

namespace App\Http\Livewire\Backlog;

use App\Models\Project;
use Livewire\Component;

class BacklogProject extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.backlog.backlog-project');
    }
}
