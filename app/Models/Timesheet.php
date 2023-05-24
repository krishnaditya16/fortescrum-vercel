<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = ['work_date', 'start_time', 'end_time', 'user_id', 'project_id', 'task_id', 'team_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
