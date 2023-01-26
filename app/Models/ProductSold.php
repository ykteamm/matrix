<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSold extends Model
{
    use HasFactory;

    protected $table='tg_productssold';
    protected $fillable=[
        'number',
        'medicine_id',
        'user_id',
        'order_id',
        'price_product',
        'is_active'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'medicine_id','id');
    }
}