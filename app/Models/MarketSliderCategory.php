<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketSliderCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'active',
    ];
}
