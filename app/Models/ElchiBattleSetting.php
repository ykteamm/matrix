<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElchiBattleSetting extends Model
{
    use HasFactory;
    protected $table = 'tg_elchi_battle_settings';
    protected $fillable = [
        'start_day',
        'end_day',
    ];
}
