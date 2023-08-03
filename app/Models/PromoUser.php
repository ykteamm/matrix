<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'phone_number',
        'password',
        'lat',
        'long',
        'pharmacy',
        'pass',
    ];


    public function order()
    {
        return $this->hasMany(PromoOrder::class,'user_id','id');
    }

    public function stock()
    {
        return $this->hasMany(PromoOrderStock::class,'user_id','id');
    }

    public function pharmacy()
    {
        return $this->hasMany(PromoUserPharmacy::class,'user_id','id');
    }

    public function history_money()
    {
        return $this->hasMany(PromoHistoryMoney::class,'user_id','id');
    }
}
