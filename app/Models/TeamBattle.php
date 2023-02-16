<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamBattle extends Model
{
    use HasFactory;

    protected $table = 'tg_team_battles';

    protected $fillable = [
        'team1_id',
        'team2_id',
        'month',
        'round',
        'win',
        'lose',
        'start_day',
        'end_day',
        'team1_user',
        'team2_user',
    ];
}
