<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElchiLevel extends Model
{
    use HasFactory;
    protected $table='tg_elchi_level';
    protected $fillable = [
        'user_id',
        'level'
    ];
}
