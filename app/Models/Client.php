<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'phone_number', 'status', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
