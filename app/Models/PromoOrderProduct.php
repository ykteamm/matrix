<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_price',
    ];

    public function order()
    {
        return $this->belongsTo(PromoOrder::class,'order_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Medicine::class,'product_id','id');
    }
}
