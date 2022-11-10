<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shablon extends Model
{
    use HasFactory;

    protected $table = 'tg_shablons';
    protected $fillable = [
        'id',
        'name',
        'active',
    ];

    public function medicine()
    {
        return $this->hasMany(Medicine::class,'shablon_id','id');
    }

    public function shablon_pharmacy()
    {
        return $this->hasMany(ShablonPharmacy::class,'shablon_id','id');
    }

    public function price()
    {
        return $this->hasMany(Price::class,'shablon_id','id');
    }
}
