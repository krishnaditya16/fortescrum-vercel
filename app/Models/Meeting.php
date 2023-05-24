<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'meeting_date', 'start_time', 'end_time', 'type', 'meeting_link', 'meeting_location', 'project_id', 'team_id'];
}
