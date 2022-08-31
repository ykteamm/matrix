<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekg extends Model
{
    protected $fillable = [
        'patient_id',       
        'ekg',       
    ];

    protected $casts = [
        'ekg' => 'array',
    ];
}
