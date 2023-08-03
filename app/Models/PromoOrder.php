<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'order_price',
        'promo_price',
        'money_arrival',
        'delivery_date',
        'close',
        'number',
    ];

    public function user()
    {
        return $this->belongsTo(PromoUser::class,'user_id','id');
    }

    public function orderProduct()
    {
        return $this->hasMany(PromoOrderProduct::class,'order_id','id');
    }

    public function orderStock()
    {
        return $this->hasMany(PromoOrderStock::class,'order_id','id');
    }
}
