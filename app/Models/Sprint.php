<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'total_sp', 'start_date', 'end_date', 'focus_factor', 'project_id'];

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
