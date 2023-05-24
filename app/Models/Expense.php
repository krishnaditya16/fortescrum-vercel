<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'expenses_date', 'ammount', 'expenses_category', 'expenses_status', 'team_member', 'receipt', 'project_id'];

    public function getAmmountAttribute()
    {
        return $this->attributes['ammount'] / 100;
    }

    public function setAmmountAttribute($value)
    {
        return $this->attributes['ammount'] = $value * 100;
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'team_member');
    }
}
