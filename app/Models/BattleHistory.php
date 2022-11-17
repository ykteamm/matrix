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
        'start_day',
        'end_day',
        'ball1',
        'ball2',
    ];
}
