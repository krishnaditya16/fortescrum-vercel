<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['current_progress', 'notes', 'user_id', 'project_id', 'task_id'];

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
