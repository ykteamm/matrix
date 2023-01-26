<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KingSold extends Model
{
    use HasFactory;
    protected $table='tg_king_sold';
    protected $fillable = [
        'order_id',
        'image',
        'admin_check',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
