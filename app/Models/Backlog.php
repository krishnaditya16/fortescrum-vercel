<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sprint_name', 'description', 'story_point', 'project_id', 'sprint_id'];

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function sprints()
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    public function tasks()
    {
        return $this->hasOne(Task::class, 'backlog_id');
    }
}
