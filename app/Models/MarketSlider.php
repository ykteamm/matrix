<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(MarketSliderCategory::class,'category_id','id');
    }
}
