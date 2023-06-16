<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirTour extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour',
        'date_begin',
        'date_end',
        'month',
        'title'
    ];
}
