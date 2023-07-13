<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McOrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'order_detail_id',
        'warehouse_id',
        'product_id',
        'quantity',
        'price'
    ];  
}
