<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShablonPharmacy extends Model
{
    use HasFactory;

    protected $table = 'tg_shablon_pharmacies';
    protected $fillable = [
        'id',
        'shablon_id',
        'pharmacy_id'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }

    public function shablon()
    {
        return $this->belongsTo(Shablon::class,'shablon_id','id');
    }
}
