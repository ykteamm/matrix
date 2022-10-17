<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSold extends Model
{
    protected $table='tg_productssold';
    protected $fillable=[
        'number',
        'medicine_id',
        'user_id',
        'order_id',
        'price_product',
        'is_active'
    ];
    use HasFactory;
}