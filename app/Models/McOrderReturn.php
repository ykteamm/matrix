<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McOrderReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'warehouse_id',
        'product_id',
        'quantity',
        'price'
    ];  
}
