<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tg_products';
    protected $fillable = [
        'id',
        'p_name',
        'amount',
        'code',
        'warehouse_id',
        'product_category_id',
    ];
}
