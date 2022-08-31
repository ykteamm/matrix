<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exo extends Model
{
    protected $fillable = [
        'patient_id',       
        'exo',       
    ];

    protected $casts = [
        'exo' => 'array',
    ];
}
