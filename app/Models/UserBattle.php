<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBattle extends Model
{
    use HasFactory;

    protected $fillable = [
        'u1id',
        'u2id',
        'price1',
        'price2',
        'win',
        'lose',
        'ball1',
        'ball2',
        'uball1',
        'uball2',
        'days',
        'day',
        'start_day',
        'end_day',
        'bot',
        'ends',
    ];
    
}
