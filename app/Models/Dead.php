<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dead extends Model
{
    protected $fillable = [
        'patient_id',       
        'death',
        'treatment',       
    ];
}
