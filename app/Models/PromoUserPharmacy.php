<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoUserPharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pharmacy_id'
    ];

    public function user()
    {
        return $this->belongsTo(PromoUser::class,'user_id','id');
    }
}
