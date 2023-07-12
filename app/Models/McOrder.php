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
        'user_id',
        'employee_id',
        'delivery_id',
        'payment_id',
        'number',
        'price',
        'discount',
        'status',
        'order_detail_status',
        'payment_status',
        'order_date',
        'outer'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
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

    

}
