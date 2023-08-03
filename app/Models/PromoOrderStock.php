<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoOrderStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'product_price',
    ];

    public function stock()
    {
        return $this->belongsTo(PromoUser::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Medicine::class,'product_id','id');
    }

    public function order()
    {
        return $this->belongsTo(PromoOrder::class,'order_id','id');
    }
}
