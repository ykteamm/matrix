<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElchiUserExercise extends Model
{
    use HasFactory;
    protected $table='tg_elchi_user_exercise';
    protected $fillable = [
        'user_id',
        'medicine_id',
        'number',
        'elexir',
        'ball',
    ];
}
