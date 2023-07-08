<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pharmacy_id',
        'user_id',
        'employee_id',
        'delivery_id',
        'payment_id',
        'number',
        'price',
        'discount',
        'status',
        'order_detail_status',
        'payment_status',
        'order_date',
        'outer'
    ];
}
