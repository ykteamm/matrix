<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pharmacy_id',
        'pro_pharmacy_id',
        'user_id',
        'employee_id',
        'delivery_id',
        'number',
        'price',
        'discount',
        'order_detail_status',
        'payment_status',
        'order_date',
        'outer',
        'prepayment'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function pro_user()
    {
        return $this->belongsTo(User::class,'pro_pharmacy_id','id');
    }

    public function employe()
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }

    public function delivery()
    {
        return $this->belongsTo(McDelivery::class,'delivery_id','id');
    }

    public function payment()
    {
        return $this->belongsTo(McPayment::class,'payment_id','id');
    }

    public function order_detail()
    {
        return $this->hasMany(McOrderDetail::class,'order_id','id');
    }

    public function order_delivery()
    {
        return $this->hasMany(McOrderDelivery::class,'order_id','id');
    }


    

}
