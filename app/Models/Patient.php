<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'pinfl',
        'passport',
        'first_name',
        'last_name',
        'full_name',
        'phone',
        'birth_day',
        'age',
        'province_id',
        'district_id',
        'height',
        'weight',
        'bmi',
        'gender',
        'case_number',
        'case_date',
        'admission',
        'diagnos',
        'illness',
        'patient_exam',
        'ekg_id',
        'exo_id',
        'admission',
        'treatment',
        'patient_back',
        'temp',
    ];

    protected $casts = [
        'diagnos' => 'array',
        'illness' => 'array',
        'patient_exam' => 'array',
        'treatment' => 'array',
    ];
}
