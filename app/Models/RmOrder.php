<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'number',
        'status',
        'date',
        'discount',
        'summa',
        'discount_summa',
        'pharmacy_id',
        'user_id',
        'outer',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }

    public function orderproduct()
    {
        return $this->hasMany(RmOrderProduct::class,'order_id','id');
    }

}
