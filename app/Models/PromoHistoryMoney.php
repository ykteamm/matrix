<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoHistoryMoney extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'money',
        'add_date'
    ];

    public function user()
    {
        return $this->belongsTo(PromoUser::class,'user_id','id');
    }
}
