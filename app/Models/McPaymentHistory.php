<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McPaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'payment_id',
        'order_id',
        'amount'
    ];
}
