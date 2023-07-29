<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamBattleSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'image',
        'sort',
        'active'
    ];
}
