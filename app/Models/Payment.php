<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_date', 'invoice_payment', 'payment_type', 'transaction_id', 'notes', 'reason', 'project_id', 'invoice_id'];
}
