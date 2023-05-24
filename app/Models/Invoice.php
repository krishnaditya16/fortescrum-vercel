<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'issued',
        'deadline',
        'tax_percent',
        'tax_ammount',
        'discount_percent',
        'discount_ammount',
        'total_all',
        'client_id',
        'project_id',
        'task_id',
        'timesheet_id',
        'expenses_id',
        'rate_task', 
        'qty_task', 
        'total_task',
        'subtotal_task',
        'rate_ts', 
        'qty_ts', 
        'total_ts',
        'subtotal_ts',
        'exp_ammount',
        'subtotal_exp',
        'inv_status',
    ];

    public function getTotalAllAttribute()
    {
        return $this->attributes['total_all'] / 100;
    }

    public function setTotalAllAttribute($value)
    {
        return $this->attributes['total_all'] = $value * 100;
    }

    public function getTaxAmmountAttribute()
    {
        return $this->attributes['tax_ammount'] / 100;
    }

    public function setTaxAmmountAttribute($value)
    {
        return $this->attributes['tax_ammount'] = $value * 100;
    }

    public function getDiscountAmmountAttribute()
    {
        return $this->attributes['discount_ammount'] / 100;
    }

    public function setDiscountAmmountAttribute($value)
    {
        return $this->attributes['discount_ammount'] = $value * 100;
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
