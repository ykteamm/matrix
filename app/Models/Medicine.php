<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table='tg_medicine';
    use HasFactory;

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function shablon()
    {
        return $this->belongsTo(Shablon::class,'shablon_id','id');
    }

    public function price()
    {
        return $this->hasMany(Price::class,'medicine_id','id');
    }
    public function psold()
    {
        return $this->hasMany(ProductSold::class,'medicine_id','id');
    }
    
}