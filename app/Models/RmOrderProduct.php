<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'product_id','id');
    }

    public function rm_order()
    {
        return $this->belongsTo(RmOrder::class,'order_id','id');
    }
}
