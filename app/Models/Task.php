<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'assignee', 'priority', 'progress', 'status','project_id', 'board_id', 'sprint_id', 'backlog_id'];

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function sprints()
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    public function backlogs()
    {
        return $this->belongsTo(Backlog::class, 'backlog_id');
    }

    public function boards()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
}
