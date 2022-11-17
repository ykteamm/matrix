<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleHistory extends Model
{
    use HasFactory;
    protected $table = 'tg_battle_histories';
    protected $fillable = [
        'win_user_id',
        'lose_user_id',
        'day1',
        'day2',
        'start_day',
        'end_day',
        'ball1',
        'ball2',
        'uball1',
        'uball2',
    ];
}
