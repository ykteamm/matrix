<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleDay extends Model
{
    use HasFactory;
    protected $table = 'tg_battle_day';
    protected $fillable = [
        'u1id',
        'u2id',
        'price1',
        'price2',
        'days',
        'day',
        'start_day',
        'end_day',
        'bot',
    ];
    public function u1id()
    {
        return $this->belongsTo(User::class,'u1id','id');
    }
    public function u2id()
    {
        return $this->belongsTo(User::class,'u2id','id');
    }
    
}
