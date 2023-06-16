<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirPlayoff extends Model
{
    use HasFactory;
    protected $fillable = [
        'month',
        'node',
        'to',
        'battle_id'
    ];
}
