<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $table = 'tg_prices';
    protected $fillable = [
        'id',
        'price',
        'shablon_id',
        'medicine_id'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'medicine_id','id');
    }

    public function shablon()
    {
        return $this->belongsTo(Shablon::class,'shablon_id','id');
    }


}
