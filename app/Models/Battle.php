<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;
    protected $table = 'tg_battle';
    protected $fillable = [
        'start_day',
        'end_day',
        'created_at',
        'user1_id',
        'user2_id',
        'bot',
        'end',
        'sum1',
        'sum2',
    ];
}
