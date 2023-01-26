<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='tg_order';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function sold()
    {
        return $this->hasMany(ProductSold::class,'order_id','id');
    }
    public function king_sold()
    {
        return $this->hasMany(KingSold::class,'order_id','id');
    }
}
