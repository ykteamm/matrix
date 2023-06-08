<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirStanding extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'team1_id',
        'team2_id',
        'win',
        'lose',
        'tour',
        'date_begin',
        'date_end',
        'status',
        'month',
        'ends',
    ];
}
